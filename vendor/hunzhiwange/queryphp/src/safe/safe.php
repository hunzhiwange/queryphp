<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\safe;

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

use Q\traits\dynamic\expansion as dynamic_expansion;

/**
 * 字符串
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.05
 * @version 4.0
 */
class safe {
    
    use dynamic_expansion;
    
    /**
     * 移除魔术方法转义
     *
     * @param mixed $mixString            
     * @param boolean $bRecursive            
     * @return mixed
     */
    public static function stripslashes($mixString, $bRecursive = true) {
        if ($bRecursive === true and is_array ( $mixString )) { // 递归
            foreach ( $mixString as $sKey => $mixValue ) {
                $mixString [static::stripslashes ( $sKey )] = static::stripslashes ( $mixValue ); // 如果你只注意到值，却没有注意到key
            }
        } else {
            if (is_string ( $mixString )) {
                $mixString = stripslashes ( $mixString );
            }
        }
        
        return $mixString;
    }
    
    /**
     * 添加模式转义
     *
     * @param mixed $mixString            
     * @param string $bRecursive            
     * @return string
     */
    public static function addslashes($mixString, $bRecursive = true) {
        if ($bRecursive === true and is_array ( $mixString )) {
            foreach ( $mixString as $sKey => $mixValue ) {
                $mixString [static::addslashes ( $sKey )] = static::addslashes ( $mixValue ); // 如果你只注意到值，却没有注意到key
            }
        } else {
            if (is_string ( $mixString )) {
                $mixString = addslashes ( $mixString );
            }
        }
        
        return $mixString;
    }
    
    /**
     * 来自 Discuz 经典 PHP 加密算法
     *
     * @param string $string            
     * @param boolean $operation            
     * @param string $key            
     * @param number $expiry            
     * @return string
     */
    public static function authcode($string, $operation = TRUE, $key = null, $expiry = 0) {
        $ckey_length = 4;
        
        $key = md5 ( $key ? $key : $GLOBALS ['~@option'] ['q_auth_key'] );
        $keya = md5 ( substr ( $key, 0, 16 ) );
        $keyb = md5 ( substr ( $key, 16, 16 ) );
        $keyc = $ckey_length ? ($operation === TRUE ? substr ( $string, 0, $ckey_length ) : substr ( md5 ( microtime () ), - $ckey_length )) : '';
        
        $cryptkey = $keya . md5 ( $keya . $keyc );
        $key_length = strlen ( $cryptkey );
        $string = $operation === TRUE ? base64_decode ( substr ( $string, $ckey_length ) ) : sprintf ( '%010d', $expiry ? $expiry + time () : 0 ) . substr ( md5 ( $string . $keyb ), 0, 16 ) . $string;
        $string_length = strlen ( $string );
        
        $result = '';
        $box = range ( 0, 255 );
        $rndkey = [ ];
        for($i = 0; $i <= 255; $i ++) {
            $rndkey [$i] = ord ( $cryptkey [$i % $key_length] );
        }
        
        for($j = $i = 0; $i < 256; $i ++) {
            $j = ($j + $box [$i] + $rndkey [$i]) % 256;
            $tmp = $box [$i];
            $box [$i] = $box [$j];
            $box [$j] = $tmp;
        }
        
        for($a = $j = $i = 0; $i < $string_length; $i ++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box [$a]) % 256;
            $tmp = $box [$a];
            $box [$a] = $box [$j];
            $box [$j] = $tmp;
            $result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
        }
        
        if ($operation === TRUE) {
            if ((substr ( $result, 0, 10 ) == 0 || substr ( $result, 0, 10 ) - time () > 0) && substr ( $result, 10, 16 ) == substr ( md5 ( substr ( $result, 26 ) . $keyb ), 0, 16 )) {
                return substr ( $result, 26 );
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace ( '=', '', base64_encode ( $result ) );
        }
    }
    
    /**
     * 正则属性转义
     *
     * @param string $sTxt            
     * @param bool $bEsc            
     * @return string
     */
    public static function escapeCharacter($sTxt, $bEsc = true) {
        if ($sTxt == '""') {
            $sTxt = '';
        }
        
        if ($bEsc) { // 转义
            $sTxt = str_replace ( [ 
                    '\\\\',
                    "\\'",
                    '\\"',
                    '\\$',
                    '\\.' 
            ], [ 
                    '\\',
                    '~~{#!`!#}~~',
                    '~~{#!``!#}~~',
                    '~~{#!S!#}~~',
                    '~~{#!dot!#}~~' 
            ], $sTxt );
        } else { // 还原
            $sTxt = str_replace ( [ 
                    '.',
                    "~~{#!`!#}~~",
                    '~~{#!``!#}~~',
                    '~~{#!S!#}~~',
                    '~~{#!dot!#}~~' 
            ], [ 
                    '->',
                    "'",
                    '"',
                    '$',
                    '.' 
            ], $sTxt );
        }
        
        return $sTxt;
    }
    
    /**
     * 转移正则表达式特殊字符
     *
     * @param string $sTxt            
     * @return string
     */
    public static function escapeRegexCharacter($sTxt) {
        $sTxt = str_replace ( [ 
                '$',
                '/',
                '?',
                '*',
                '.',
                '!',
                '-',
                '+',
                '(',
                ')',
                '[',
                ']',
                ',',
                '{',
                '}',
                '|' 
        ], [ 
                '\$',
                '\/',
                '\\?',
                '\\*',
                '\\.',
                '\\!',
                '\\-',
                '\\+',
                '\\(',
                '\\)',
                '\\[',
                '\\]',
                '\\,',
                '\\{',
                '\\}',
                '\\|' 
        ], $sTxt );
        return $sTxt;
    }
    
    /**
     * 过滤掉 javascript
     *
     * @param string $sText
     *            待过滤的字符串
     * @return string
     */
    public static function cleanJs($sText) {
        $sText = trim ( $sText );
        $sText = stripslashes ( $sText );
        $sText = preg_replace ( '/<!--?.*-->/', '', $sText ); // 完全过滤注释
        $sText = preg_replace ( '/<\?|\?>/', '', $sText ); // 完全过滤动态代码
        $sText = preg_replace ( '/<script?.*\/script>/', '', $sText ); // 完全过滤js
        $sText = preg_replace ( '/<\/?(html|head|meta|link|base|body|title|style|script|form|iframe|frame|frameset)[^><]*>/i', '', $sText ); // 过滤多余html
        while ( preg_match ( '/(<[^><]+)(lang|onfinish|onmouse|onexit|onerror|onclick|onkey|onload|onchange|onfocus|onblur)[^><]+/i', $sText, $arrMat ) ) { // 过滤on事件lang js
            $sText = str_replace ( $arrMat [0], $arrMat [1], $sText );
        }
        while ( preg_match ( '/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $sText, $arrMat ) ) {
            $sText = str_replace ( $arrMat [0], $arrMat [1] . $arrMat [3], $sText );
        }
        return $sText;
    }
    
    /**
     * 字符串文本化
     *
     * @param string $sText
     *            待过滤的字符串
     * @return string
     */
    static function text($sText) {
        $sText = static::cleanJs ( $sText );
        // $sText=preg_replace('/\s(?=\s)/','',$sText);// 彻底过滤空格
        $sText = preg_replace ( '/[\n\r\t]/', ' ', $sText );
        /*
         * $sText=str_replace(' ',' ',$sText);
         * $sText=str_replace(' ','',$sText);
         * $sText=str_replace('&nbsp;','',$sText);
         * $sText=str_replace('&','',$sText);
         * $sText=str_replace('=','',$sText);
         * $sText=str_replace('-','',$sText);
         * $sText=str_replace('#','',$sText);
         * $sText=str_replace('%','',$sText);
         * $sText=str_replace('!','',$sText);
         * $sText=str_replace('@','',$sText);
         * $sText=str_replace('^','',$sText);
         * $sText=str_replace('*','',$sText);
         */
        $sText = str_replace ( 'amp;', '', $sText );
        $sText = strip_tags ( $sText );
        $sText = htmlspecialchars ( $sText );
        $sText = str_replace ( "'", "", $sText );
        return $sText;
    }
    
    /**
     * 字符过滤 JS和 HTML标签
     *
     * @param string $sText            
     * @return string
     */
    public static function strip($sText) {
        $sText = trim ( $sText );
        $sText = static::cleanJs ( $sText );
        $sText = strip_tags ( $sText );
        return $sText;
    }
    
    /**
     * 字符 HTML 安全实体
     *
     * @param string $sText            
     * @return string
     */
    public static function html($sText) {
        $sText = trim ( $sText );
        $sText = htmlspecialchars ( $sText );
        return $sText;
    }
    
    /**
     * 字符 HTML 安全显示
     *
     * @param string $sText            
     * @return string
     */
    public static function htmlView($sText) {
        $sText = stripslashes ( $sText );
        $sText = nl2br ( $sText );
        return $sText;
    }
}
