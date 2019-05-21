<?php
return [
    'language'=>'zh-CN',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.94.131;dbname=yuan_dian',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'tablePrefix'=>'yy_',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
