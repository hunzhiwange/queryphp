<?php

class EmailSender implements SplObserver {

    public function update(SplSubject $subject) {
        if (func_num_args() === 2) {
            $userInfo = func_get_arg(1);
            
            echo "向{$userInfo['email']}发送电子邮件成功。内容是：你好{$userInfo['username']}" .
            "你的新密码是{$userInfo['password']}，请妥善保管", PHP_EOL;
        }
    }

}