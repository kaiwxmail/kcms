<?php 
namespace app\fun;

use app;

class Functions extends app\Engine {

    //设置USER链接
    public function getRedis($name = 'user') {
        if (!isset(self::$dbsInstances[$name])) {
            $config = $this->get('web.config');
            $usertime = $config['usertime'];
            $config = array (
                'host' => $config[$name.'.host'],  //服务器连接地址。默认='127.0.0.1'
                'port' => $config[$name.'.port'],  //端口号。默认='6379'
                'expire' => $config['usertime'],  // 默认全局过期时间，单位秒。不填默认3600
                'password' => $config[$name.'.auth'],  // 连接密码，如果有设置密码的话
                'db' => $config[$name.'.db'],   //缓存库选择。默认0
                'ttl' => $config[$name.'.ttl']  // 连接超时时间（秒）。默认10
            );
            $this->loader->register('getUSERRedis', '\app\dbs\Redisdb', array ($config));
            try {
                $dbs = $this->getUSERRedis();
                if (!$dbs) {
                    throw new \Exception();
                }
                if(!empty($_COOKIE['UPSS'])) { 
                    $dbs->expire(md5($_COOKIE['UPSS']),$usertime); 
                } 
                self::$dbsInstances[$name] = $dbs;
            } catch (\Exception $e) {
                die(json_encode(array('code'=>500, 'msg'=>'Redis数据库连接失败', 'data'=>''), JSON_UNESCAPED_UNICODE));
            }
        }
        return self::$dbsInstances[$name];
    }

    //设置SESSION链接
    public function getSESS($name = 'sess') {
        if (!isset(self::$dbInstances[$name])) {
            $config = $this->get('web.config');
            $this->loader->register('getSESSRedis', '\app\dbs\SessionReids',array (
                $config[$name.'.host'],  // 服务器连接地址。默认='127.0.0.1'
                $config[$name.'.port'],  // 端口号。默认='6379'
                $config[$name.'.auth'],  // 连接密码，如果有设置密码的话
                $config[$name.'.db'],    // 缓存库选择。默认0
                $config[$name.'.ttl'],   // 连接超时时间（秒）。默认10
                $config['usertime'],     // 默认用户登录过期时间，单位秒。不填默认3600
                $config['timeout'],      // 默认用户未登录过期时间，单位秒。不填默认3600
                $config[$name.'.name'],  // SESSION name
                $config[$name.'.domain'] // 作用域
            ));
            try {
                $dbs = $this->getSESSRedis();
                if (!$dbs) {
                    throw new \Exception();
                }
                self::$dbInstances[$name] = $dbs;
            } catch (\Exception $e) {
                die(json_encode(array('code'=>500, 'msg'=>'Redis数据库连接失败', 'data'=>''), JSON_UNESCAPED_UNICODE));
            }
        }
        return self::$dbInstances[$name];
    }
}
