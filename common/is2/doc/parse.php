<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\is\doc;

/**
 * 文档注释分析.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.09
 * @see https://github.com/murraypicton/Doqumentor
 *
 * @version 1.0
 */
class parse
{
    /**
     * 解析的参数.
     *
     * @var array
     */
    protected $arrParams = [];

    /**
     * 构造函数.
     */
    public function __construct()
    {
    }

    /**
     * 分析文档注释.
     *
     * @param string $sSource
     * @param mixed  $strSource
     *
     * @return aray
     */
    public function parse($strSource)
    {
        $strSource = trim($strSource);
        if ('' === $strSource) {
            return [];
        }

        if (false === preg_match('#^/\*\*(.*)\*/#s', $strSource, $arrComment) || !isset($arrComment[1]) || !($strComment = trim($arrComment[1]))) {
            return [];
        }

        if (false === preg_match_all('#^\s*\*(.*)#m', $strComment, $arrLine)) {
            return [];
        }
        $this->arrParams = [];
        $this->parseLines($arrLine[1]);

        return $this->arrParams;
    }

    /**
     * 解析注释.
     *
     * @param array $arrLine
     *
     * @return aray
     */
    protected function parseLines(array $arrLine)
    {
        foreach ($arrLine as $sLine) {
            $sLine = $this->parseLine($sLine);
            if (false === $sLine && !isset($this->arrParams['description'])) {
                if (isset($arrDesc)) {
                    $this->arrParams['description'] = implode(PHP_EOL, $arrDesc);
                }
                $arrDesc = [];
            } elseif (false !== $sLine) {
                $arrDesc[] = $sLine;
            }
        }
    }

    /**
     * 解析注释每行.
     *
     * @param string $sLine
     *
     * @return bool|string
     */
    protected function parseLine($sLine)
    {
        $sLine = trim($sLine);

        if (empty($sLine)) {
            return false;
        }

        if (0 === strpos($sLine, '@')) {
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
     * 设置解析参数.
     *
     * @param string $sParam
     * @param string $sValue
     */
    protected function setParam($sParam, $sValue)
    {
        if ('param' === $sParam || 'return' === $sParam) {
            $sValue = $this->formatParamOrReturn($sValue);
        }

        if ('param' === $sParam) {
            if (!isset($this->arrParams[$sParam])) {
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
     *
     * @return string
     */
    protected function formatParamOrReturn($str)
    {
        $nPos = strpos($str, ' ');
        $sType = substr($str, 0, $nPos);

        return '('.$sType.')'.substr($str, $nPos + 1);
    }
}
