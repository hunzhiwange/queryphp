<?php
/* [$WindsForce] (C)WindsForce TEAM Since 2012.03.17.
   登录验证类($$)*/

!defined('Q_PATH') && exit;

class Auth{

	protected static $_sErrorMessage='';
	
	public static function checkLogin($sUsername,$sPassword,$bEmail=false,$nLoginTime=86400,$nOnlyCheck=false){
		if($bEmail===true){// E-mail
			$sPn='user_email';
		}else{
			$sPn='user_name';
		}

		$oMember=UserModel::F(array($sPn=>$sUsername))->getOne();
		if(empty($oMember->user_id)){
			self::$_sErrorMessage=Q::L('我们无法找到%s这个用户','__QEEPHP__@Q',null,$sUsername);
			return false;
		}

		if($oMember->user_status<1){// 查看用户是否禁用
			self::$_sErrorMessage=Q::L('用户%s的账户还没有解锁，你暂时无法登录' ,'__QEEPHP__@Q',null,$sUsername);
			return false;
		}

		if(!self::checkPassword_($sPassword,$oMember->user_password,$oMember->user_random)){// 验证密码
			self::$_sErrorMessage=Q::L('用户%s的密码错误','__QEEPHP__@Q',null,$sUsername);
			return false;
		}

		if($nOnlyCheck===true){
			return $oMember;
		}

		// 更新登录次数、时间、IP
		if(isset($_POST['user_password'])){
			unset($_POST['user_password']);
		}
		$oMember->changeProp('user_logincount',$oMember['user_logincount']+1);
		$oMember->changeProp('user_lastlogintime',CURRENT_TIMESTAMP);
		$oMember->changeProp('user_lastloginip',C::getIp());
		$oMember->save('update');
		if($oMember->isError()){
			self::$_sErrorMessage=$oMember->getErrorMessage();
			return false;
		}

		// COOKIE数据
		$arrCookie['user_id']=$oMember->user_id;
		$arrCookie['is_admin']='n';
		$arrAdmins=$GLOBALS['_commonConfig_']['ADMIN_USERID']?explode(',',$GLOBALS['_commonConfig_']['ADMIN_USERID']):array(1);
		if(in_array($oMember->user_id,$arrAdmins)){
			$arrCookie['is_admin']='y';
		}
		$arrCookie['user_password']=$oMember['user_password'];
		self::sendCookie($arrCookie,$nLoginTime);
		Q::cookie($GLOBALS['_commonConfig_']['RBAC_DATA_PREFIX'].'new',1);

		return $oMember;
	}

	public static function changePassword($sUsername,$sNewPassword,$sOldPassword,$bIgnoreOldPassword=false){
		$sPn=is_int($sUsername)?'user_id':'user_name';
		$oMember=UserModel::F(array($sPn=>$sUsername))->query();

		if(empty($oMember['user_id'])){
			self::$_sErrorMessage=Q::L('我们无法找到%s这个用户' ,'__QEEPHP__@Q',null,$sUsername);
			return false;
		}

		if(isset($_POST['user_password'])){
			unset($_POST['user_password']);
		}
		
		if(!$bIgnoreOldPassword){
			if(!self::checkPassword_($sOldPassword,$oMember['user_password'],$oMember['user_random'])){
				self::$_sErrorMessage=Q::L('用户输入的旧密码错误','__QEEPHP__@Q');
				return false;
			}
		}

		$oMember->changeProp('user_password',self::encodePassword_($sNewPassword,$oMember['user_random']));
		$oMember->save('update');
		if($oMember->isError()){
			self::$_sErrorMessage=$oMember->getErrorMessage();
			return false;
		}

		return true;
	}

	public static function loginOut(){
		Q::cookie($GLOBALS['_commonConfig_']['RBAC_DATA_PREFIX'].'auth',null,-1);
	}

	private static function sendCookie($arrCookie,$nLoginTime=null){
		Q::cookie($GLOBALS['_commonConfig_']['RBAC_DATA_PREFIX'].'auth',
			C::authcode(
				$arrCookie['user_id']."\t".
				$arrCookie['is_admin']."\t".
				$arrCookie['user_password'],
				false,NULL,0
			),
			$nLoginTime
		);
	}

	private static function checkPassword_($sCleartext,$sCryptograph,$sRanDom=''){
		return md5(md5($sCleartext).$sRanDom)==$sCryptograph;
	}

	private static function encodePassword_($sCleartext,$sRandom){
		return md5(md5($sCleartext).$sRandom);
	}

	public static function isError(){
		return !empty(self::$_sErrorMessage);
	}

	public static function getErrorMessage(){
		return self::$_sErrorMessage;
	}

}
