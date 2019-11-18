<?php
/**
 * 修改 php.ini
 * session.save_handler = Redis
 * session.save_path = "tcp://host:6379?auth=123456,tcp://host:6379?auth=123456"
 */
return array(
# ======> 公共配置
    # SESSION 数据用户未登录过期时间 秒
    'timeout' => '60',
    # SESSION 数据用户登陆后过期时间 秒
    'usertime' => '86400',
# ======> Mysql数据库配置
    # 数据库主机地址
    'db.host' => '127.0.0.1',
    # 数据库端口
    'db.port' => '3306',
    # 数据库用户名
    'db.user' => 'root',
    # 数据库密码
    'db.pass' => 'root',
    # 数据库名称
    'db.name' => 'root',
    # 数据库表前缀
    'db.prefix'=>'info_',
    # 数据库编码，默认utf8
    'db.charset' => 'utf8',
# ======> 保存 会员ID 到 Redis
    # Redis主机地址
    'user.host' => '127.0.0.1',
    # Redis端口，默认6379
    'user.port' => '6379',
    # Redis数据库号，范围1~16，默认无需修改，0默认预留给杂项使用
    'user.db' => '0',
    # Redis密码
    'user.auth' => '123456',
    # Redis链接时间 秒
    'user.ttl' => '10',
# ======> 保存 SESSION 到 Redis
    # Redis 主机地址
    'sess.host' => '127.0.0.1',
    # Redis端口，默认6379
    'sess.port' => '6379',
    # Redis数据库号，范围1~16，默认无需修改，0默认预留给杂项使用
    'sess.db' => '0',
    # Redis密码
    'sess.auth' => '123456',
    # Redis链接时间 秒
    'sess.ttl' => '10',
    # SESSION名称 #默认：PHPSESSID
    'sess.name' => 'UAID',
    # SESSION作用域
    'sess.domain' => '.a.com',
# ======> RSA 公钥, 私钥
    # RSA 私钥
    'private' => '
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCOUbwsEsOjCprr2hGDrk792e9QKs7b5w/AYMKrvUGoD9fSDvNj
TZjAyRYM69FsXGLS5XIu5ok7Zdv7y+mcEBD7nQVLLnA9j13KGZz95lWb7lFaZH1x
D8baF/34jqrDDGRlfp2yyKgPdy79/dCa2b3qTDBX9FeH5CwjdsAw7X50jwIDAQAB
AoGAA8glPXCUNUlrW3gUfhDMNY+sfc9dZteJgh2wHpstWvdszz6pdgqSVBEj3l0H
2B7OW3dQZPGoVOU8hsDg6M4+fT6347oPAtl8Jwo+fEzEHX1Irii77BV0GHAMwkLT
EK32gAYqr4itUb0Bcug6WQaiWF3ezxtgJEQaU8CETUM7/yUCQQCVV+DieUf5s+g+
4Pq0/R+3/8s+P8Qp+JTmPY2qio/LnmqGFG/h5JGd2jtmAspFFhu3KfkqT8ueYTPz
3E9tiitbAkEA8/WsdEf4Oy9atBHalXcGCgv2k4Xz1+NOp4sCzZY9ifPrcBbwhzxD
qaz5B8fAHo9nppDGGlQ6XMjTT26uVq7F3QJBAIKoTLa3NvJOpP0GJjFcV3jKUQ2Y
Ck5SDitVZPD0oxOY+Edv7+ao64E4IcmA3WgODJd2IGkVQObC0gojEFackIsCQEaG
pT5QeACUJgKcjrZa3FIXN0damC23NsvUshDA+DVjYJLc7tgJof3xVWTcaDvtdSd/
/uUpqF2eaQgzlQ7WI7kCQATA75pCAYhBdZYM8v2hPa+lmNZguDAXilXXBSYNc6+G
zKpWb1XmEVTRakgOBJ+hpzDom6k6ypQ6MlQvAt3Os4c=
-----END RSA PRIVATE KEY-----
',
    # RSA 公钥
    'public' => '
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCOUbwsEsOjCprr2hGDrk792e9Q
Ks7b5w/AYMKrvUGoD9fSDvNjTZjAyRYM69FsXGLS5XIu5ok7Zdv7y+mcEBD7nQVL
LnA9j13KGZz95lWb7lFaZH1xD8baF/34jqrDDGRlfp2yyKgPdy79/dCa2b3qTDBX
9FeH5CwjdsAw7X50jwIDAQAB
-----END PUBLIC KEY-----
',

);
