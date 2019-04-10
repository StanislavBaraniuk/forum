<?php
    /**
     * Created by PhpStorm.
     * User: stanislaw
     * Date: 4/2/19
     * Time: 10:30
     */

    class ComponentObject extends AquilonCoreElement
    {

        private $_id;
        private $_path;

        private $_stack = array();

        public function __construct ($id, $path)
        {
            $this->_id = $id;
            $this->_path = $path;

            return $this;
        }

        public function _path ($value = null) {
            if ($value !== null) {
                $this->_path = $value;
            } else {
                return $this->_path;
            }

            return false;
        }

        public function _id ($value = null) {
            if ($value !== null) {
                $this->_id = $value;
            } else {
                return $this->_id;
            }

            return false;
        }

        public function _toHtml () {
            include $this->_path;
            return $this;
        }

        public function __call ( $name , $arguments )
        {

            $type = strtolower(substr($name, 0, 3));
            $id = strtolower(explode($type, $name)[1]);

            switch ($type) {
                case 'set' :

                    return $this->setToStack($id, $arguments);
                    break;
                case 'get' :

                    return $this->getFromStack($id);
                    break;
            }

            trigger_error("Method undefined");
        }

        private function setToStack ($id, $arguments) {
            $this->_stack[$id] = $arguments[0];

            return $this;
        }

        private function getFromStack ($id) {

            $id = strtolower($id);

            if (isset($this->_stack[$id])) {
                return $this->_stack[$id];
            } else {
                trigger_error('Value `' . $id . '` undefined');
            }
        }

    }