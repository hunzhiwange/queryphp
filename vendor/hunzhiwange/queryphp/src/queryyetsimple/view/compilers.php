<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\view;

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

use queryyetsimple\mvc\view;
use queryyetsimple\exception\exceptions;
use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;
use queryyetsimple\mvc\project;
use queryyetsimple\helper\helper;
use queryyetsimple\filesystem\directory;

/**
 * 编译器列表
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.18
 * @version 1.0
 */
class compilers {
    
    use dynamic_expansion;
    
    /**
     * code 支持的特殊别名映射
     *
     * @var array
     */
    private $arrCodeMap = [ 
            'php' => '~',
            'note' => '#',
            'variable' => '$',
            'foreach' => 'list', // foreach和for冲突，foreach改为list
            'echo' => ':',
            'endtag' => [ 
                    '/list',
                    '/for',
                    '/while',
                    '/if',
                    '/script',
                    '/style' 
            ] 
    ];
    
    /**
     * node 支持的特殊别名映射
     *
     * @var array
     */
    private $arrNodeMap = [ ];
    
    /**
     * javascript 支持的特殊别名映射
     *
     * @var array
     */
    private $arrJsMap = [ ];
    
    /**
     * javascript 标签
     *
     * @var array
     */
    private $arrJsTag = [
            // required 属性不能为空，single 单标签
            'if' => [ 
                    'attr' => [ 
                            'condition' 
                    ],
                    'single' => false,
                    'required' => [ 
                            'condition' 
                    ] 
            ],
            'elseif' => [ 
                    'attr' => [ 
                            'condition' 
                    ],
                    'single' => true,
                    'required' => [ 
                            'condition' 
                    ] 
            ],
            'else' => [ 
                    'attr' => [ ],
                    'single' => true,
                    'required' => [ ] 
            ],
            'each' => [ 
                    'attr' => [ 
                            'for',
                            'value',
                            'index' 
                    ],
                    'single' => false,
                    'required' => [ 
                            'for' 
                    ] 
            ] 
    ];
    
    /**
     * Node标签
     *
     * @var array
     */
    private $arrNodeTag = [
            // required 属性不能为空，single 单标签
            'assign' => [ 
                    'attr' => [ 
                            'name',
                            'value' 
                    ],
                    'single' => true,
                    'required' => [ 
                            'name' 
                    ] 
            ],
            'if' => [ 
                    'attr' => [ 
                            'condition' 
                    ],
                    'single' => false,
                    'required' => [ 
                            'condition' 
                    ] 
            ],
            'elseif' => [ 
                    'attr' => [ 
                            'condition' 
                    ],
                    'single' => true,
                    'required' => [ 
                            'condition' 
                    ] 
            ],
            'else' => [ 
                    'attr' => [ ],
                    'single' => true,
                    'required' => [ ] 
            ],
            'list' => [ 
                    'attr' => [ 
                            'for',
                            'key',
                            'value',
                            'index' 
                    ],
                    'single' => false,
                    'required' => [ 
                            'for' 
                    ] 
            ],
            'lists' => [ 
                    'attr' => [ 
                            'index',
                            'key',
                            'mod',
                            'empty',
                            'length',
                            'offset',
                            'name',
                            'id' 
                    ],
                    'single' => false,
                    'required' => [ 
                            'name' 
                    ] 
            ],
            'include' => [ 
                    'attr' => [ 
                            'file',
                            'ext' 
                    ],
                    'single' => true,
                    'required' => [ 
                            'file' 
                    ] 
            ],
            'for' => [ 
                    'attr' => [ 
                            'step',
                            'start',
                            'end',
                            'var',
                            'type' 
                    ],
                    'single' => false,
                    'required' => [ ] 
            ],
            'while' => [ 
                    'attr' => [ 
                            'condition' 
                    ],
                    'single' => false,
                    'required' => [ 
                            'condition' 
                    ] 
            ],
            'break' => [ 
                    'attr' => [ ],
                    'single' => true,
                    'required' => [ ] 
            ],
            'continue' => [ 
                    'attr' => [ ],
                    'single' => true,
                    'required' => [ ] 
            ],
            'php' => [ 
                    'attr' => [ ],
                    'single' => false,
                    'required' => [ ] 
            ] 
    ];
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [ 
            'theme_cache_children' => false,
            'theme_var_identify' => '',
            'theme_notallows_func' => 'exit,die,return',
            'theme_notallows_func_js' => 'alert' 
    ];
    
    // ######################################################
    // ------------------- 全局编译器 start -------------------
    // ######################################################
    
    /**
     * 全局编译器（保护标签）
     *
     * @param array $arrTheme            
     * @return void
     */
    public function globalCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( $arrTheme ['content'], 'global' );
    }
    
    /**
     * 全局还原编译器（保护标签还原）
     *
     * @param array $arrTheme            
     * @return void
     */
    public function globalrevertCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( $arrTheme ['content'], 'revert' );
    }
    
    /**
     * node.code 还原编译器
     *
     * @param array $arrTheme            
     * @return void
     */
    public function revertCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( $arrTheme ['content'], 'revert' );
    }
    
    // ######################################################
    // --------------------- 全局编译器 end ---------------------
    // ######################################################
    
    // ######################################################
    // ------------------- code 编译器 start -------------------
    // ######################################################
    
    /**
     * 变量
     *
     * @param array $arrTheme            
     * @return void
     */
    public function variableCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = ! empty ( $arrTheme ['content'] ) ? $this->parseContent_ ( $arrTheme ['content'] ) : NULL;
        if ($arrTheme ['content'] !== NULL) {
            $arrTheme ['content'] = '<' . '?php echo ' . $arrTheme ['content'] . '; ?' . '>';
        }
        $arrTheme ['content'] = $this->encodeContent_ ( $arrTheme ['content'] );
    }
    
    /**
     * if
     *
     * @param array $arrTheme            
     * @return void
     */
    public function ifCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->parseContentIf_ ( $arrTheme ['content'] );
        $arrTheme ['content'] = $this->encodeContent_ ( '<?' . 'php ' . $arrTheme ['content'] . ' : ?' . '>' );
    }
    
    /**
     * elseif
     *
     * @param array $arrTheme            
     * @return void
     */
    public function elseifCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->parseContentIf_ ( $arrTheme ['content'], 'else' );
        $arrTheme ['content'] = $this->encodeContent_ ( '<?' . 'php ' . $arrTheme ['content'] . ' : ?' . '>' );
    }
    
    /**
     * else 标签
     *
     * @param array $arrTheme            
     * @return void
     */
    public function elseCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( '<?' . 'php else: ?' . '>' );
    }
    
    /**
     * foreach
     *
     * @param array $arrTheme            
     * @return void
     */
    public function foreachCodeCompiler(&$arrTheme) {
        // 分析foreach
        $calHelp = function ($sContent) {
            preg_match_all ( '/\\$([\S]+)/', $sContent, $arrArray );
            
            $arrArray = $arrArray [1];
            $nNum = count ( $arrArray );
            if ($nNum > 0) {
                if ($nNum == 2) {
                    $sResult = "\${$arrArray[1]}";
                } elseif ($nNum == 3) {
                    $sResult = "\${$arrArray[1]} => \${$arrArray[2]}";
                } else {
                    exceptions::throwException ( __ ( '参数错误' ), 'queryyetsimple\view\exception' );
                }
                
                return "if (is_array ( \${$arrArray[0]} ) ) : foreach( \${$arrArray[0]} as $sResult )";
            }
        };
        
        $arrTheme ['content'] = $calHelp ( $arrTheme ['content'] );
        $arrTheme ['content'] = $this->encodeContent_ ( '<?' . 'php ' . $arrTheme ['content'] . ': ?' . '>' );
    }
    
    /**
     * for
     *
     * @param array $arrTheme            
     * @return void
     */
    public function forCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( '<?' . 'php for( ' . $arrTheme ['content'] . ' ) : ?' . '>' );
    }
    
    /**
     * while 头部
     *
     * @param array $arrTheme            
     * @return void
     */
    public function whileCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( '<?' . 'php while( ' . $arrTheme ['content'] . ' ) : ?' . '>' );
    }
    
    /**
     * php 脚本
     *
     * @param array $arrTheme            
     * @return void
     */
    public function phpCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( '<?' . 'php ' . $arrTheme ['content'] . '; ?' . '>' );
    }
    
    /**
     * 注释
     *
     * @param array $arrTheme            
     * @return void
     */
    public function noteCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( ' ' );
    }
    
    /**
     * PHP echo 标签
     *
     * @param array $arrTheme            
     * @return void
     */
    public function echoCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( '<?' . 'php echo ' . $arrTheme ['content'] . '; ?' . '>' );
    }
    
    /**
     * javascript 初始标签
     *
     * @param array $arrTheme            
     * @return void
     */
    public function scriptCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( '<script type="text/javascript">' );
    }
    
    /**
     * css 初始标签
     *
     * @param array $arrTheme            
     * @return void
     */
    public function styleCodeCompiler(&$arrTheme) {
        $arrTheme ['content'] = $this->encodeContent_ ( '<style type="text/css">' );
    }
    
    /**
     * endtag
     *
     * @param array $arrTheme            
     * @return void
     */
    public function endtagCodeCompiler(&$arrTheme) {
        // 尾标签
        $calHelp = function ($sContent) {
            $sContent = ltrim ( trim ( $sContent ), '/' );
            switch ($sContent) {
                case 'list' :
                    $sContent = '<' . '?php endforeach; endif; ?' . '>';
                    break;
                case 'for' :
                    $sContent = '<' . '?php endfor; ?' . '>';
                    break;
                case 'while' :
                    $sContent = '<' . '?php endwhile; ?' . '>';
                    break;
                case 'if' :
                    $sContent = '<' . '?php endif; ?' . '>';
                    break;
                case 'script' :
                    $sContent = '</script>';
                    break;
                case 'style' :
                    $sContent = '</style>';
                    break;
            }
            return $sContent;
        };
        
        $arrTheme ['content'] = $calHelp ( substr ( $arrTheme ['source'], strpos ( $arrTheme ['source'], '/' ), strripos ( $arrTheme ['source'], '}' ) - 1 ) );
        $arrTheme ['content'] = $this->encodeContent_ ( $arrTheme ['content'] );
    }
    
    // ######################################################
    // ------------------- code 编译器 end --------------------
    // ######################################################
    
    // ######################################################
    // --------------- javascript 编译器 start ---------------
    // ######################################################
    
    /**
     * 变量及表达式
     *
     * @param array $arrTheme            
     * @return void
     */
    public function jsvarCompiler(&$arrTheme) {
        $arrTheme ['content'] = "' + " . $this->parseJsContent_ ( $arrTheme ['content'] ) . " + '";
    }
    
    /**
     * if 编译器
     *
     * @param array $arrTheme            
     * @return void
     */
    public function ifJsCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme, true );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        
        $arrAttr ['condition'] = $this->parseJsContent_ ( $arrAttr ['condition'] );
        
        $sCompiled = "';
if( {$arrAttr['condition']} ) {
    out += '" . $this->getNodeBody_ ( $arrTheme ) . "';
}
out += '";
        
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * elseif 编译器
     *
     * @param array $arrTheme            
     * @return void
     */
    public function elseifJsCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme, true );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        
        $arrAttr ['condition'] = $this->parseJsContent_ ( $arrAttr ['condition'] );
        
        $sCompiled = "';
} else if( {$arrAttr['condition']} ) {
        out += '" . $this->getNodeBody_ ( $arrTheme ) . "';
out += '";
        
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * else
     *
     * @param array $arrTheme            
     * @return void
     */
    public function elseJsCompiler(&$arrTheme) {
        $sCompiled = "';
} else {
out += '";
        
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * each 循环
     *
     * @param array $arrTheme            
     * @return void
     */
    public function eachJsCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme, true );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        
        foreach ( [ 
                'value',
                'index' 
        ] as $sKey ) {
            $arrAttr [$sKey] === null && $arrAttr [$sKey] = $sKey;
        }
        
        $sCompiled = "';
\$.each( {$arrAttr['for']}, function( {$arrAttr['index']}, {$arrAttr['value']} ) {
    out += '" . $this->getNodeBody_ ( $arrTheme ) . "';
});
out += '";
        
        $arrTheme ['content'] = $sCompiled;
    }
    
    // ######################################################
    // ---------------- javascript 编译器 end ----------------
    // ######################################################
    
    // ######################################################
    // ------------------ node 编译器 start ------------------
    // ######################################################
    
    /**
     * assign
     *
     * @param array $arrTheme            
     * @return void
     */
    public function assignNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        
        $arrAttr ['name'] = $this->parseContent_ ( $arrAttr ['name'], false );
        if ($arrAttr ['value'] === null) {
            $arrAttr ['value'] = '';
        } else {
            if ('$' == substr ( $arrAttr ['value'], 0, 1 )) {
                $arrAttr ['value'] = $this->parseContent_ ( substr ( $arrAttr ['value'], 1 ) );
            } else {
                $arrAttr ['value'] = '\'' . $arrAttr ['value'] . '\'';
            }
        }
        
        // 编译
        $sCompiled = '<?' . 'php ' . $arrAttr ['name'] . '=' . $arrAttr ['value'] . '; ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * 流程if
     *
     * @param array $arrTheme            
     * @return void
     */
    public function ifNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        $arrAttr ['condition'] = $this->parseConditionHelp_ ( $arrAttr ['condition'] );
        $sCompiled = '<' . '?php if( ' . $arrAttr ['condition'] . ' ) : ?' . '>' . $this->getNodeBody_ ( $arrTheme ) . '<' . '?php endif; ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * elseif
     *
     * @param array $arrTheme            
     * @return void
     */
    public function elseifNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        $arrAttr ['condition'] = $this->parseConditionHelp_ ( $arrAttr ['condition'] );
        $sCompiled = '<' . '?php elseif( ' . $arrAttr ['condition'] . ' ) : ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * else
     *
     * @param array $arrTheme            
     * @return void
     */
    public function elseNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $sCompiled = '<' . '?php else : ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * foreach list
     *
     * @param array $arrTheme            
     * @return void
     */
    public function listNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        
        foreach ( [ 
                'key',
                'value',
                'index' 
        ] as $sKey ) {
            $arrAttr [$sKey] === null && $arrAttr [$sKey] = '$' . $sKey;
        }
        
        foreach ( [ 
                'for',
                'key',
                'value',
                'index' 
        ] as $sKey ) {
            if ('$' . $sKey == $arrAttr [$sKey]) {
                continue;
            }
            $arrAttr [$sKey] = $this->parseContent_ ( $arrAttr [$sKey] );
        }
        
        // 编译
        $sCompiled = '<' . '?php ' . $arrAttr ['index'] . ' = 1; ?' . '>' . '<' . '?php if( is_array( ' . $arrAttr ['for'] . ' ) ) : foreach( ' . $arrAttr ['for'] . ' as ' . $arrAttr ['key'] . ' => ' . $arrAttr ['value'] . ') : ?' . '>' . $this->getNodeBody_ ( $arrTheme ) . '<' . '?php ' . $arrAttr ['index'] . '++; ?' . '>' . '<' . '?php endforeach; endif; ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * lists 增强版
     *
     * @param array $arrTheme            
     * @return void
     */
    public function listsNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        
        $arrAttr ['index'] === NULL && $arrAttr ['index'] = 'index';
        $arrAttr ['key'] === NULL && $arrAttr ['key'] = 'key';
        $arrAttr ['id'] === NULL && $arrAttr ['id'] = 'id';
        $arrAttr ['mod'] === NULL && $arrAttr ['mod'] = 2;
        if (preg_match ( "/[^\d-.,]/", $arrAttr ['mod'] )) {
            $arrAttr ['mod'] = '$' . $arrAttr ['mod'];
        }
        $arrAttr ['empty'] === NULL && $arrAttr ['empty'] = '';
        $arrAttr ['length'] === NULL && $arrAttr ['length'] = '';
        $arrAttr ['offset'] === NULL && $arrAttr ['offset'] = '';
        $arrAttr ['name'] = $this->parseContent_ ( $arrAttr ['name'] );
        
        $sCompiled = '<' . '?php if( is_array ( ' . $arrAttr ['name'] . ' ) ) : $' . $arrAttr ['index'] . ' = 0; ';
        if ('' != $arrAttr ['length']) {
            $sCompiled .= '$arrList = array_slice( ' . $arrAttr ['name'] . ', ' . $arrAttr ['offset'] . ', ' . $arrAttr ['length'] . ' ); ';
        } elseif ('' != $arrAttr ['offset']) {
            $sCompiled .= '$arrList = array_slice ( ' . $arrAttr ['name'] . ', ' . $arrAttr ['offset'] . ' ); ';
        } else {
            $sCompiled .= '$arrList = ' . $arrAttr ['name'] . '; ';
        }
        $sCompiled .= 'if( count( $arrList ) == 0 ) : echo  "' . $arrAttr ['empty'] . '"; ';
        $sCompiled .= 'else : ';
        $sCompiled .= 'foreach ( $arrList as $' . $arrAttr ['key'] . ' => $' . $arrAttr ['id'] . ' ) : ';
        $sCompiled .= '++$' . $arrAttr ['index'] . '; ';
        $sCompiled .= '$mod = ( $' . $arrAttr ['index'] . ' % ' . $arrAttr ['mod'] . ') ?' . '>';
        $sCompiled .= $this->getNodeBody_ ( $arrTheme );
        $sCompiled .= '<' . '?php endforeach; endif; else: echo "' . $arrAttr ['empty'] . '"; endif; ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * include
     *
     * @param array $arrTheme            
     * @return void
     */
    public function includeNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        
        // 替换一下，防止迁移的时候由于物理路径的原因，需要重新生成编译文件
        $arrAttr ['file'] = view::parseFiles ( $arrAttr ['file'], $arrAttr ['ext'] );
        if (strpos ( $arrAttr ['file'], '$' ) !== 0 && strpos ( $arrAttr ['file'], '(' ) === false) {
            $arrAttr ['file'] = str_replace ( directory::tidyPath ( $this->project ()->path_app_theme . '/' . $this->project ()->name_app_theme ), '$PROJECT->path_app_theme.\'/\'.$PROJECT->name_app_theme.\'', directory::tidyPath ( $arrAttr ['file'] ) );
            $arrAttr ['file'] = (strpos ( $arrAttr ['file'], '$' ) === 0 ? '' : '\'') . $arrAttr ['file'] . '\'';
        }
        
        // 子模板合并到主模板
        if ($this->getExpansionInstanceArgs_ ( 'theme_cache_children' )) {
            $sMd5 = md5 ( $arrAttr ['file'] );
            $sCompiled = "<!--<####incl*" . $sMd5 . "*ude####>-->";
            $sCompiled .= '<?' . 'php $this->display( ' . $arrAttr ['file'] . ', true, __FILE__,\'' . $sMd5 . '\'   ); ?' . '>';
            $sCompiled .= "<!--</####incl*" . $sMd5 . "*ude####/>-->";
        } else {
            $sCompiled = '<?' . 'php $this->display( ' . $arrAttr ['file'] . ' ); ?' . '>';
        }
        
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * for
     *
     * @param array $arrTheme            
     * @return void
     */
    public function forNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        
        $arrAttr ['step'] === NULL && $arrAttr ['step'] = '1';
        $arrAttr ['start'] === NULL && $arrAttr ['start'] = '0';
        $arrAttr ['end'] === NULL && $arrAttr ['end'] = '0';
        $arrAttr ['var'] === NULL && $arrAttr ['var'] = 'var';
        $arrAttr ['var'] = '$' . $arrAttr ['var'];
        if ($arrAttr ['type'] == '-') {
            $sComparison = ' >= ';
            $sMinusPlus = ' -= ';
        } else {
            $sComparison = ' <= ';
            $sMinusPlus = ' += ';
        }
        
        $sCompiled = '<' . '?php for( ' . $arrAttr ['var'] . ' = ' . $arrAttr ['start'] . '; ' . $arrAttr ['var'] . $sComparison . $arrAttr ['end'] . '; ' . $arrAttr ['var'] . $sMinusPlus . $arrAttr ['step'] . ' ) : ?' . '>' . $this->getNodeBody_ ( $arrTheme ) . '<' . '?php endfor; ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * while
     *
     * @param array $arrTheme            
     * @return void
     */
    public function whileNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $arrAttr = $this->getNodeAttribute_ ( $arrTheme );
        
        $sCompiled = '<' . '?php while( ' . $arrAttr ['condition'] . ' ) : ?' . '>' . $this->getNodeBody_ ( $arrTheme ) . '<' . '?php endwhile; ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * break
     *
     * @param array $arrTheme            
     * @return void
     */
    public function breakNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $sCompiled = '<' . '?php break; ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * continue
     *
     * @param array $arrTheme            
     * @return void
     */
    public function continueNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $sCompiled = '<' . '?php continue; ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * php
     *
     * @param array $arrTheme            
     * @return void
     */
    public function phpNodeCompiler(&$arrTheme) {
        $this->checkNode_ ( $arrTheme );
        $sCompiled = '<' . '?php ' . $this->getNodeBody_ ( $arrTheme ) . ' ?' . '>';
        $arrTheme ['content'] = $sCompiled;
    }
    
    /**
     * 属性编译
     *
     * @param array $arrTheme            
     * @return void
     */
    public function attributeNodeCompiler(&$arrTheme) {
        $sSource = trim ( $arrTheme ['content'] );
        $this->escapeCharacter_ ( $sSource );
        
        if ($arrTheme ['is_js'] === true) {
            $arrTag = $this->arrJsTag;
        } else {
            $arrTag = $this->arrNodeTag;
        }
        
        $arrAllowedAttr = $arrTag [$arrTheme ['parent_name']] ['attr'];
        
        // 正则匹配
        $arrRegexp = [ ];
        $arrRegexp [] = "/(([^=\s]+)=)?\"([^\"]+)\"/"; // xxx="yyy" 或 "yyy" 格式
        $arrRegexp [] = "/(([^=\s]+)=)?'([^\']+)'/"; // xxx='yyy' 或 'yyy' 格式
        $arrRegexp [] = "/(([^=\s]+)=)?([^\s]+)/"; // xxx=yyy 或 yyy 格式
        $nNameIdx = 2;
        $nValueIdx = 3;
        $nDefaultIdx = 0;
        foreach ( $arrRegexp as $sRegexp ) {
            if (preg_match_all ( $sRegexp, $sSource, $arrRes )) {
                foreach ( $arrRes [0] as $nIdx => $sAttribute ) {
                    $sSource = str_replace ( $sAttribute, '', $sSource );
                    $sName = $arrRes [$nNameIdx] [$nIdx];
                    if (empty ( $sName )) {
                        $nDefaultIdx ++;
                        $sName = 'condition' . $nDefaultIdx;
                    } else {
                        // 过滤掉不允许的属性
                        if (! in_array ( $sName, $arrAllowedAttr )) {
                            continue;
                        }
                    }
                    
                    $sValue = $arrRes [$nValueIdx] [$nIdx];
                    $this->escapeCharacter_ ( $sValue, false );
                    $arrTheme ['attribute_list'] [strtolower ( $sName )] = $sValue;
                }
            }
        }
        // 补全节点其余参数
        foreach ( $arrAllowedAttr as $str ) {
            if (! isset ( $arrTheme ['attribute_list'] [$str] )) {
                $arrTheme ['attribute_list'] [$str] = NULL;
            }
        }
        $arrTheme ['content'] = $sSource;
    }
    
    // ######################################################
    // ------------------- node 编译器 end -------------------
    // ######################################################
    
    // ######################################################
    // ------------------ 返回编译器映射 start ------------------
    // ######################################################
    
    /**
     * code
     *
     * @return array
     */
    public function getCodeMapHelp() {
        return $this->arrCodeMap;
    }
    
    /**
     * node
     *
     * @return array
     */
    public function getNodeMapHelp() {
        return $this->arrNodeMap;
    }
    
    /**
     * js
     *
     * @return array
     */
    public function getJsMapHelp() {
        return $this->arrJsMap;
    }
    
    /**
     * node.tag
     *
     * @return array
     */
    public function getNodeTagHelp() {
        return $this->arrNodeTag;
    }
    
    /**
     * js.tag
     *
     * @return array
     */
    public function getJsTagHelp() {
        return $this->arrJsTag;
    }
    
    // ######################################################
    // ------------------- 返回编译器映射 end -------------------
    // ######################################################
    
    /**
     * 返回项目容器
     *
     * @return \queryyetsimple\mvc\project
     */
    public function project() {
        return project::bootstrap ();
    }
    
    // ######################################################
    // --------------------- 私有函数 start --------------------
    // ######################################################
    
    /**
     * 分析if
     *
     * @param string $sContent            
     * @param string $sType            
     * @return string
     */
    private function parseContentIf_($sContent, $sType = '') {
        $arrArray = explode ( ' ', $sContent );
        $bObj = false;
        $arrParam = [ ];
        foreach ( $arrArray as $sV ) {
            if (strpos ( $sV, '.' ) > 0) {
                $arrArgs = explode ( '.', $sV );
                $arrParam [] = $arrArgs [0] . ($this->arrayHandler_ ( $arrArgs, 1, 1 )); // 以$hello['hello1']['hello2']['hello2']方式
                $arrParamTwo [] = $arrArgs [0] . ($this->arrayHandler_ ( $arrArgs, 2, 1 )); // 以$hello->'hello1->'hello2'->'hello2'方式
                $bObj = true;
            } else {
                $arrParam [] = $sV;
                $arrParamTwo [] = $sV;
            }
        }
        
        if ($bObj) {
            $sStr = 'is_array(' . $arrArgs [0] . ')' . '?' . join ( ' ', $arrParam ) . ':' . join ( ' ', $arrParamTwo );
        } else {
            $sStr = join ( ' ', $arrParam );
        }
        
        $sStr = str_replace ( ':', '->', $sStr );
        $sStr = str_replace ( '+', '::', $sStr );
        
        return $sType . "if ( {$sStr} ) ";
    }
    
    /**
     * 解析 JS 变量内容
     *
     * @param string $sContent            
     * @return string
     */
    private function parseJsContent_($sContent) {
        $arrVar = explode ( '|', $sContent );
        $sContent = array_shift ( $arrVar );
        
        if (count ( $arrVar ) > 0) {
            $sContent = $this->parseJsFunction_ ( $sContent, $arrVar );
        }
        
        return '(' . $sContent . ')';
    }
    
    /**
     * 解析 JS 函数
     *
     * @param string $sName            
     * @param array $arrVar            
     * @return string
     */
    private function parseJsFunction_($sName, $arrVar) {
        return $this->parseVarFunction_ ( $sName, $arrVar, true );
    }
    
    /**
     * 解析变量内容
     *
     * @param string $sContent            
     * @param bool $booFunc
     *            是否允许解析函数
     * @return string
     */
    private function parseContent_($sContent, $booFunc = true) {
        $sContent = str_replace ( ':', '->', $sContent ); // 以|分割字符串,数组第一位是变量名字符串,之后的都是函数参数&&函数{$hello|md5}
        
        $arrVar = explode ( '|', $sContent );
        $sVar = array_shift ( $arrVar ); // 弹出第一个元素,也就是变量名
        if (strpos ( $sVar, '.' )) { // 访问数组元素或者属性
            $arrVars = explode ( '.', $sVar );
            if (substr ( $arrVars ['1'], 0, 1 ) == "'" or substr ( $arrVars ['1'], 0, 1 ) == '"' or substr ( $arrVars ['1'], 0, 1 ) == "$") {
                $sName = '$' . $arrVars [0] . '.' . $arrVars [1] . ($this->arrayHandler_ ( $arrVars, 3 )); // 特殊的.连接字符串
            } else {
                $bIsObject = false; // 解析对象的方法
                if (substr ( $sContent, - 1 ) == ')') {
                    $bIsObject = true;
                }
                
                if ($bIsObject === false) { // 非对象
                    switch (strtolower ( $this->getExpansionInstanceArgs_ ( 'theme_var_identify' ) )) {
                        case 'array' : // 识别为数组
                            $sName = '$' . $arrVars [0] . '[\'' . $arrVars [1] . '\']' . ($this->arrayHandler_ ( $arrVars ));
                            break;
                        case 'obj' : // 识别为对象
                            $sName = '$' . $arrVars [0] . '->' . $arrVars [1] . ($this->arrayHandler_ ( $arrVars, 2 ));
                            break;
                        default : // 自动判断数组或对象 支持多维
                            $sName = 'is_array( $' . $arrVars [0] . ' ) ? $' . $arrVars [0] . '[\'' . $arrVars [1] . '\']' . ($this->arrayHandler_ ( $arrVars )) . ' : $' . $arrVars [0] . '->' . $arrVars [1] . ($this->arrayHandler_ ( $arrVars, 2 ));
                            break;
                    }
                } else {
                    $sName = '$' . $arrVars [0] . '->' . $arrVars [1] . ($this->arrayHandler_ ( $arrVars, 2 ));
                }
            }
            $sVar = $arrVars [0];
        } elseif (strpos ( $sVar, '[' )) { // $hello['demo'] 方式访问数组
            $sName = "$" . $sVar;
            preg_match ( '/(.+?)\[(.+?)\]/is', $sVar, $arrArray );
            $sVar = $arrArray [1];
        } else {
            $sName = "\$$sVar";
        }
        
        if ($booFunc === true && count ( $arrVar ) > 0) { // 如果有使用函数
            $sName = $this->parseVarFunction_ ( $sName, $arrVar ); // 传入变量名,和函数参数继续解析,这里的变量名是上面的判断设置的值
        }
        
        $sName = str_replace ( '^', ':', $sName );
        return ! empty ( $sName ) ? $sName : '';
    }
    
    /**
     * 解析函数
     *
     * @param string $sName            
     * @param array $arrVar            
     * @param bool $bJs
     *            是否为 JS 变量解析
     * @return string
     */
    private function parseVarFunction_($sName, $arrVar, $bJs = false) {
        $nLen = count ( $arrVar );
        // 取得模板禁止使用函数列表
        $arrNot = explode ( ',', $this->getExpansionInstanceArgs_ ( 'theme_notallows_func' . ($bJs ? '' : '_js') ) );
        for($nI = 0; $nI < $nLen; $nI ++) {
            if (0 === stripos ( $arrVar [$nI], 'default=' )) {
                $arrArgs = explode ( '=', $arrVar [$nI], 2 );
            } else {
                $arrArgs = explode ( '=', $arrVar [$nI] );
            }
            
            $arrArgs [0] = trim ( $arrArgs [0] );
            
            if ($bJs === false) {
                $arrArgs [0] = str_replace ( '+', '::', $arrArgs [0] );
                if (isset ( $arrArgs [1] )) {
                    $arrArgs [1] = str_replace ( '->', ':', $arrArgs [1] );
                }
            }
            
            switch (strtolower ( $arrArgs [0] )) {
                case 'default' : // 特殊模板函数
                    $sName = '( ' . $sName . ' ) ? ( ' . $sName . ' ) : ' . $arrArgs [1];
                    break;
                default : // 通用模板函数
                    if (! in_array ( $arrArgs [0], $arrNot )) {
                        if (isset ( $arrArgs [1] )) {
                            if (strstr ( $arrArgs [1], '**' )) {
                                $arrArgs [1] = str_replace ( '**', $sName, $arrArgs [1] );
                                $sName = "$arrArgs[0] ( $arrArgs[1] )";
                            } else {
                                $sName = "$arrArgs[0] ( $sName,$arrArgs[1] )";
                            }
                        } elseif (! empty ( $arrArgs [0] )) {
                            $sName = "$arrArgs[0] ( $sName )";
                        }
                    }
            }
        }
        
        return $sName;
    }
    
    /**
     * 转换对象方法和静态方法连接符
     *
     * @param string $sContent            
     * @return string
     */
    private function parseConditionHelp_($sContent) {
        return str_replace ( [ 
                ':',
                '+' 
        ], [ 
                '->',
                '::' 
        ], $sContent );
    }
    
    /**
     * 数组格式
     *
     * @param array $arrVars            
     * @param number $nType            
     * @param number $nGo            
     * @return string
     */
    private function arrayHandler_(&$arrVars, $nType = 1, $nGo = 2) {
        $nLen = count ( $arrVars );
        
        $sParam = '';
        if ($nType == 1) { // 类似$hello['test']['test2']
            for($nI = $nGo; $nI < $nLen; $nI ++) {
                $sParam .= "['{$arrVars[$nI]}']";
            }
        } elseif ($nType == '2') { // 类似$hello->test1->test2
            for($nI = $nGo; $nI < $nLen; $nI ++) {
                $sParam .= "->{$arrVars[$nI]}";
            }
        } elseif ($nType == '3') { // 类似$hello.test1.test2
            for($nI = $nGo; $nI < $nLen; $nI ++) {
                $sParam .= ".{$arrVars[$nI]}";
            }
        }
        
        return $sParam;
    }
    
    /**
     * 编码内容
     *
     * @param string $sContent            
     * @param string $sContent            
     * @return string
     */
    private function encodeContent_($sContent, $sType = '') {
        if ($sType == 'global') {
            $sContent = parsers::globalEncode ( $sContent );
        } else if (in_array ( $sType, [ 
                'revert',
                'include' 
        ] )) {
            $sContent = base64_decode ( $sContent );
        } else {
            $sContent = parsers::revertEncode ( $sContent );
        }
        return $sContent;
    }
    
    /**
     * 验证节点是否正确
     *
     * @param array $arrTheme            
     * @return boolean
     */
    private function checkNode_($arrTheme, $bJsNode = false) {
        $arrAttribute = $arrTheme ['children'] [0];
        
        // 验证标签的属性值
        if ($arrAttribute ['is_attribute'] !== true) {
            exceptions::throwException ( __ ( '标签属性类型验证失败' ), 'queryyetsimple\view\exception' );
        }
        
        // 验证必要属性
        $arrTag = $bJsNode === true ? $this->arrJsTag : $this->arrNodeTag;
        if (! isset ( $arrTag [$arrTheme ['name']] )) {
            exceptions::throwException ( __ ( '标签 %s 未定义', $arrTheme ['name'] ), 'queryyetsimple\view\exception' );
        }
        
        foreach ( $arrTag [$arrTheme ['name']] ['required'] as $sName ) {
            $sName = strtolower ( $sName );
            if (! isset ( $arrAttribute ['attribute_list'] [$sName] )) {
                exceptions::throwException ( __ ( '节点 “%s” 缺少必须的属性：“%s”', $arrTheme ['name'], $sName ), 'queryyetsimple\view\exception' );
            }
        }
        
        return true;
    }
    
    /**
     * 取得节点的属性列表
     *
     * @param array $arrTheme
     *            节点
     * @return array
     */
    private function getNodeAttribute_($arrTheme) {
        foreach ( $arrTheme ['children'] as $arrChild ) {
            if (isset ( $arrChild ['is_attribute'] ) && $arrChild ['is_attribute'] == 1) {
                return $arrChild ['attribute_list'];
            }
        }
        return [ ];
    }
    
    /**
     * 取得body编译内容
     *
     * @param array $arrTheme
     *            节点
     * @return array
     */
    private function getNodeBody_($arrTheme) {
        foreach ( $arrTheme ['children'] as $arrChild ) {
            if (isset ( $arrChild ['is_body'] ) && $arrChild ['is_body'] == 1) {
                return $arrChild ['content'];
            }
        }
        return null;
    }
    
    /**
     * 正则属性转义
     *
     * @param string $sTxt            
     * @param bool $bEsc            
     * @return string
     */
    private function escapeCharacter_(&$sTxt, $bEsc = true) {
        $sTxt = helper::escapeCharacter ( $sTxt, $bEsc );
        if (! $bEsc) {
            $sTxt = str_replace ( [ 
                    ' nheq ',
                    ' heq ',
                    ' neq ',
                    ' eq ',
                    ' egt ',
                    ' gt ',
                    ' elt ',
                    ' lt ' 
            ], [ 
                    '!==',
                    '===',
                    '!=',
                    '==',
                    '>=',
                    '>',
                    '<=',
                    '<' 
            ], $sTxt );
        }
        return $sTxt;
    }
    
    // ######################################################
    // --------------------- 私有函数 end ---------------------
    // ######################################################
}
