<?php
    /**
     * Created by PhpStorm.
     * User: stanislaw
     * Date: 3/30/19
     * Time: 14:56
     */

    class UserObject
    {

        public $_id = null;
        public $_login = null;
        public $_token = null;
        public $_start = null;
        public $_expiration = null;

        const EXPIRATION_TIME = 15;

        public function __construct ()
        {
            $this->_start = ( new DateTime('now', new DateTimeZone('GMT')) )
                ->format('Y-m-d H:i');

            $this->_expiration =  date("Y-m-d H:i", strtotime("+" . self::EXPIRATION_TIME . " minutes", strtotime($this->_start)));

            return $this;
        }

        public function setId ($id) {

            $this->_id = $id;
            return $this;
        }

        public function setLogin ($login) {

            $this->_login = $login;
            return $this;
        }

        public function setToken ($token) {

            $this->_token = $token;
            return $this;
        }

        public function setStart ($sessionStartDateTime) {

            $this->_start = $sessionStartDateTime;
            return $this;
        }

        public function setExpirationDatetime ($sessionEndTime) {

            $this->_expiration = $sessionEndTime;
            return $this;
        }

        public function setExpiration ($sessionLifeTime) {

            $this->_expiration = strtotime("+" . $sessionLifeTime . " minutes", strtotime($this->_start));
            return $this;
        }

        public function getId () {

            return $this->_id;
        }

        public function getLogin () {

            return $this->_login;
        }

        public function getToken () {

            return $this->_token;
        }

        public function getStart () {

            return $this->_start;
        }

        public function getExpiration () {

            return $this->_expiration;
        }


    }