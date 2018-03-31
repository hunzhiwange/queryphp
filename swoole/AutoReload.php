<?php
class NotFound extends \Exception
{

}

class AutoReload
{
    /**
     * @var resource
     */
    protected $inotify;
    protected $pid;

    protected $reloadFileTypes = array('.php' => true);
    protected $watchFiles      = array();
    protected $afterNSeconds   = 1;

    /**
     * 正在reload
     */
    protected $reloading = false;

    protected $events;

    /**
     * 根目录
     * @var array
     */
    protected $rootDirs = array();

    public function putLog($log)
    {
        $_log = "[" . date('Y-m-d H:i:s') . "]\t" . $log . "\n";
        echo $_log;
        error_log($_log, 3, __DIR__."/log.log");
    }

    /**
     * @param $serverPid
     * @throws NotFound
     */
    public function __construct($serverPid)
    {
        $this->pid = $serverPid;
        //if (posix_kill($serverPid, SIGUSR1) === false) {
       //     throw new NotFound("Process#$serverPid not found.");
       /// }

        $this->inotify = inotify_init();
        $this->events  = IN_MODIFY | IN_DELETE | IN_CREATE | IN_MOVE;

        swoole_event_add($this->inotify, function ($ifd) {
            $events = inotify_read($this->inotify);
            if (!$events) {
                return;
            }
            // var_dump($events);
            foreach ($events as $ev) {
                if ($ev['mask'] == IN_IGNORED) {
                    continue;
                } else if ($ev['mask'] == IN_CREATE or $ev['mask'] == IN_DELETE or $ev['mask'] == IN_MODIFY or $ev['mask'] == IN_MOVED_TO or $ev['mask'] == IN_MOVED_FROM) {
                    $fileType = strrchr($ev['name'], '.');
                    //非重启类型
                    if (!isset($this->reloadFileTypes[$fileType])) {
                        continue;
                    }
                }
                //正在reload，不再接受任何事件，冻结1秒
                if (!$this->reloading) {
                    $this->putLog("after 1 seconds reload the server");
                    //有事件发生了，进行重启
                    swoole_timer_after($this->afterNSeconds * 1000, array($this, 'reload'));
                    $this->reloading = true;
                }
            }
        });
    }

    public function reload()
    {
        $this->putLog("reloading");
        //向主进程发送信号
        posix_kill($this->pid, SIGUSR1);
        //清理所有监听
        $this->clearWatch();
        //重新监听
        foreach ($this->rootDirs as $root) {
            $this->watch($root);
        }
        //继续进行reload
        $this->reloading = false;
    }

    /**
     * 添加文件类型
     * @param $type
     */
    public function addFileType($type)
    {
        $type                               = trim($type, '.');
        $this->reloadFileTypes['.' . $type] = true;
    }

    /**
     * 添加事件
     * @param $inotifyEvent
     */
    public function addEvent($inotifyEvent)
    {
        $this->events |= $inotifyEvent;
    }

    /**
     * 清理所有inotify监听
     */
    public function clearWatch()
    {
        foreach ($this->watchFiles as $wd) {
            inotify_rm_watch($this->inotify, $wd);
        }
        $this->watchFiles = array();
    }

    /**
     * @param $dir
     * @param bool $root
     * @return bool
     * @throws NotFound
     */
    public function watch($dir, $root = true)
    {
        //目录不存在
        if (!is_dir($dir)) {
            throw new NotFound("[$dir] is not a directory.");
        }
        //避免重复监听
        if (isset($this->watchFiles[$dir])) {
            return false;
        }
        //根目录
        if ($root) {
            $this->rootDirs[] = $dir;
        }

        $wd                     = inotify_add_watch($this->inotify, $dir, $this->events);
        $this->watchFiles[$dir] = $wd;

        $files = scandir($dir);
        foreach ($files as $f) {
            if ($f == '.' or $f == '..') {
                continue;
            }
            $path = $dir . '/' . $f;
            //递归目录
            if (is_dir($path)) {
                $this->watch($path, false);
            }
            //检测文件类型
            $fileType = strrchr($f, '.');
            if (isset($this->reloadFileTypes[$fileType])) {
                $wd                      = inotify_add_watch($this->inotify, $path, $this->events);
                $this->watchFiles[$path] = $wd;
            }
        }
        return true;
    }

    public function run()
    {
        swoole_event_wait();
    }
}