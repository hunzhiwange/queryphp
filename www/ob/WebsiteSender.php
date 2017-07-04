<?php

class WebsiteSender implements SplObserver {

    public function update(SplSubject $subject) {
        if (func_num_args() === 2) {
            $userInfo = func_get_arg(1);

            echo "这是1封站内小纸条。你好{$userInfo['username']}，你的新密码是{$userInfo['password']}，" .
            "请妥善保管", PHP_EOL;
        }
    }

}
