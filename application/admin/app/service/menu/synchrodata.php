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

namespace admin\app\service\menu;

use common\domain\entity\menu as entity;
use common\is\doc\parse as doc_parse;
use common\is\repository\menu as repository;
use Exception;
use queryyetsimple\filesystem\fso;
use queryyetsimple\psr4;
use ReflectionClass;
use ReflectionMethod;

/**
 * 菜单数据同步.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.09
 *
 * @version 1.0
 */
class synchrodata
{
    /**
     * 菜单仓储.
     *
     * @var \common\is\repository\menu
     */
    protected $oRepository;

    /**
     * 文档分析.
     *
     * @var \common\is\doc\parse
     */
    protected $objDocParse;

    /**
     * 当前菜单.
     *
     * @var \common\domain\entity\menu|false
     */
    protected $mixCurrentMenu;

    /**
     * 菜单应用.
     *
     * @var array
     */
    protected $arrResultLevel1 = [];

    /**
     * 菜单分类.
     *
     * @var array
     */
    protected $arrResultLevel2 = [];

    /**
     * 菜单控制器.
     *
     * @var array
     */
    protected $arrResultLevel3 = [];

    /**
     * 菜单方法.
     *
     * @var array
     */
    protected $arrResultLevel4 = [];

    /**
     * 构造函数.
     *
     * @param \common\is\doc\parse       $objDocParse
     * @param \common\is\repository\menu $oRepository
     */
    public function __construct(doc_parse $objDocParse, repository $oRepository)
    {
        $this->objDocParse = $objDocParse;
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法.
     *
     * @param bool $booReplace
     */
    public function run($booReplace)
    {
        $this->parseFileComment();

        foreach ([1, 2, 3, 4] as $intLevel) {
            $arrCommentResult = $this->{'arrResultLevel'.$intLevel};
            foreach ($arrCommentResult as $arrMenu) {
                $this->createMenu($arrMenu, $booReplace);
            }
        }
    }

    /**
     * 创建一条菜单.
     *
     * @param array $arrMenu
     * @param bool  $booReplace
     */
    protected function createMenu(array $arrMenu, $booReplace)
    {
        $arrMenu['pid'] = $this->parseParentId($arrMenu);

        try {
            $this->tryFindMenu($arrMenu);
            if (!$this->mixCurrentMenu) {
                $this->createNewMenu($arrMenu);
            } else {
                $this->updateMenu($arrMenu, $booReplace);
            }
        } catch (Exception $oE) {
        }
    }

    /**
     * 创建一条新菜单.
     *
     * @param array $arrMenu
     */
    protected function createNewMenu(array $arrMenu)
    {
        $this->oRepository->create($this->entity($this->data($arrMenu)));
    }

    /**
     * 更新菜单.
     *
     * @param intval $intMenuId
     * @param array  $arrMenu
     * @param bool   $booReplace
     */
    protected function updateMenu(array $arrMenu, $booReplace)
    {
        if (!$booReplace || 2 === $arrMenu['level']) {
            return;
        }

        $this->oRepository->update($this->entifyUpdate($arrMenu));
    }

    /**
     * 更新实体.
     *
     * @param array $arrMenu
     *
     * @return \common\domain\entity\menu
     */
    protected function entifyUpdate(array $arrMenu)
    {
        $objMenu = $this->mixCurrentMenu;

        $objMenu->forceProps($this->dataUpdate($arrMenu));

        return $objMenu;
    }

    /**
     * 尝试获取菜单是否存在.
     *
     * @param array $arrMenu
     */
    protected function tryFindMenu(array $arrMenu)
    {
        $this->mixCurrentMenu = $this->oRepository->

        where('app', $arrMenu['app'])->

        where('controller', $arrMenu['controller'])->

        where('action', $arrMenu['action'])->

        setColumns('id')->

        getOne();
    }

    /**
     * 获取父级 ID.
     *
     * @param array $arrMenu
     *
     * @return intval
     */
    protected function parseParentId(array $arrMenu)
    {
        if (1 === $arrMenu['level']) {
            return 0;
        }
        $arrParent = $this->oRepository->

            where('app', $arrMenu['app'])->

            where('controller', 2 === $arrMenu['level'] ? '' : (3 === $arrMenu['level'] ? $arrMenu['category'] : $arrMenu['controller']))->

            where('action', '')->

            setColumns('id')->

            getOne();

        return $arrParent['id'];
    }

    /**
     * 分析控制器文件的注释信息.
     */
    protected function parseFileComment()
    {
        $arrApps = [
            'admin' => '后台管理',
        ];

        foreach ($arrApps as $sApp => $strAppTitle) {
            $sNamespace = $sApp.'\app\controller';

            $this->arrResultLevel1[$sApp] =
            [
                'title'      => $strAppTitle,
                'name'       => $sApp,
                'path'       => '',
                'component'  => 'layout',
                'icon'       => '',
                'app'        => $sApp,
                'controller' => '',
                'action'     => '',
                'level'      => 1,
                'status'     => 'enable',
                'type'       => 'app',
            ];

            $strNamespacePath = psr4::namespaces($sNamespace);

            fso::listDirectory($strNamespacePath, function ($objFile) use ($sApp,$strNamespacePath,$sNamespace) {
                if ($objFile->isFile()) {
                    $sFile = $objFile->getPath().'/'.$objFile->getFilename();
                    $this->mergeCommentResult($this->comment($sApp, $sNamespace, str_replace($strNamespacePath.'/', '', $sFile)));
                }
            });
        }
    }

    /**
     * 分析方法注释.
     *
     * @param string $sApp
     * @param string $sNamespace
     * @param string $sFile
     *
     * @return array
     */
    protected function commentAction($sApp, $sNamespace, $sFile)
    {
        $arrResult = [];

        $sFile = str_replace('.php', '', $sFile);
        $arrFile = explode('/', $sFile);
        $sController = array_shift($arrFile);
        $sAction = array_shift($arrFile);
        $sClass = $sNamespace.'\\'.$sController.'\\'.$sAction;

        $arrDocComment = $this->objDocParse->parse((new ReflectionClass($sClass))->getDocComment());
        if (isset($arrDocComment['menu'])) {
            $arrDocComment = $this->formatComment($arrDocComment);
            $arrDocComment['app'] = $sApp;
            $arrDocComment['controller'] = $sController;
            $arrDocComment['action'] = $sAction;
            $arrDocComment['level'] = 4;
            $arrDocComment['status'] = 'enable';
            $arrDocComment['type'] = 'action';
            $arrResult[] = $arrDocComment;
        }

        return $arrResult;
    }

    /**
     * 分析控制器注释.
     *
     * @param string $sApp
     * @param string $sNamespace
     * @param string $sFile
     *
     * @return array
     */
    protected function comment($sApp, $sNamespace, $sFile)
    {
        if (false !== strpos($sFile, '/')) {
            return $this->commentAction($sApp, $sNamespace, $sFile);
        }

        $arrResult = [];

        $sController = fso::getName($sFile);
        $sClass = $sNamespace.'\\'.$sController;

        $oReflection = new ReflectionClass($sClass);
        $arrDocComment = $this->objDocParse->parse($oReflection->getDocComment());
        if (isset($arrDocComment['menu'])) {
            $arrDocComment = $this->formatComment($arrDocComment);
            $arrDocComment['app'] = $sApp;
            $arrDocComment['controller'] = $sController;
            $arrDocComment['name'] = $sController;
            $arrDocComment['path'] = $sController;
            $arrDocComment['action'] = '';
            $arrDocComment['level'] = 3;
            $arrDocComment['status'] = 'disable';
            $arrDocComment['type'] = 'controller';
            $arrResult[] = $arrDocComment;
        }

        $arrMethod = $oReflection->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($arrMethod as $oMethod) {
            $arrDocComment = $this->objDocParse->parse($oMethod->getDocComment());
            if (isset($arrDocComment['menu'])) {
                $arrDocComment = $this->formatComment($arrDocComment);
                $arrDocComment['app'] = $sApp;
                $arrDocComment['controller'] = $sController;
                $arrDocComment['action'] = $oMethod->getName();
                $arrDocComment['level'] = 4;
                $arrDocComment['status'] = 'enable';
                $arrDocComment['type'] = 'action';
                $arrResult[] = $arrDocComment;
            }
        }

        return $arrResult;
    }

    /**
     * 格式化注释块.
     *
     * @param array $arrDocComment
     *
     * @return array
     */
    protected function formatComment(array $arrDocComment)
    {
        $arrResult = [];

        $arrResult['title'] = !empty($arrDocComment['title']) ? $arrDocComment['title'] : (!empty($arrDocComment['description']) ? $arrDocComment['description'] : '');
        $arrResult['name'] = !empty($arrDocComment['name']) ? $arrDocComment['name'] : '';
        $arrResult['path'] = !empty($arrDocComment['path']) ? $arrDocComment['path'] : '';
        $arrResult['component'] = !empty($arrDocComment['component']) ? $arrDocComment['component'] : 'layout';
        $arrResult['icon'] = !empty($arrDocComment['icon']) ? $arrDocComment['icon'] : '';
        $arrResult['app'] = !empty($arrDocComment['app']) ? $arrDocComment['app'] : '';
        $arrResult['controller'] = !empty($arrDocComment['controller']) ? $arrDocComment['controller'] : '';
        $arrResult['action'] = !empty($arrDocComment['action']) ? $arrDocComment['action'] : '';
        $arrResult['category'] = !empty($arrDocComment['category']) ? $arrDocComment['category'] : '';

        return $arrResult;
    }

    /**
     * 合并注释块结果.
     *
     * @param array $arrNewDocComment
     *
     * @return array
     */
    protected function mergeCommentResult(array $arrNewDocComment)
    {
        foreach ($arrNewDocComment as $arrItem) {
            if (3 === $arrItem['level']) {
                $this->arrResultLevel3[] = $arrItem;

                if ($arrItem['category']) {
                    $arrItem['title'] = $arrItem['category'];
                    $arrItem['name'] = $arrItem['category'];
                    $arrItem['path'] = $arrItem['category'];
                    $arrItem['controller'] = $arrItem['category'];
                    $arrItem['category'] = '';
                    $arrItem['level'] = 2;
                    $arrItem['icon'] = '';
                    $arrItem['type'] = 'category';
                    $this->arrResultLevel2[$arrItem['category']] = $arrItem;
                }
            } elseif (4 === $arrItem['level']) {
                $this->arrResultLevel4[] = $arrItem;
            }
        }
    }

    /**
     * 组装 POST 数据.
     *
     * @param array $aMenu
     *
     * @return array
     */
    protected function data(array $aMenu)
    {
        return [
            'pid'        => (int) ($aMenu['pid']),
            'title'      => !empty($aMenu['title']) ? trim($aMenu['title']) : '',
            'name'       => trim($aMenu['name']),
            'path'       => trim($aMenu['path']),
            'sort'       => 500,
            'status'     => isset($aMenu['status']) && 'enable' === $aMenu['status'] ? 'enable' : 'disable',
            'component'  => trim($aMenu['component']),
            'icon'       => trim($aMenu['icon']),
            'app'        => trim($aMenu['app']),
            'controller' => trim($aMenu['controller']),
            'action'     => trim($aMenu['action']),
            'category'   => !empty($aMenu['category']) ? $aMenu['category'] : '',
            'type'       => $aMenu['type'],
        ];
    }

    /**
     * 组装 POST 更新数据.
     *
     * @param array $aMenu
     *
     * @return array
     */
    protected function dataUpdate(array $aMenu)
    {
        return [
            'pid'       => (int) ($aMenu['pid']),
            'title'     => trim($aMenu['title']),
            'name'      => trim($aMenu['name']),
            'path'      => trim($aMenu['path']),
            'component' => trim($aMenu['component']),
            'icon'      => trim($aMenu['icon']),
            'category'  => !empty($aMenu['category']) ? $aMenu['category'] : '',
        ];
    }

    /**
     * 创建实体.
     *
     * @param array $aMenu
     *
     * @return \common\domain\entity\menu
     */
    protected function entity(array $aMenu)
    {
        return new entity($this->data($aMenu));
    }
}
