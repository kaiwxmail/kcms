<?php
namespace app\dbs;

class SessionReids {

    /**
     * redis连接句柄
     * @var Redis $redis
     */
    private $redis;

    /**
     * Time out
     *
     * @var string
     */
    private $timeout;

    /**
     * Time user
     *
     * @var string
     */
    private $usertime;

    /**
     * Table prefix
     *
     * @var string
     */
    private $prefix;

    public function __construct($host = '127.0.0.1', $port = '6379', $auth = null, $db = '0', $ttl = '10', $usertime = '3600', $timeout = '3600', $sename = null, $sedomain = null, $prefix = 'SSCC:') {
        if(!class_exists("redis", false)) {
            die("必须安装redis扩展");
        }
        $this->redis = new \Redis();
        $this->redis->connect($host, $port, $ttl) or die('Redis 连接失败！');
        $this->redis->auth($auth);
        $this->redis->select($db);
        $this->usertime = $usertime;
        $this->timeout = $timeout;
        $this->prefix = $prefix;
        session_set_save_handler(
            array($this, "open"),
            array($this, "close"),
            array($this, "read"),
            array($this, "write"),
            array($this, "destroy"),
            array($this, "gc")
        );

        // 下面这行代码可以防止使用对象作为会话保存管理器时可能引发的非预期行为
        register_shutdown_function('session_write_close');

        session_set_cookie_params($usertime, "/", $sedomain, FALSE, TRUE);
        session_name($sename);
        session_start();
    }

    /**
     * 打开Session
     * @access public
     * @param string $Path
     * @param mixed  $Name
     * @return bool
     */
    public function open($Path, $Name) {
        return true;
    }

    /**
     * 关闭session
     * @return bool
     */
    public function close() {
        return true;
    }

    /**
     * 读取session
     * @param $id
     * @return bool|string
     */
    public function read($id) {
        $value = $this->redis->get($this->prefix.$id);
        if($value){
            return $value;
        }else{
            return '';
        }
    }

    /**
     * 设置session
     * @param $id
     * @param $data
     * @return bool
     */
    public function write($id, $data) {
        if($this->redis->set($this->prefix.$id, $data)) {
            if(substr_count($this->redis->get($this->prefix.$id),'user|')) {
                $this->redis->expire($this->prefix.$id, $this->usertime); 
            } else {
                $this->redis->expire($this->prefix.$id, $this->timeout); 
            }
            return true;
        }
        return false;
    }

    /**
     * 销毁session
     * @param $id
     * @return bool
     */
    public function destroy($id) {
        if($this->redis->delete($this->prefix.$id)) {
            return true;
        }
        return false;
    }

    /**
     * gc回收
     * @param $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime) {
        return true;
    }

    /**
     * 结束当前会话并存储会话数据
     * @return bool
     */
    public function __destruct() {
        session_write_close();
    }

}
