<?php
namespace Native5\Core\Database;

class DBConfig {
    private $_name;
    private $_type;
    private $_host;
    private $_port;
    private $_user;
    private $_password;

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getType() {
        return $this->_type;
    }

    public function setType($type) {
        $this->_type = $type;
    }

    public function getHost() {
        return $this->_host;
    }

    public function setHost($host) {
        $this->_host = $host;
    }

    public function getPort() {
        return $this->_port;
    }

    public function setPort($port) {
        $this->_port = $port;
    }

    public function getUser() {
        return $this->_user;
    }

    public function setUser($user) {
        $this->_user = $user;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setPassword($password) {
        $this->_password = $password;
    }

}

