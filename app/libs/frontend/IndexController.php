<?php
namespace frontend;

use Api;

class IndexController {

    /**
     * 首页
     * @param  [type] $cid  [description]
     * @param  [type] $page [description]
     * @return [type]       [description]
     */
    public static function index() {

        $password = 'baidu';
        $_SESSION['user'] = '1';
        Api::fun()->getRedis()->set('USER:'.md5($password), session_id());
        Api::render('index', array('title' => '测试接口'));
    }

}
