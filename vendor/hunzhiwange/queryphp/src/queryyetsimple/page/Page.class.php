<?php
/* [$QeePHP] (C)WindsForce TEAM Since 2010.10.04.
   Page分页处理类($$)*/

!defined('Q_PATH') && exit;

class Page{

	protected $_nCount;
	protected $_nSize;
	protected $_nPage;
	protected $_nPageStart;
	protected $_nPageCount;
	protected $_nPageI;
	protected $_nPageUb;
	protected $_nPageLimit;
	protected static $_oDefaultDbIns=null;
	protected $_sPagename='page';
	protected $_sUrl='';
	protected $_sPrefixUrl='';
	protected $_sParameter;
	protected $_arrDefault=array(
		// URL
		'urlsuffix'=>true,

		// 标签和样式
		'id'=>'pagenav',
		'style'=>'span',
		'current'=>'current',
		'disabled'=>'disabled',

		// 语言
		'total'=>'Total:',
		'none'=>'None',
		'home'=>'Home',
		'first'=>'&laquo; First',
		'previous'=>'Previous',
		'prev'=>'&#8249; Prev',
		'page'=>'Page %d',
		'next'=>'Next',
		'nexts'=>'Next &#8250;',
		'last'=>'Last',
		'lasts'=>'Last &raquo;',

		// 界面配置
		'template'=>'{total} {first} {prev} {main} {next} {last}',
	);

	protected function __construct($nCount=0,$nSize=1,$sUrl='',$sParameter='',$nPage=null){
		if($nPage===null && isset($_GET['page'])){
			$nPage=$_GET['page'];
		}
		
		// 页码分析
		$this->_nCount=intval($nCount);
		$this->_nSize=intval($nSize);
		$this->_nPage=intval($nPage);
		
		if($this->_nPage<1){
			$this->_nPage=1;
		}
		if($this->_nCount<1){
			$this->_nPage=0;
		}

		$this->_nPageLimit=($this->_nPage*$this->_nSize)-$this->_nSize;
		$this->_nPageCount=ceil($this->_nCount/$this->_nSize); 
		if($this->_nPageCount<1){
			$this->_nPageCount=1;
		}

		if($this->_nPage>$this->_nPageCount){
			$this->_nPage=$this->_nPageCount; 
		}

		$this->_nPageI=$this->_nPage-2;
		$this->_nPageUb=$this->_nPage+2;
		if($this->_nPageI<1){
			$this->_nPageUb=$this->_nPageUb+(1-$this->_nPageI);
			$this->_nPageI=1;
		}

		if($this->_nPageUb>$this->_nPageCount){
			$this->_nPageI=$this->_nPageI-($this->_nPageUb-$this->_nPageCount);
			$this->_nPageUb=$this->_nPageCount;
			if($this->_nPageI<1){
				$this->_nPageI=1;
			}
		}

		$this->_nPageStart=($nPage-1)*$this->_nSize;
		if($this->_nPageStart<0){
			$this->_nPageStart=0;
		}
	
		// 参数
		$this->_sUrl=$sUrl;
		$this->_sParameter=$sParameter;
	}

	public static function RUN($nCount=0,$nSize=1,$sUrl='',$sParameter='',$nPage=null,$bDefaultIns=true){
		if($bDefaultIns and self::$_oDefaultDbIns){
			return self::$_oDefaultDbIns;
		}

		$oPage=new self($nCount,$nSize,$sUrl,$sParameter,$nPage);// 创建一个分页对象
		if($bDefaultIns){// 设置全局对象
			self::$_oDefaultDbIns=$oPage;
		}

		return $oPage;
	}

	public function P($arrOption=array(),$sPagename='page'){
		// 读取配置
		$arrDefault=$this->_arrDefault;
		if(!empty($arrOption)){
			$arrDefault=array_merge($arrDefault,$arrOption);
		}

		if(!empty($sPagename)){
			$this->_sPagename=$sPagename;
		}

		// 分离前缀
		if(strpos($this->_sUrl,'@~')!==false){
			$arrTemp=explode('@~',$this->_sUrl);
			$this->_sUrl=$arrTemp[1];
			$this->_sPrefixUrl=$arrTemp[0];
		}

		// 当前URL分析
		if(!empty($this->_sUrl)){
			if(strpos($this->_sUrl,'@')===0){
				$sUrl=Q::U(ltrim($this->_sUrl,'@'),false===strpos($this->_sUrl,'{page}')?array($this->_sPagename=>'{page}'):array());
			}else{
				$sDepr=$GLOBALS['_commonConfig_']['URL_PATHINFO_DEPR'];
				$sUrl=str_replace('//','/',rtrim(Q::U('/'.$this->_sUrl,array(),false,false,false===strpos($this->_sUrl,'{page}')?false:true),$sDepr));
				false===strpos($sUrl,'{page}') && $sUrl.=$sDepr.'{page}'.($arrDefault['urlsuffix'] && $GLOBALS['_commonConfig_']['URL_HTML_SUFFIX']?$GLOBALS['_commonConfig_']['URL_HTML_SUFFIX']:'');
			}
		}else{
			if($this->_sParameter && is_string($this->_sParameter)){
				parse_str($this->_sParameter,$arrParameter);
			}elseif(is_array($this->_sParameter)){
				$arrParameter=$this->_sParameter;
			}elseif(empty($this->_sParameter)){
				if(isset($_GET['parameter'])){
					unset($_GET['parameter']);
				}
				$arrVar=!empty($_POST)?$_POST:$_GET;
				if(empty($arrVar)){
					$arrParameter=array();
				}else{
					$arrParameter=$arrVar;
				}
			}

			$arrParameter[$this->_sPagename]='{page}';
			$sUrl=Q::U($this->_sPrefixUrl?$this->_sPrefixUrl.'~@':'',$arrParameter);
		}
		$this->_sUrl=$sUrl;
		
		// 分页数据
		$arrPagedata=array();

		// 初始化
		$bLiStyle=$arrDefault['style']=='li'?true:false;
		$sLiheader=$sLifooter=$sLiAheader=$sLiAfooter='';
		if($bLiStyle){
			$sLiheader='<li>';
			$sLifooter='</li>';
			$sLiAheader='<a>';
			$sLiAfooter='</a>';
		}

		// 头部(header)
		$arrIddata=explode('@',$arrDefault['id']);
		$arrPagedata['header']='<div id="'.$arrIddata[0].'" class="'.(isset($arrIddata[1])?$arrIddata[1]:$arrIddata[0]).'">';
		if($bLiStyle){
			$arrPagedata['header'].='<ul>';
		}

		// 总记录(total)
		$arrPagedata['total']="<{$arrDefault['style']} class=\"{$arrDefault['disabled']}\">".$sLiAheader;
		if($this->_nCount>0){
			$arrPagedata['total'].=$arrDefault['total'].$this->_nCount;
		}else{
			$arrPagedata['total'].=$arrDefault['none'];
		}
		$arrPagedata['total'].=$sLiAfooter."</{$arrDefault['style']}>";

		// 页面
		$arrPagedata['first']=$arrPagedata['prev']=$arrPagedata['main']=$arrPagedata['next']=$arrPagedata['last']='';
		if($this->_nPageCount>1){// 页码
			// 第一页和上一页(first && prev)
			if($this->_nPage!=1){
				$arrPagedata['first']=$sLiheader."<a href=\"{$this->pageReplace(1)}\" title=\"{$arrDefault['home']}\" >{$arrDefault['first']}</a>".$sLifooter;
				$arrPagedata['prev']=$sLiheader."<a href=\"{$this->pageReplace($this->_nPage-1)}\" title=\"{$arrDefault['previous']}\" >{$arrDefault['prev']}</a>".$sLifooter;
			}

			// 主页码(main)
			for($nI=$this->_nPageI;$nI<=$this->_nPageUb;$nI++){
				if($this->_nPage==$nI){
					$arrPagedata['main'].="<{$arrDefault['style']} class=\"{$arrDefault['current']}\">{$sLiAheader}{$nI}{$sLiAfooter}</{$arrDefault['style']}>";
				}else{
					$arrPagedata['main'].=$sLiheader."<a href=\"{$this->pageReplace($nI)}\" title=\"".sprintf($arrDefault['page'],$nI)."\">{$nI}</a>".$sLifooter;
				}
			}

			// 下一页和最后一页(next && last)
			if($this->_nPage!=$this->_nPageCount){
				$arrPagedata['next']=$sLiheader."<a href=\"{$this->pageReplace($this->_nPage+1)}\" title=\"{$arrDefault['next']}\" >{$arrDefault['nexts']}</a>".$sLifooter;
				$arrPagedata['last']=$sLiheader."<a href=\"{$this->pageReplace($this->_nPageCount)}\" title=\"{$arrDefault['last']}\" >{$arrDefault['lasts']}</a>".$sLifooter;
			}
		}

		// 结束(footer)
		$arrPagedata['footer']='';
		if($bLiStyle){
			$arrPagedata['footer'].='</ul>';
		}
		$arrPagedata['footer'].='</div>';

		// 返回
		$sPagenav=$arrPagedata['header'];
		$sPagenav.=str_replace(
			array('{total}','{first}','{prev}','{main}','{next}','{last}'),
			array($arrPagedata['total'],$arrPagedata['first'],$arrPagedata['prev'],$arrPagedata['main'],$arrPagedata['next'],$arrPagedata['last']),$arrDefault['template']);
		$sPagenav.=$arrPagedata['footer'];

		return $sPagenav;
	}

	public function setParameter($sParameter){
		$this->_sParameter=$sParameter;
		return $this;
	}

	public function S(){
		return $this->_nPageStart;
	}

	public function N(){
		return $this->_nSize;
	}

	public function O($sName,$sValue=null){
		if(isset($this->_arrDefault[$sName])){
			if($sValue===null){
				return $this->_arrDefault[$sName];
			}else{
				$this->_arrDefault[$sName]=$sValue;
			}
		}
	}

	public function getPage(){
		return $this->_nPageCount;
	}

	protected function pageReplace($nPage){
		return str_replace(array(urlencode('{page}'),'{page}'),$nPage,$this->_sUrl);
	}

}
