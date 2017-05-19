<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\console\command\make;

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
 * 生成模型
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.03
 * @version 1.0
 */
class controller extends base {
    
    /**
     * 命令描述
     *
     * @var string
     */
    protected $strDescription = 'Create a new controller';
    
    /**
     * 命令帮助
     *
     * @var string
     */
    protected $strHelp = <<<EOF
The <info>%command.name%</info> command to make controller with default_app namespace:

  <info>php %command.full_name% name</info>

You can also by using the <comment>--namespace</comment> option:

  <info>php %command.full_name% name --namespace=common</info>
EOF;
    
    /**
     * 注册命令
     *
     * @var string
     */
    protected $strSignature = 'make:controller {name : This is the controller name.} {--namespace= : Namespace registered to system,default namespace is these "common,home,~_~"}';
    
    /**
     * 响应命令
     *
     * @return void
     */
    public function handle() {
        // 处理命名空间路径
        $this->parseNamespace_ ();
        
        // 保存路径
        $this->setSaveFilePath_ ( $this->getNamespacePath_ () . 'application/controller/' . $this->argument ( 'name' ) . '.php' );
        
        // 设置类型
        $this->setMakeType_ ( 'controller' );
        
        // 执行
        parent::handle ();
    }
}  