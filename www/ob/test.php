<?php

header('Content-Type: text/plain');

function __autoload($class_name) {
    require_once "$class_name.php";
}

$email_sender = new EmailSender();
$mobile_sender = new MobileSender();
$web_sender = new WebsiteSender();

$user = new User('user1@domain.com', '张三', '13610002000', '123456');

// 创建用户时通过Email和手机短信通知用户
$user->attach($email_sender);
$user->attach($mobile_sender);
$user->create($user);
echo PHP_EOL;

// 用户忘记密码后重置密码，还需要通过站内小纸条通知用户
$user->attach($web_sender);
$user->resetPassword();
echo PHP_EOL;

// 用户变更了密码，但是不要给他的手机发短信
$user->detach($mobile_sender);
$user->changePassword('654321');
echo PHP_EOL;
