<?php

    class ErrorHandler
    {

        /**
         * @var $_handler ErrorHandlerObject
         */
        private static $_handler;

        public static function _init () {
            self::$_handler = ErrorHandlerObject::getInstance();
            self::$_handler->_uploadErrorList();
        }

        public static function createError (string $name, string $description = '', array $options = null, bool $readonly = false) {


            if (self::$_handler->_appErrors !== null && array_key_exists( $name , self::$_handler->_appErrors )) {
                return false;
            }


            self::$_handler->_appErrors[$name] = ['value' => $description, 'readonly' => $readonly, 'options' => $options];
            self::$_handler->_unloadErrorList();

            return true;
        }


        public static function setError (string $existingName, string $newDescription = null, array $options = null, bool $readonly = null) {

            if (!array_key_exists($existingName, self::$_handler->_appErrors)){
                if (!self::$_handler->_appErrors[$existingName]['readonly']) {
                    return false;
                }
                return null;
            }

            if ($newDescription !== null) {
                self::$_handler->_appErrors[$existingName]['value'] = $newDescription;
            }

            if ($options !== null) {
                self::$_handler->_appErrors[$existingName]['options'] = $options;
            }

            if ($readonly !== null) {
                self::$_handler->_appErrors[$existingName]['readonly'] = $readonly;
            }

            self::$_handler->_unloadErrorList();

            return self::$_handler->_appErrors[$existingName];
        }


        public static function getError (string $existingName) {

            if (self::$_handler->_appErrors === null || !array_key_exists($existingName, self::$_handler->_appErrors)){
                return null;
            }

            return self::$_handler->_appErrors[$existingName];
        }


        public static function getErrors () {

            return self::$_handler->_appErrors;
        }

        public static function removeError ($existingName) {

            if (!array_key_exists($existingName, self::$_handler->_appErrors)){
                return null;
            }

            unset(self::$_handler->_appErrors[$existingName]);

            self::$_handler->_unloadErrorList();

            return true;
        }

        public static function clearErrorList () {
            self::$_handler->_appErrors = null;
            self::$_handler->_unloadErrorList();

            return true;
        }

    }