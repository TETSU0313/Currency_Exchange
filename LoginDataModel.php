<?php

define('FXUSERS_INI_FILE', 'fxUsers.ini');
define('LOGIN_INI_FILE', 'login.ini');

class LoginDataModel {

    //Class constants
    const USERNAME = 'username';
    const PASSWORD = 'password';

    //
    private $iniNameArray;
    private $iniLoginArray;

    function __construct() {
        $this->iniNameArray = parse_ini_file(FXUSERS_INI_FILE);
        $this->iniLoginArray = parse_ini_file(LOGIN_INI_FILE);
    }

    public function getIniLoginArray() {
        return $this->iniLoginArray;
    }

    public function getIniNameArray() {
        return $this->iniNameArray;
    }

    public function validateUsers($username, $password) {

        if (array_key_exists($username, $this->iniNameArray)) {
            if ($this->iniNameArray[$username] == $password) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
