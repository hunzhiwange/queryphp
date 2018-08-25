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

use UI\Controls\Box;
use UI\Controls\Button;
use UI\Controls\Group;
use UI\Controls\Label;
use UI\Controls\Tab;
use UI\Size;
use UI\Window;

/**
 * phpui 启动界面.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class index extends Window
{
    /**
     * 构造函数.
     *
     * @param string $sTitle
     */
    public function __construct(string $sTitle)
    {
        parent::__construct('QueryPHP For PHPUI 启动界面 - '.$sTitle, new Size(640, 480), true);
        // $this->setMargin(true);
        $this->init();
    }

    /**
     * 初始化.
     */
    protected function init()
    {
        $this->mainTab();
    }

    /**
     * 创建主标签.
     */
    protected function mainTab()
    {
        $oMainTab = new Tab();

        $arrTab = [
            'about' => '关于 QueryPHP',
            'demo'  => '官方示例',
        ];

        foreach ($arrTab as $sKey=>$sTab) {
            $oMainTab->append($sTab, $this->{$sKey.'TabBox'}());
            $oMainTab->setMargin(0, true);
        }

        $this->add($oMainTab);
    }

    /**
     * 关于我们标签.
     *
     * @return \UI\Controls\Box
     */
    protected function aboutTabBox()
    {
        $oVBox = new Box(Box::Vertical);
        $oVBox->setPadded(true);

        $arrGroups = [
            'The QueryPHP Framework' => [
                'QueryPHP is a powerful PHP framework for code poem as free as wind. [Query Yet Simple]',
                'QueryPHP was founded in 2010 and released the first version on 2010.10.03.',
            ],
            'Official Documentation' => [
                'Documentation for the framework can be found on the QueryPHP website.',
                'For detail please visite http://www.queryphp.com.',
            ],
            'License' => [
                'The QueryPHP framework is open-sourced software licensed under the MIT license.',
            ],
        ];

        foreach ($arrGroups as $sKey=>$arrItem) {
            $oGroup = new Group($sKey);
            $oGroup->setMargin(true);

            $oGroupVBox = new Box(Box::Vertical);
            $oGroupVBox->setPadded(true);

            foreach ($arrItem as $sItem) {
                $oGroupVBox->append(new Label($sItem));
            }

            $oGroup->append($oGroupVBox);

            $oVBox->append($oGroup);
        }

        return $oVBox;
    }

    /**
     * 官方示例标签.
     *
     * @return \UI\Controls\Box
     */
    protected function demoTabBox()
    {
        $oVBox = new Box(Box::Vertical);
        $oVBox->setPadded(true);

        $arrDemo = [
            '基础功能' => 'gallery',
            '贪吃蛇'  => 'snake',
            '柱状图'  => 'histogram',
            '星空'   => 'starfield',
        ];

        foreach ($arrDemo as $sKey=>$strDemo) {
            $oDemoButton = new class($sKey, $strDemo) extends Button {
                private $strDemo;

                public function __construct(string $sText, string $strDemo)
                {
                    $this->strDemo = $strDemo;
                    parent::__construct($sText);
                }

                protected function onClick()
                {
                    include $this->strDemo.'.php';
                }
            };

            $oVBox->append($oDemoButton);
        }

        return $oVBox;
    }
}

$oWindow = new index($strHelloworld);
$oWindow->show();

UI\run();

return 'phpui exit';
