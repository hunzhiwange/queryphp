<?php

class User implements SplSubject {

    private $email;
    private $username;
    private $mobile;
    private $password;
    /**
     * @var SplObjectStorage
     */
    private $observers = NULL;

    public function __construct($email, $username, $mobile, $password) {
        $this->email = $email;
        $this->username = $username;
        $this->mobile = $mobile;
        $this->password = $password;

        $this->observers = new SplObjectStorage();
    }

    public function attach(SplObserver $observer) {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer) {
        $this->observers->detach($observer);
    }

    public function notify() {
        $userInfo = array(
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
            'mobile' => $this->mobile,
        );
        foreach ($this->observers as $observer) {
            $observer->update($this, $userInfo);
        }
    }

    public function create() {
        echo __METHOD__, PHP_EOL;
        $this->notify();
    }

    public function changePassword($newPassword) {
        echo __METHOD__, PHP_EOL;
        $this->password = $newPassword;
        $this->notify();
    }

    public function resetPassword() {
        echo __METHOD__, PHP_EOL;
        $this->password = mt_rand(100000, 999999);
        $this->notify();
    }

}