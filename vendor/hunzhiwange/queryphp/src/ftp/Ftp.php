<?php
/**
 * FTP 操作
 * 小牛New 添加
 * @date 2015/10/27
 */
class Ftp {

    private $hostname = '';
    private $username = '';
    private $password = '';
    private $port = 21;
    private $passive = true;
    private $conn_id = false;
    private $error = '';

    /**
     * 构造函数
     *
     * @param	array	配置数组 : $config = array('hostname'=>'','username'=>'','password'=>'','port'=>''...);
     */
    public function __construct($config = array()) {
        if (count($config) > 0) {
            $this->_init($config);
        }
    }

    /**
     * FTP连接
     *
     * @access 	public
     * @param 	array 	配置数组
     * @return	boolean
     */
    public function connect($config = array(), $booIsInit = false) {
        if($booIsInit === false){
            if(is_string($config)) {
                $config = $this->parseDSN($config);
            }
            if (count($config) > 0) {
                $this->_init($config);
            }
        }

        if (false === ($this->conn_id = ftp_connect($this->hostname, $this->port))) {
            $this->setError("ftp_unable_to_connect");
            return false;
        }

        if (!$this->_login()) {
            $this->setError("ftp_unable_to_login");
            return false;
        }

        if ($this->passive === true) {
            ftp_pasv($this->conn_id, true);
        }

        return true;
    }

    /**
     * 目录改变
     *
     * @access 	public
     * @param 	string 	目录标识(ftp)
     * @param	boolean	
     * @return	boolean
     */
    public function chgdir($path = '') {
        if ($path == '' OR !$this->_isconn()) {
            return false;
        }

        $result = ftp_chdir($this->conn_id, $path);

        if ($result === false) {
            $this->setError("ftp_unable_to_chgdir:dir[" . $path . "]");
            return false;
        }

        return true;
    }

    /**
     * 目录生成
     *
     * @access 	public
     * @param 	string 	目录标识(ftp)
     * @param	int  	文件权限列表	
     * @return	boolean
     */
    public function mkdir($path = '', $permissions = NULL) {
        if ($path == '' OR !$this->_isconn()) {
            return false;
        }
        
        $path_arr  = explode('/',$path);              // 取目录数组  
        if(count($path_arr)>5) {
        	// 记录FTP创建目录日志
        	error_log(date('H:i:s') . ' Login : company_id = ' . $_SESSION['cInfo']['company_id'].',accounts_id = ' . $_SESSION['aInfo']['accounts_id'] . "\r\n\r\n",3,RUNTIME_PATH . 'Sql/ftp_' . date('y_m_d') . '.log');
        	error_log(date('H:i:s') . ' log : ' . $path. "\r\n\r\n",3,RUNTIME_PATH . 'Sql/ftp_' . date('y_m_d') . '.log');
        	return;
        }
        
        foreach ($path_arr as $val) { // 创建目录 
            if (!empty($val)) {
                if (ftp_chdir($this->conn_id, $val) == false) {
                    ftp_mkdir($this->conn_id, $val);
                    if(ftp_chdir($this->conn_id, $val)) {
                        if (!is_null($permissions)) {
                            $this->chmod(ftp_pwd($this->conn_id), (int) $permissions);
                        }
                    }  
                }
            }
        }
        ftp_chdir($this->conn_id, '/');
        return true;
    }

    /**
     * 上传
     *
     * @access 	public
     * @param 	string 	本地目录标识
     * @param	string	远程目录标识(ftp)
     * @param	string	上传模式 auto || ascii
     * @param	int		上传后的文件权限列表	
     * @return	boolean
     */
    public function upload($localpath, $remotepath, $mode = 'auto', $permissions = NULL) {
        if (!file_exists($localpath)) {
            $this->setError("ftp_no_source_file:" . $localpath);
            return false;
        }

        if ($mode == 'auto') {
            $ext = $this->_getext($localpath);
            $mode = $this->_settype($ext);
        }

        $mode = ($mode == 'ascii') ? FTP_ASCII : FTP_BINARY;
        $this->mkdir(dirname($remotepath), $permissions);
   
        // 重新连接上传
        $this->__destruct();
        $this->connect(array(), true);
        $remotepath = ltrim($remotepath,'/');
        $result = ftp_put($this->conn_id, $remotepath, $localpath, $mode);

        if ($result === false) {
            $this->setError("ftp_unable_to_upload:localpath[" . $localpath . "]/remotepath[" . $remotepath . "]");
            return false;
        }

        if (!is_null($permissions)) {
            $this->chmod($remotepath, (int) $permissions);
        }

        return true;
    }

    /**
     * 下载
     *
     * @access 	public
     * @param 	string 	远程目录标识(ftp)
     * @param	string	本地目录标识
     * @param	string	下载模式 auto || ascii	
     * @return	boolean
     */
    public function download($remotepath, $localpath, $mode = 'auto') {
        if (!$this->_isconn()) {
            return false;
        }

        if ($mode == 'auto') {
            $ext = $this->_getext($remotepath);
            $mode = $this->_settype($ext);
        }

        $mode = ($mode == 'ascii') ? FTP_ASCII : FTP_BINARY;
        // 修复ftp文件下载失败的BUG by 小牛 @ 2016.08.25
        $remotepath = ltrim($remotepath,'/');
        $result = ftp_get($this->conn_id, $localpath, $remotepath, $mode);

        if ($result === false) {
            $this->setError("ftp_unable_to_download:localpath[" . $localpath . "]-remotepath[" . $remotepath . "]");
            return false;
        }

        return true;
    }

    /**
     * 重命名/移动
     *
     * @access 	public
     * @param 	string 	远程目录标识(ftp)
     * @param	string	新目录标识
     * @param	boolean	判断是重命名(false)还是移动(true)	
     * @return	boolean
     */
    public function rename($oldname, $newname, $move = false) {
        if (!$this->_isconn()) {
            return false;
        }

        $result = ftp_rename($this->conn_id, $oldname, $newname);

        if ($result === false) {
            $msg = ($move == false) ? "ftp_unable_to_rename" : "ftp_unable_to_move";
            $this->setError($msg);
            return false;
        }

        return true;
    }

    /**
     * 删除文件
     *
     * @access 	public
     * @param 	string 	文件标识(ftp)
     * @return	boolean
     */
    public function delete_file($file) {
        if (!$this->_isconn()) {
            return false;
        }

        $result = ftp_delete($this->conn_id, $file);

        if ($result === false) {
            $this->setError("ftp_unable_to_delete_file:file[" . $file . "]");
            return false;
        }

        return true;
    }

    /**
     * 删除文件夹
     *
     * @access 	public
     * @param 	string 	目录标识(ftp)
     * @return	boolean
     */
    public function delete_dir($path) {
        if (!$this->_isconn()) {
            return false;
        }

        //对目录宏的'/'字符添加反斜杠'\'
        $path = preg_replace("/(.+?)\/*$/", "\\1/", $path);

        //获取目录文件列表
        $filelist = $this->filelist($path);

        if ($filelist !== false AND count($filelist) > 0) {
            foreach ($filelist as $item) {
                //如果我们无法删除,那么就可能是一个文件夹
                //所以我们递归调用delete_dir()
                if (!$this->delete_file($item)) {
                    $this->delete_dir($item);
                }
            }
        }

        //删除文件夹(空文件夹)
        $result = ftp_rmdir($this->conn_id, $path);

        if ($result === false) {
            $this->setError("ftp_unable_to_delete_dir:dir[" . $path . "]");
            return false;
        }

        return true;
    }

    /**
     * 修改文件权限
     *
     * @access 	public
     * @param 	string 	目录标识(ftp)
     * @return	boolean
     */
    public function chmod($path, $perm) {
        if (!$this->_isconn()) {
            return false;
        }

        //只有在PHP5中才定义了修改权限的函数(ftp)
        if (!function_exists('ftp_chmod')) {
            $this->setError("ftp_unable_to_chmod(function)");
            return false;
        }

        $result = ftp_chmod($this->conn_id, $perm, $path);

        if ($result === false) {
            $this->setError("ftp_unable_to_chmod:path[" . $path . "]-chmod[" . $perm . "]");
            return false;
        }
        return true;
    }

    /**
     * 获取目录文件列表
     *
     * @access 	public
     * @param 	string 	目录标识(ftp)
     * @return	array
     */
    public function filelist($path = '.') {
        if (!$this->_isconn()) {
            return false;
        }

        return ftp_nlist($this->conn_id, $path);
    }
    
    /**
     * 判断remote file是否存在
     * @param type $file
     * @return boolean
     */
    public function fileexists($file) {
        // 修复ftp文件下载失败的BUG by 小牛 @ 2016.08.25
        $file = ltrim($file,'/');
        $info = ftp_size($this->conn_id, $file);
        return $info!==-1;
    }

    /**
     * 关闭FTP
     *
     * @access 	public
     * @return	boolean
     */
    public function close() {
        if (!$this->_isconn()) {
            return false;
        }

        return ftp_close($this->conn_id);
    }

    /**
     * FTP成员变量初始化
     *
     * @access	private
     * @param	array	配置数组	 
     * @return	void
     */
    private function _init($config = array()) {
        foreach ($config as $key => $val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }

        //特殊字符过滤
        $this->hostname = preg_replace('|.+?://|', '', $this->hostname);
    }

    /**
     * FTP登陆
     *
     * @access 	private
     * @return	boolean
     */
    private function _login() {
        return ftp_login($this->conn_id, $this->username, $this->password);
    }

    /**
     * 判断con_id
     *
     * @access 	private
     * @return	boolean
     */
    private function _isconn() {
        if (!is_resource($this->conn_id)) {
            $this->setError("ftp_no_connection");
            return false;
        }
        return true;
    }

    /**
     * 从文件名中获取后缀扩展
     *
     * @access 	private
     * @param 	string 	目录标识
     * @return	string
     */
    private function _getext($filename) {
        if (false === strpos($filename, '.')) {
            return 'txt';
        }

        $extarr = explode('.', $filename);
        return end($extarr);
    }

    /**
     * 从后缀扩展定义FTP传输模式  ascii 或 binary
     *
     * @access 	private
     * @param 	string 	后缀扩展
     * @return	string
     */
    private function _settype($ext) {
        $text_type = array(
            'txt',
            'text',
            'php',
            'phps',
            'php4',
            'js',
            'css',
            'htm',
            'html',
            'phtml',
            'shtml',
            'log',
            'xml'
        );

        return (in_array($ext, $text_type)) ? 'ascii' : 'binary';
    }

    /**
     * 错误
     *
     * @access 	prvate
     * @return	boolean
     */
    public function setError($msg) {
        $this->error = $msg;
    }
    
    public function getError() {
        return $this->error;
    }
    
    /**
     * DSN解析
     * 格式： mysql://username:passwd@localhost:3306/DbName
     * 
     * @param type $dsnStr
     * @return boolean|string
     */
    public function parseDSN($dsnStr) {
        if (empty($dsnStr)) {
            return false;
        }
        $info = parse_url($dsnStr);
        if ($info['scheme']) {
            $dsn = array(
                'username' => isset($info['user']) ? $info['user'] : '',
                'password' => isset($info['pass']) ? $info['pass'] : '',
                'hostname' => isset($info['host']) ? $info['host'] : '',
                'port' => isset($info['port']) ? $info['port'] : '',
                'path' => isset($info['path']) ? substr($info['path'], 1) : ''
            );
        } else {
            preg_match('/^(.*?)\:\/\/(.*?)\:(.*?)\@(.*?)\:([0-9]{1, 6})\/(.*?)$/', trim($dsnStr), $matches);
            $dsn = array(
                'username' => $matches[2],
                'password' => $matches[3],
                'hostname' => $matches[4],
                'port' => $matches[5],
                'path' => $matches[6]
            );
        }
        return $dsn;
    }
    
    
    public function __destruct() {
        @ftp_close($this->conn_id);
    }

}
