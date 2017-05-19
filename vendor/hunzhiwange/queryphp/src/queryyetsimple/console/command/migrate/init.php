<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\console\command\migrate;

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

use Phinx\Console\Command\Init as PhinxInit;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 数据库迁移初始化
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.09
 * @version 1.0
 */
class init extends PhinxInit {
    
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure() {
        parent::configure ();
        $this->setName ( 'migrate:init' );
    }
    
    /**
     * Initializes the application.
     * 重写读取配置文件，个性化配置，例外默认配置文件有一个解析 BUG
     *
     * @param InputInterface $input            
     * @param OutputInterface $output            
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        // get the migration path from the config
        $path = $input->getArgument ( 'path' );
        
        if (null === $path) {
            $path = getcwd ();
        }
        
        $path = realpath ( $path );
        
        if (! is_writable ( $path )) {
            throw new \InvalidArgumentException ( sprintf ( 'The directory "%s" is not writable', $path ) );
        }
        
        // Compute the file path
        $fileName = 'phinx.yml'; // TODO - maybe in the future we allow custom config names.
        $filePath = $path . DIRECTORY_SEPARATOR . $fileName;
        
        if (file_exists ( $filePath )) {
            throw new \InvalidArgumentException ( sprintf ( 'The file "%s" already exists', $filePath ) );
        }
        
        // load the config template
        // 自定义 migrate.yml 文件
        $contents = file_get_contents ( __DIR__ . '/migrate.yml' );
        
        if (false === file_put_contents ( $filePath, $contents )) {
            throw new \RuntimeException ( sprintf ( 'The file "%s" could not be written to', $path ) );
        }
        
        $output->writeln ( '<info>created</info> .' . str_replace ( getcwd (), '', $filePath ) );
    }
}  
