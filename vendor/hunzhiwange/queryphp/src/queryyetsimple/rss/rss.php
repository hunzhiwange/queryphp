<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\rss;

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
 * rss 2.0
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.08
 * @version 1.0
 */
class rss {
    
    /**
     * 频道信息
     *
     * @var array
     */
    private $arrOption = [ 
            'title' => '',
            'atom_link' => '',
            'link' => '',
            'description' => '',
            'language' => 'zh-cn',
            'pub_date' => '',
            'last_build_date' => '',
            'generator' => 'QueryPHP',
            'img_url' => '' 
    ];
    
    /**
     * rss 内容项
     *
     * @var array
     */
    private $arrItem = [ ];
    
    /**
     * 构造函数
     *
     * @param array $arrOption            
     * @return void
     */
    public function __construct($arrOption = []) {
        // 设置配置
        $this->setOption ( $arrOption );
        
        // 默认时间
        if (! $this->getOption ( 'pub_date' )) {
            $this->setOption ( 'pub_date', date ( 'Y-m-d H:i:s', time () ) );
        }
        if (! $this->getOption ( 'last_build_date' )) {
            $this->setOption ( 'last_build_date', date ( 'Y-m-d H:i:s', time () ) );
        }
    }
    
    /**
     *
     * @param string $sRssBody            
     */
    public function run($sRssBody = '') {
        header ( "Content-Type: text/xml; charset=utf-8" );
        echo $this->fetch ( $sRssBody );
        exit ();
    }
    
    /**
     * 添加一个项
     *
     * @param array $arrItem            
     * @return void
     */
    public function addItem($arrItem = []) {
        $arrItem = array_merge ( [ 
                'title' => '',
                'link' => '',
                'comments' => '',
                'pubdata' => '',
                'creator' => '',
                'category' => '',
                'guid' => '',
                'description' => '',
                'content_encoded' => '',
                'comment_rss' => '',
                'comment_num' => '' 
        ], $arrItem );
        $this->arrItems [] = $arrItem;
    }
    
    /**
     * 实现 __get
     *
     * @param string $sKey            
     * @return string
     */
    public function __get($sKey) {
        return $this->getOption ( $sKey );
    }
    
    /**
     * 实现 __set
     *
     * @param string $sKey            
     * @param string $sValue            
     * @return void
     */
    public function __set($sKey, $sValue) {
        $this->setOption ( $sKey, $sValue );
    }
    public function setOption($sKey, $sValue) {
        $oldValue = $this->{$sKey};
        $this->{$sKey} = $sValue;
        
        return $oldValue;
    }
    public function getOption($sKey) {
        return isset ( $this->getOption ( $sKey ) ) ? $this->getOption ( $sKey ) : null;
    }
    private function fetch_() {
        $sRss = $this->rssHeader ();
        $sRss .= $this->getRssBody ();
        $sRss .= $this->rssFooter ();
        return $sRss;
    }
    
    /**
     * rss 头部
     *
     * @return string
     */
    private function header_() {
        $arrRss = [ ];
        $arrRss [] = '<?xml version="1.0" encoding="UTF-8"?>';
        $arrRss [] = '<rss version="2.0" ';
        $arrRss [] = 'xmlns:content="http://purl.org/rss/1.0/modules/content/"';
        $arrRss [] = 'xmlns:wfw="http://wellformedweb.org/CommentAPI/"';
        $arrRss [] = 'xmlns:dc="http://purl.org/dc/elements/1.1/"';
        $arrRss [] = 'xmlns:atom="http://www.w3.org/2005/Atom"';
        $arrRss [] = 'xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"';
        $arrRss [] = 'xmlns:slash="http://purl.org/rss/1.0/modules/slash/">';
        $arrRss [] = '<channel>';
        $arrRss [] = '<title><![CDATA[' . $this->sChannelTitle . ']]></title>';
        $arrRss [] = '<atom:link href="' . $this->sAtomLink . '" rel="self" type="application/rss+xml" />';
        $arrRss [] = '<link>' . $this->sChannelLink . '</link>';
        $arrRss [] = '<description><![CDATA[' . $this->sChannelDescription . ']]></description>';
        $arrRss [] = '<sy:updatePeriod>hourly</sy:updatePeriod>';
        $arrRss [] = '<sy:updateFrequency>1</sy:updateFrequency>';
        $arrRss [] = '<language>' . $this->sLanguage . '</language>';
        
        if (! empty ( $this->sPubDate )) {
            $arrRss [] = '<pubDate>' . $this->sPubDate . '</pubDate>';
        }
        
        if (! empty ( $this->sLastBuildDate )) {
            $arrRss [] = '<lastBuildDate>' . $this->sLastBuildDate . '</lastBuildDate>';
        }
        
        if (! empty ( $this->_sGenerator )) {
            $arrRss [] = '<generator>' . $this->sGenerator . '</generator>';
        }
        
        if (! empty ( $this->sChannelImgurl )) {
            $arrRss [] = '<image>';
            $arrRss [] = '<title><![CDATA[' . $this->sChannelTitle . ']]></title>';
            $arrRss [] = '<link>' . $this->sChannelLink . '</link>';
            $arrRss [] = '<url>' . $this->sChannelImgurl . '</url>';
            $arrRss [] = '</image>';
        }
        
        return implode ( PHP_EOL, $arrRss );
    }
    
    /**
     * rss 内容
     *
     * @return string
     */
    private function body_() {
        $arrResult = [ ];
        
        foreach ( $this->arrItems as $arrItem ) {
            $arrTemp = [ ];
            $arrTemp [] = '<item>';
            $arrTemp [] = '<title><![CDATA[' . $arrItem ['title'] . ']]></title>';
            $arrTemp [] = '<link>' . $arrItem ['link'] . '</link>';
            $arrTemp [] = '<comments>' . $arrItem ['comments'] . '</comments>';
            $arrTemp [] = '<pubDate>' . $arrItem ['pubdata'] . '</pubDate>';
            $arrTemp [] = '<dc:creator>' . $arrItem ['creator'] . '</dc:creator>';
            $arrTemp [] = '<category><![CDATA[' . $arrItem ['category'] . ']]></category>';
            $arrTemp [] = '<guid isPermaLink="false">' . $arrItem ['guid'] . '</guid>';
            $arrTemp [] = '<description><![CDATA[' . $arrItem ['description'] . ']]></description>';
            $arrTemp [] = '<content:encoded><![CDATA[' . $arrItem ['content_encoded'] . ']]></content:encoded>';
            $arrTemp [] = '<wfw:commentRss>' . $arrItem ['comment_rss'] . '</wfw:commentRss>';
            $arrTemp [] = '<slash:comments>' . $arrItem ['comment_num'] . '</slash:comments>';
            $arrTemp [] = '</item>';
            $arrResult [] = implode ( $strNewLine, $arrTemp );
        }
        
        return implode ( PHP_EOL, $arrResult );
    }
}
