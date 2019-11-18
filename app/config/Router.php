<?php 
// 路由映射表
return array(
    array('GET /((@cid:[0-9]+/)@page:[0-9]+)', 'frontend\Index:index'),
    array('GET /admin', 'backend\Index:index'),
    array('GET /admin/logout', 'backend\Base:Logout'),
    array('POST /admin/upload', 'backend\Base:Upload'),
    array('GET|POST /admin/lock', 'backend\User:lock'),
    array('GET|POST /admin/login', 'backend\User:login'),
    array('GET|POST /admin/article/clubs', 'backend\Article:clubs'),
    array('GET|POST /admin/article/edit', 'backend\Article:edit'),
    array('GET|POST /admin/article/add', 'backend\Article:add'),
);
