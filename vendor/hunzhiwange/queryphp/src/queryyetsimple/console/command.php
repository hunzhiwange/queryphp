<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\console;

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

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\DescriptorHelper;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 命令抽象类 <from lavarel>
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.28
 * @version 1.0
 */
abstract class command extends SymfonyCommand {
    
    /**
     * QueryPHP 容器
     *
     * @var \queryyetsimple\mvc\project
     */
    protected $objQueryPHP = null;
    
    /**
     * 命令名字
     *
     * @var string
     */
    protected $strName;
    
    /**
     * 命令行描述
     *
     * @var string
     */
    protected $strDescription;
    
    /**
     * 命令帮助
     *
     * @var string
     */
    protected $strHelp = '';
    
    /**
     * 注册命令
     *
     * @var string
     */
    protected $strSignature = '';
    
    /**
     * 输出映射
     *
     * @var array
     */
    protected static $arrVerbosityMap = [ 
            'v' => OutputInterface::VERBOSITY_VERBOSE,
            'vv' => OutputInterface::VERBOSITY_VERY_VERBOSE,
            'vvv' => OutputInterface::VERBOSITY_DEBUG,
            'quiet' => OutputInterface::VERBOSITY_QUIET,
            'normal' => OutputInterface::VERBOSITY_NORMAL 
    ];
    
    /**
     * 默认输出映射
     *
     * @var int
     */
    protected $intVerbosity = OutputInterface::VERBOSITY_NORMAL;
    
    /**
     * 输入接口
     *
     * @var object
     */
    protected $objInput;
    
    /**
     * 输入接口
     *
     * @var object
     */
    protected $objOutput;
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct() {
        if (! empty ( $this->strSignature )) {
            $this->fromSignature_ ();
        } else {
            parent::__construct ( $this->getName_ () );
        }
        $this->setDescription ( $this->getDescription_ () );
        $this->setHelp ( $this->getHelp_ () );
        if (empty ( $this->strSignature )) {
            $this->specifyParameters_ ();
        }
    }
    
    /**
     * 运行命令
     *
     * @param \Symfony\Component\Console\Input\InputInterface $objInput            
     * @param \Symfony\Component\Console\Output\OutputInterface $objOutput            
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output) {
        $this->objInput = $input;
        $this->objOutput = new SymfonyStyle ( $input, $output );
        return parent::run ( $input, $output );
    }
    
    /**
     * 响应命令
     *
     * @param object $input            
     * @param object $output            
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $strMethod = method_exists ( $this, 'handle' ) ? 'handle' : 'fire';
        return $this->getObjectCallbackResultWithMethodArgs_ ( [ 
                $this,
                $strMethod 
        ], [ 
                $input,
                $output 
        ] );
    }
    
    /**
     * 调用其他命令
     *
     * @param string $strCommand            
     * @param array $arrArguments            
     * @return int
     */
    public function call($strCommand, array $arrArguments = []) {
        $arrArguments ['command'] = $strCommand;
        return $this->getQueryPHP ()->make ( 'command_' . $strCommand )->run ( new ArrayInput ( $arrArguments ), $this->objOutput );
    }
    
    /**
     * 获取输入参数
     *
     * @param string $strKey            
     * @return string|array
     */
    public function argument($strKey = null) {
        if (is_null ( $strKey )) {
            return $this->objInput->getArguments ();
        }
        return $this->objInput->getArgument ( $strKey );
    }
    
    /**
     * 获取配置信息
     *
     * @param string $strKey            
     * @return string|array
     */
    public function option($strKey = null) {
        if (is_null ( $strKey )) {
            return $this->objInput->getOptions ();
        }
        return $this->objInput->getOption ( $strKey );
    }
    
    /**
     * 确认用户的问题
     *
     * @param string $strQuestion            
     * @param bool $booDefault            
     * @return bool
     */
    public function confirm($strQuestion, $booDefault = false) {
        return $this->objOutput->confirm ( $strQuestion, $booDefault );
    }
    
    /**
     * 提示用户输入
     *
     * @param string $strQuestion            
     * @param string $booDefault            
     * @return string
     */
    public function ask($strQuestion, $booDefault = null) {
        return $this->objOutput->ask ( $strQuestion, $booDefault );
    }
    
    /**
     * 输出一个表格文本
     *
     * @param array $arrHeaders            
     * @param array $arrRows            
     * @param string $strStyle            
     * @return void
     */
    public function table(array $arrHeaders, array $arrRows, $strStyle = 'default') {
        $objTable = new Table ( $this->objOutput );
        $objTable->setHeaders ( $arrHeaders )->setRows ( $arrRows )->setStyle ( $strStyle )->render ();
    }
    
    /**
     * 输出一个一般信息
     *
     * @param string $strMessage            
     * @param null|int|string $intVerbosity            
     * @return void
     */
    public function info($strMessage, $intVerbosity = null) {
        $this->line ( $strMessage, 'info', $intVerbosity );
    }
    
    /**
     * 返回一个带有时间的消息
     *
     * @param string $strMessage            
     * @param string $strFormat            
     * @return string
     */
    protected function time($strMessage, $strFormat = 'H:i:s') {
        return sprintf ( '[%s]', date ( $strFormat ) ) . $strMessage;
    }
    
    /**
     * 输出一个注释信息
     *
     * @param string $strMessage            
     * @param null|int|string $intVerbosity            
     * @return void
     */
    public function comment($strMessage, $intVerbosity = null) {
        $this->line ( $strMessage, 'comment', $intVerbosity );
    }
    
    /**
     * 输出一个问题信息
     *
     * @param string $strMessage            
     * @param null|int|string $intVerbosity            
     * @return void
     */
    public function question($strMessage, $intVerbosity = null) {
        $this->line ( $strMessage, 'question', $intVerbosity );
    }
    
    /**
     * 提示用户输入根据返回结果自动完成一些功能
     *
     * @param string $strQuestion            
     * @param array $arrChoices            
     * @param string $strDefault            
     * @return string
     */
    public function askWithCompletion($strQuestion, array $arrChoices, $strDefault = null) {
        $strQuestion = new Question ( $strQuestion, $strDefault );
        $strQuestion->setAutocompleterValues ( $arrChoices );
        return $this->objOutput->askQuestion ( $strQuestion );
    }
    
    /**
     * 提示用户输入但是控制台隐藏答案
     *
     * @param string $strQuestion            
     * @param bool $booFallback            
     * @return string
     */
    public function secret($strQuestion, $booFallback = true) {
        $strQuestion = new Question ( $strQuestion );
        $strQuestion->setHidden ( true )->setHiddenFallback ( $booFallback );
        return $this->objOutput->askQuestion ( $strQuestion );
    }
    
    /**
     * 给用户一个问题组选择
     *
     * @param string $strQuestion            
     * @param array $arrChoices            
     * @param string $strDefault            
     * @param mixed $mixAttempts            
     * @param bool $booMultiple            
     * @return string
     */
    public function choice($strQuestion, array $arrChoices, $strDefault = null, $mixAttempts = null, $booMultiple = null) {
        $strQuestion = new ChoiceQuestion ( $strQuestion, $arrChoices, $strDefault );
        $strQuestion->setMaxAttempts ( $mixAttempts )->setMultiselect ( $booMultiple );
        return $this->objOutput->askQuestion ( $strQuestion );
    }
    
    /**
     * 输出一个错误信息
     *
     * @param string $strMessage            
     * @param null|int|string $intVerbosity            
     * @return void
     */
    public function error($strMessage, $intVerbosity = null) {
        $this->line ( $strMessage, 'error', $intVerbosity );
    }
    
    /**
     * 输出一个警告信息
     *
     * @param string $strMessage            
     * @param null|int|string $intVerbosity            
     * @return void
     */
    public function warn($strMessage, $intVerbosity = null) {
        if (! $this->objOutput->getFormatter ()->hasStyle ( 'warning' )) {
            $this->objOutput->getFormatter ()->setStyle ( 'warning', new OutputFormatterStyle ( 'yellow' ) );
        }
        $this->line ( $strMessage, 'warning', $intVerbosity );
    }
    
    /**
     * 输出一条独立的信息
     *
     * @param string $strMessage            
     * @param string $strStyle            
     * @param null|int|string $intVerbosity            
     * @return void
     */
    public function line($strMessage, $strStyle = null, $intVerbosity = null) {
        $strMessage = $strStyle ? "<{$strStyle}>{$strMessage}</{$strStyle}>" : $strMessage;
        $this->objOutput->writeln ( $strMessage, $this->parseVerbosity_ ( $intVerbosity ) );
    }
    
    /**
     * 获取输入对象
     *
     * @return \Symfony\Component\Console\Output\OutputInterface
     */
    public function getOutput() {
        return $this->objOutput;
    }
    
    /**
     * 获取 QueryPHP 对象
     *
     * @return \queryyetsimple\mvc\project
     */
    public function getQueryPHP() {
        return $this->objQueryPHP;
    }
    
    /**
     * 设置 QueryPHP 对象
     *
     * @param \queryyetsimple\mvc\project $objQueryPHP            
     * @return void
     */
    public function setQueryPHP($objQueryPHP) {
        $this->objQueryPHP = $objQueryPHP;
    }
    
    /**
     * 命令参数
     *
     * @return array
     */
    protected function getArguments() {
        return [ ];
    }
    
    /**
     * 命令配置
     *
     * @return array
     */
    protected function getOptions() {
        return [ ];
    }
    
    /**
     * 设置默认输出级别
     *
     * @param string|int $mixLevel            
     * @return void
     */
    protected function setVerbosity($mixLevel) {
        $this->intVerbosity = $this->parseVerbosity_ ( $mixLevel );
    }
    
    /**
     * 从配置分析
     *
     * @return void
     */
    protected function fromSignature_() {
        list ( $strName, $arrArguments, $arrOptions ) = parser::parse ( $this->strSignature );
        parent::__construct ( $strName );
        foreach ( $arrArguments as $objArgument ) {
            $this->getDefinition ()->addArgument ( $objArgument );
        }
        foreach ( $arrOptions as $objOption ) {
            $this->getDefinition ()->addOption ( $objOption );
        }
    }
    
    /**
     * 定义参数和配置
     *
     * @return void
     */
    protected function specifyParameters_() {
        foreach ( $this->getArguments () as $objArguments ) {
            call_user_func_array ( [ 
                    $this,
                    'addArgument' 
            ], $objArguments );
        }
        
        foreach ( $this->getOptions () as $objOptions ) {
            call_user_func_array ( [ 
                    $this,
                    'addOption' 
            ], $objOptions );
        }
    }
    
    /**
     * 获取输入信息级别
     *
     * @param string|int $mixLevel            
     * @return int
     */
    protected function parseVerbosity_($mixLevel = null) {
        if (isset ( static::$arrVerbosityMap [$mixLevel] )) {
            $mixLevel = static::$arrVerbosityMap [$mixLevel];
        } elseif (! is_int ( $mixLevel )) {
            $mixLevel = $this->intVerbosity;
        }
        return $mixLevel;
    }
    
    /**
     * 返回命令名字
     *
     * @return string
     */
    protected function getName_() {
        return $this->strName;
    }
    
    /**
     * 返回命令描述
     *
     * @return string
     */
    protected function getDescription_() {
        return $this->strDescription;
    }
    
    /**
     * 返回命令帮助
     *
     * @return string
     */
    protected function getHelp_() {
        return $this->strHelp;
    }
}
