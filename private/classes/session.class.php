<?php

class Session {
    private $admin_id;
    public $username;
    private $last_login;

    public const MAX_LOGIN_AGE = 60*60*24;

    public function __construct() {
        session_start();
        $this->check_stored_login();
    }
    public function login($admin) {
        if($admin) {

            session_regenerate_id();
            $this->admin_id = $_SESSION['admin_id'] = $admin->id;
            $this->username = $_SESSION['username'] =  $admin->username;
            $this->last_login = $_SESSION['last_login'] = time();
        }

    }

    public function is_logged_in() {
        return isset($this->admin_id) && $this->last_login_is_recent();
    }

    public function log_out() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['username']);
        unset($_SESSION['last_login']);
        unset($this->admin_id);
        unset($this->username);
        unset($this->last_login);
        return true;
    }

    private function check_stored_login() {
        if(isset($_SESSION['admin_id'])) {
            $this->admin_id = $_SESSION['admin_id'];
            $this->username = $_SESSION['username'];
            $this->last_login = $_SESSION['last_login'];
        }
    }

    private function last_login_is_recent() {
        if(!isset($this->last_login)) {
            return false;
        } elseif($this->last_login + self::MAX_LOGIN_AGE < time()) {
            return false;
        } else {
            return true;
        }
    }
}