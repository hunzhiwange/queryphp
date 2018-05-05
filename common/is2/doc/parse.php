<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\is\doc;

/**
 * 文档注释分析
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.09
 * @see https://github.com/murraypicton/Doqumentor
 * @version 1.0
 */
class parse
{
    
    /**
     * 解析的参数
     * 
     * @var array
     */
    protected $arrParams = [];
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
    }
    
    /**
     * 分析文档注释
     * 
     * @param string $sSource
     * @return aray
     */
    public function parse($strSource)
    {
        $strSource = trim($strSource);
        if ($strSource == '') {
            return [];
        }
        
        if (preg_match('#^/\*\*(.*)\*/#s', $strSource, $arrComment) === false || ! isset($arrComment[1]) || ! ($strComment = trim($arrComment[1]))) {
            return [];
        }
        
        if (preg_match_all('#^\s*\*(.*)#m', $strComment, $arrLine) === false)
            return [];
        
        $this->arrParams = [];
        $this->parseLines($arrLine[1]);
        return $this->arrParams;
    }
    
    /**
     * 解析注释
     * 
     * @param array $arrLine
     * @return aray
     */
    protected function parseLines(array $arrLine)
    {
        foreach ($arrLine as $sLine) {
            $sLine = $this->parseLine($sLine);
            if ($sLine === false && ! isset($this->arrParams['description'])) {
                if (isset($arrDesc)) {
                    $this->arrParams['description'] = implode(PHP_EOL, $arrDesc);
                }
                $arrDesc = [];
            } elseif ($sLine !== false) {
                $arrDesc[] = $sLine;
            }
        }
    }
    
    /**
     * 解析注释每行
     * 
     * @param string $sLine
     * @return string|boolean
     */
    protected function parseLine($sLine)
    {
        $sLine = trim($sLine);
        
        if (empty($sLine)) {
            return false;
        }
        
        if (strpos($sLine, '@') === 0) {
            if (strpos($sLine, ' ') > 0) {
                $sParam = substr($sLine, 1, strpos($sLine, ' ') - 1);
                $sValue = substr($sLine, strlen($sParam) + 2);
            } else {
                $sParam = substr($sLine, 1);
                $sValue = '';
            }
            
            $this->setParam($sParam, $sValue);
            return false;
        }
        
        return $sLine;
    }
    
    /**
     * 设置解析参数
     * 
     * @param string $sParam
     * @param string $sValue
     * @return void
     */
    protected function setParam($sParam, $sValue)
    {
        if ($sParam == 'param' || $sParam == 'return')
            $sValue = $this->formatParamOrReturn($sValue);
        
        if ($sParam == 'param') {
            if (! isset($this->arrParams[$sParam])) {
                $this->arrParams[$sParam] = [];
            }
            $this->arrParams[$sParam][] = $sValue;
        } else {
            $this->arrParams[$sParam] = $sValue;
        }
    }
    
    /**
     * 格式化参数和返回值
     * 
     * @param string $str
     * @return string
     */
    protected function formatParamOrReturn($str)
    {
        $nPos = strpos($str, ' ');
        $sType = substr($str, 0, $nPos);
        return '(' . $sType . ')' . substr($str, $nPos + 1);
    }
}  
