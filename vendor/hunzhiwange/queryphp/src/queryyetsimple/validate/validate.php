<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\validate;

<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

/**
 * validate 数据验证器
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.02
 * @version 4.0
 *         
 */
class validate {
    const SKIP_ON_FAILED = 'skip_on_failed';
    const SKIP_OTHERS = 'skip_others';
    const PASSED = true;
    const FAILED = false;
    const CHECK_ALL = true;
    protected $_sErrorMessage;
    protected $_oDefaultDbIns = null;
    private function __construct() {
    }
    public function make() {
    }
    public function RUN($bDefaultIns = true) {
        if ($bDefaultIns and static::$_oDefaultDbIns) {
            return static::$_oDefaultDbIns;
        }
        
        $oCheck = new self ();
        if ($bDefaultIns) {
            static::$_oDefaultDbIns = $oCheck;
        }
        
        return $oCheck;
    }
    public function C($Data, $Check) {
        $arrArgs = func_get_args ();
        unset ( $arrArgs [1] );
        $bResult = static::checkByArgs ( $Check, $arrArgs );
        return ( bool ) $bResult;
    }
    public function checkBatch($Data, array $arrChecks, $bCheckAll = true, &$arrFailed = null) {
        $bResult = true;
        $arrFailed = array ();
        foreach ( $arrChecks as $arrV ) {
            $sVf = $arrV [0];
            $arrV [0] = $Data;
            
            $bRet = static::checkByArgs ( $sVf, $arrV );
            if ($bRet === static::SKIP_OTHERS) { // 跳过余下的验证规则
                return $bResult;
            }
            
            if ($bRet === static::SKIP_ON_FAILED) {
                $bCheckAll = false;
                continue;
            }
            
            if ($bRet) {
                continue;
            }
            
            $arrFailed [] = $arrV;
            $bResult = $bResult && $bRet;
            if (! $bResult && ! $bCheckAll) {
                return false;
            }
        }
        
        return ( bool ) $bResult;
    }
    public function checkByArgs($Check, array $arrArgs) {
        $arrInternalFuncs = null;
        
        if (is_null ( $arrInternalFuncs )) {
            $arrInternalFuncs = array (
                    'between',
                    'date',
                    'datetime',
                    'digit',
                    'double',
                    'email',
                    'english',
                    'equal',
                    'eq',
                    'float',
                    'greater_or_equal',
                    'egt',
                    'gt',
                    'in',
                    'integer',
                    'int',
                    'ip',
                    'ipv4',
                    'less_or_equal',
                    'elt',
                    'less_than',
                    'lt',
                    'lower',
                    'max',
                    'min',
                    'mobile',
                    'not_empty',
                    'not_null',
                    'not_same',
                    'num',
                    'number',
                    'number_underline_english',
                    'regex',
                    'require',
                    'same',
                    'empty',
                    'error',
                    'null',
                    'strlen',
                    'time',
                    'type',
                    'upper',
                    'url',
                    'max_len',
                    'max_length',
                    'min_len',
                    'min_length' 
            );
            $arrInternalFuncs = array_flip ( $arrInternalFuncs );
        }
        
        static::$_sErrorMessage = ''; // 验证前还原状态
        
        if (! is_array ( $Check ) && isset ( $arrInternalFuncs [$Check] )) { // 内置验证方法
            $bResult = call_user_func_array ( array (
                    __CLASS__,
                    $Check . '_' 
            ), $arrArgs );
        } elseif (is_array ( $Check ) || function_exists ( $Check )) { // 使用回调处理
            $bResult = call_user_func_array ( $Check, $arrArgs );
        } elseif (strpos ( $Check, '::' )) { // 使用::回调处理
            $bResult = call_user_func_array ( explode ( '::', $Check ), $arrArgs );
        } else { // 错误的验证规则
            static::$_sErrorMessage = Q::L ( '不存在的验证规则', '__QEEPHP__@Q' );
            return false;
        }
        
        if ($bResult === false) {
            static::$_sErrorMessage = Q::L ( '验证数据出错', '__QEEPHP__@Q' );
        }
        
        return $bResult;
    }
    public function between_($Data, $Min, $Max, $bInclusive = true) {
        if ($bInclusive) {
            return $Data >= $Min && $Data <= $Max;
        } else {
            return $Data > $Min && $Data < $Max;
        }
    }
    public function date_($Data) {
        if (strpos ( $Data, '-' ) !== false) { // 分析数据中关键符号
            $sP = '-';
        } elseif (strpos ( $Data, '/' ) !== false) {
            $sP = '\/';
        } else {
            $sP = false;
        }
        
        if ($sP !== false and preg_match ( '/^\d{4}' . $sP . '\d{1,2}' . $sP . '\d{1,2}$/', $Data )) {
            $arrValue = explode ( $sP, $Data );
            if (count ( $Data ) >= 3) {
                list ( $nYear, $nMonth, $nDay ) = $arrValue;
                if (checkdate ( $nMonth, $nDay, $nYear )) {
                    return true;
                }
            }
        }
        
        return false;
    }
    public function datetime_($Data) {
        $test = @strtotime ( $Data );
        if ($test !== false && $test !== - 1) {
            return true;
        }
        
        return false;
    }
    public function digit_($Data) {
        return ctype_digit ( $Data );
    }
    public function double_($Data) {
        return preg_match ( '/^[-\+]?\d+(\.\d+)?$/', $Data );
    }
    public function email_($Data) {
        return preg_match ( '/([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?/i', $Data );
    }
    public function english_($Data) {
        return preg_match ( '/^[A-Za-z]+$/', $Data );
    }
    public function equal_($Data, $Test) {
        return $Data == $Test;
    }
    public function eq_($Data, $Test) {
        return static::equal_ ( $Data, $Test );
    }
    public function float_($Data) {
        $arrLocale = null;
        
        if (is_null ( $arrLocale )) {
            $arrLocale = localeconv ();
        }
        $Data = str_replace ( $arrLocale ['decimal_point'], '.', $Data );
        $Data = str_replace ( $arrLocale ['thousands_sep'], '', $Data );
        
        if (strval ( floatval ( $Data ) ) == $Data) {
            return true;
        }
        
        return false;
    }
    public function greater_or_equal_($Data, $Test, $bInclusive = true) {
        if ($bInclusive) {
            return $Data >= $Test;
        } else {
            return $Data > $Test;
        }
    }
    public function egt_($Data, $Test, $bInclusive = true) {
        return static::greater_or_equal_ ( $Data, $Test, $bInclusive );
    }
    public function gt_($Data, $Test) {
        return static::greater_or_equal_ ( $Data, $Test, false );
    }
    public function in_($Data, $arrIn) {
        return is_array ( $arrIn ) and in_array ( $Data, $arrIn );
    }
    public function integer_($Data) {
        return preg_match ( '/^[-\+]?\d+$/', $Data );
    }
    public function int_($Data, $Test) {
        return static::integer_ ( $Data );
    }
    public function ip_($Data) {
        return preg_match ( '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $Data );
    }
    public function ipv4_($Data) {
        $test = @ip2long ( $Data );
        if ($test !== - 1 and $test !== false) {
            return true;
        }
        
        return false;
    }
    public function less_or_equal_($Data, $Test, $bInclusive = true) {
        if ($bInclusive) {
            return $Data <= $Test;
        } else {
            return $Data < $Test;
        }
    }
    public function elt_($Data, $Test, $bInclusive = true) {
        return static::less_or_equal_ ( $Data, $Test, $bInclusive );
    }
    public function less_than_($Data, $Test) {
        return static::less_or_equal_ ( $Data, $Test, false );
    }
    public function lt_($Data, $Test) {
        return static::less_or_equal_ ( $Data, $Test, false );
    }
    public function lower_($Data) {
        return ctype_lower ( $Data );
    }
    public function max_($Data, $Test) {
        return $Data <= $Test;
    }
    public function min_($Data, $Test) {
        return $Data >= $Test;
    }
    public function mobile_($Data) {
        return preg_match ( "/1[3458]{1}\d{9}$/", $Data );
    }
    public function not_empty_($Data) {
        return ! empty ( $Data );
    }
    public function not_equal_($Data, $Test) {
        return $Data != $Test;
    }
    public function neq_($Data, $Test) {
        return static::not_equal_ ( $Data, $Test );
    }
    public function not_null_($Data) {
        return ! is_null ( $Data );
    }
    public function not_same_($Data, $Test) {
        return $Data !== $Test;
    }
    public function num_($Data) {
        return ($Data && preg_match ( '/\d+$/', $Data )) || ! preg_match ( "/[^\d-.,]/", $Data ) || $Data == 0;
    }
    public function number_($Data) {
        return static::num_ ( $Data );
    }
    public function number_underline_english_($Data) {
        return preg_match ( '/^[a-z0-9\-\_]*[a-z\-_]+[a-z0-9\-\_]*$/i', $Data );
    }
    public function regex_($Data, $sRegex) {
        return preg_match ( $sRegex, $Data ) > 0;
    }
    public function require_($Data) {
        return preg_match ( '/.+/', $Data );
    }
    
    /**
     * 两个值是否完全相同
     * 
     * @param mixed $mixData
     * @param mixed $mixCompareData
     * @return boolean
     */
    public function same($mixData, $mixCompareData) {
        return $mixData === $mixCompareData;
    }
    
    
//     public function empty_($Data) {
//         return (strlen ( $Data ) == 0) ? static::SKIP_OTHERS : true;
//     }
//     public function error_($Data) {
//         return static::SKIP_ON_FAILED;
//     }
//     public function isNull($strData) {
//         return (is_null ( $Data )) ? static::SKIP_OTHERS : true;
//     }
    
    /**
     * 长度验证
     * 
     * @param string $strData
     * @param int $nLength
     * @return boolean
     */
    public function strlen($strData, $nLength) {
        return strlen ( $strData ) == ( int ) $nLength;
    }
    
    
//     public function time_($Data) {
//         $arrParts = explode ( ':', $Data );
//         $nCount = count ( $arrParts );
//         if ($nCount == 2 || $nCount == 3) {
//             if ($nCount == 2) {
//                 $arrParts [2] = '00';
//             }
//             $test = @strtotime ( $arrParts [0] . ':' . $arrParts [1] . ':' . $arrParts [2] );
//             if ($test !== - 1 && $test !== false && date ( 'H:i:s' ) == $Data) {
//                 return true;
//             }
//         }
        
//         return false;
//     }
    
    /**
     * 数据类型验证
     * 
     * @param mixed $mixData            
     * @param string $strType            
     * @return boolean
     */
    public function type($mixData, $strType) {
        return gettype ( $mixData ) === $strType;
    }
    
    /**
     * 验证是否都是小写
     *
     * @param string $Data            
     * @return boolean
     */
    public function lower($strData) {
        return ctype_lower ( $strData );
    }
    
    /**
     * 验证是否都是大写
     *
     * @param string $Data            
     * @return boolean
     */
    public function upper($strData) {
        return ctype_upper ( $strData );
    }
    
    /**
     * 验证是否为 url 地址
     *
     * @param string $strData            
     * @return boolean
     */
    public function url($strData) {
        return preg_match ( '/^(https?):\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/', $strData );
    }
    
    /**
     * 验证数据最小长度
     *
     * @param string $strData            
     * @param int $nLength            
     * @return boolean
     */
    public function minLength($strData, $nLength) {
        return iconv_strlen ( $strData, 'utf-8' ) >= ( int ) $nLength;
    }
    
    /**
     * 验证数据最大长度
     *
     * @param string $strData            
     * @param int $nLength            
     * @return boolean
     */
    public function maxLength($strData, $nLength) {
        return iconv_strlen ( $strData, 'utf-8' ) <= ( int ) $nLength;
    }
}
