<?php

require_once 'model/Model.php';

class Settings extends Model {

// CLASS ATTRIBUTS //    
    private
            $_id,
            $_slogan,
            $_event,
            $_pwd,
            $_type;

    // CLASS CONSTANTES //   
    const STOCK_SIZE = 100;
    const BACK_SIZE = 100;

    public function __construct() {
        $this->hydrate($this->getSetting(1));
    }

    // GETTERS //

    public function getId() {
        return $this->_id;
    }

    public function getSlogan() {
        return $this->_slogan;
    }

    public function getEvent() {
        return $this->_event;
    }

    public function getPwd() {
        return $this->_pwd;
    }

    public function getType() {
        return $this->_type;
    }

    // SETTERS //

    public function setId($id) {
        $this->_id = $id;
    }

    public function setSlogan($slogan) {
        $this->_slogan = $slogan;
    }

    public function setEvent($event) {
        $this->_event = $event;
    }

    public function setPwd($pwd) {
        $this->_pwd = $pwd;
    }

    public function setType($type) {
        $this->_type = $type;
    }

    // FUNCTIONS //


    public function getSetting($id) {
        $sql = 'SELECT * FROM settings where id=?';
        $setting = $this->executeRequest($sql, array($id));
        return $setting->fetch();
    }

    public function getSettings() {
        $sql = 'SELECT * FROM settings';
        $settings = $this->executeRequest($sql);
        return $settings->fetchall();
    }

    public function updateSettings($event, $slogan, $mdp, $id) {
        $this->_event = $event;
        $this->_slogan = $slogan;
        $this->_pwd = $mdp;
        $sql = 'update settings set event= ?, slogan= ?, mdp= ? where id=?';
        $this->executeRequest($sql, array($event, $slogan, $mdp, $id));
    }

    public function resetSettings() {
        $mdp = $this->_pwd = password_hash('admin', PASSWORD_DEFAULT);
        $slogan = $this->_slogan = 'Partagez vos photos sur ce spot tout au long de la soirée !';
        $event = $this->_event = "Saisissez ici le nom de l'événement !";
        $this->updateSettings($event, $slogan, $mdp, 1);
    }

    public function updatePassword($pwd, $id) {
        $pwdN = password_hash($pwd, PASSWORD_DEFAULT);
        $this->_pwd = $pwdN;
        $sql = 'update settings set pwd= ? where id=?';
        $this->executeRequest($sql, array($pwdN, $id));
    }

    public function updateEvent($event, $id) {
        $this->_event = $event;
        $sql = 'update settings set event= ? where id=?';
        $this->executeRequest($sql, array($event, $id));
    }

    public function updateSlogan($slogan, $id) {
        $this->_slogan = $slogan;
        $sql = 'update settings set slogan= ? where id=?';
        $this->executeRequest($sql, array($slogan, $id));
    }

    public function hydrate(array $settings) {
        foreach ($settings as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    function dirSize($dir) {
        $root = opendir($dir);
        $size = 0;
        while ($directory = readdir($root)) {
            if (!in_array($directory, array("..", "."))) {
                $size += filesize("$dir/$directory");
            }
        }
        closedir($root);
        return $size;
    }

}
