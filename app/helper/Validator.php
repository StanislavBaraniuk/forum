<?php
    /**
     * Created by PhpStorm.
     * User: stanislaw
     * Date: 3/29/19
     * Time: 23:25
     */

    class Validator
    {

        public static function email ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        public static function password ($password) {
            return preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/'
                , $password);
        }

    }