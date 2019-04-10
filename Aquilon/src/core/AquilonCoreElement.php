<?php
    /**
     * Created by PhpStorm.
     * User: stanislaw
     * Date: 3/29/19
     * Time: 15:53
     */

    class AquilonCoreElement
    {
        public static function getModel ($className) {

            if (class_exists($className)) {
                $className = str_replace("Controller", "", $className);
            }

            $model = $className."Model";
            return new $model();
        }

        public static function redirect ($path) {
            header('Location: '.$path);
        }

        public static function _GET ($key) {
            return isset($_GET[$key]) ? $_GET[$key] : null;
        }

        public static function _POST ($key) {
            return isset($_POST[$key]) ? $_POST[$key] : null;
        }

        public static function _SESSION ($key) {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        }

        public static function getByKey ($array, $key) {
            return isset($array[$key]) ? $array[$key] : null;
        }
    }