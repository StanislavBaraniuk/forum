<?php
    /**
     * Created by PhpStorm.
     * User: stanislaw
     * Date: 3/29/19
     * Time: 18:03
     */

    class ErrorHandlerObject
    {
        public $_appErrors = array();

        private static $instance;

        public static function getInstance(): ErrorHandlerObject
        {
            if (null === static::$instance) {
                static::$instance = new static();
            }

            return static::$instance;
        }


        private function __construct()
        {
        }


        public function _uploadErrorList () {
            if (isset($_COOKIE['AquilonErrorHandler'])) {
                $this::$instance->_appErrors = unserialize($_COOKIE['AquilonErrorHandler'], ["allowed_classes" => false]);
            }
        }


        public function _unloadErrorList ()
        {
            setcookie('AquilonErrorHandler', serialize($this::$instance->_appErrors), 0, '/');
        }


    }