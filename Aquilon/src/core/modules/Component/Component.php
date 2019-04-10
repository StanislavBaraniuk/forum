<?php
/**
 * Created by PhpStorm.
 * User: stanislaw
 * Date: 1/14/19
 * Time: 09:43
 */

//class Component extends Aquilon_Core_Element
//{
//    private $name;
//    private $path;
//    static private $is_connect = false;
//    protected static $get = [];
//
//    public function __construct($component = ["name", "path"])
//    {
//        $this->name = $component["name"];
//
//        $this->path = $component["path"];
//
//        return true;
//    }
//
//    static protected function checkExistingOfComponent ($name, $file, $error = true) {
//        if (isset(self::$get[$name]) && $error) {
//            trigger_error("You have same components by path `".self::$get[$name]->path."` and `".$file."`, rename one of this.", E_USER_ERROR);
//        } else if (isset(self::$get[$name])) {
//            return true;
//        }
//
//        return false;
//    }
//
//    static public function show ($name) {
//        self::loadViews(ROOT, $name);
//        if (!self::$is_connect) {
//            trigger_error("Component `$name` undefined", E_USER_ERROR);
//        }
//    }
//
//    static function loadViews ($dir, $component) {
//        $ffs = scandir($dir);
//
//        unset($ffs[array_search('.', $ffs, true)]);
//        unset($ffs[array_search('..', $ffs, true)]);
//
//        if (count($ffs) < 1) return false;
//
//        foreach($ffs as $ff){
//            $filePath = $dir.DS.$ff;
//            $fileName = explode(".",$ff);
//
//            if ($fileName[0] == $component.COMPONENT && $fileName[1] == PHP_FILE_EXTENSION) {
//                if (!self::checkExistingOfComponent($component, $filePath)) {
//                    require $filePath;
//                    self::$get[$component] = new Component(["name" => $component, "path" => $filePath]);
//                    self::$is_connect = true;
//                }
//            }
//
//            if(is_dir($filePath)) {
//                self::loadViews($filePath, $component);
//            }
//        }
//    }
//
//}

    class Component extends AquilonCoreElement
    {
        private $name;
        private $path;

        private static $_preloading = false;

        private static $is_connect = false;

        protected static $get = [];

        protected static $_stack = array();

        public function __construct($component = ["name", "path"])
        {
            $this->name = $component["name"];

            $this->path = $component["path"];

            return true;
        }

        protected static function checkExistingOfComponent ($name, $file, $error = true) {
            if (isset(self::$_stack[$name]) && $error) {
                trigger_error("You have same components by path `".self::$_stack[$name]->path."` and `".$file."`, rename one of this.", E_USER_ERROR);
            } else if (isset(self::$_stack[$name])) {
                return true;
            }

            return false;
        }

        public static function show ($id) : ComponentObject {
            if (!isset(self::$_stack[$id])) {
                self::loadViews( ROOT , $id );
                if (!self::$is_connect) {
                    trigger_error( "Component `$id` undefined" , E_USER_ERROR );
                }
            }

            $component = self::get($id);

            if ($component !== null) {
                $component->_toHtml();
            }

            return $component;
        }

        public static function loadViews ($dir, $component) {
            $ffs = scandir($dir);

            unset($ffs[array_search('.', $ffs, true)]);
            unset($ffs[array_search('..', $ffs, true)]);

            if (count($ffs) < 1) return false;

            foreach($ffs as $ff){
                $filePath = $dir.DS.$ff;
                $fileName = explode(".",$ff);

                if ($fileName[0] == $component.COMPONENT && $fileName[1] == PHP_FILE_EXTENSION) {
                    if (!self::checkExistingOfComponent($component, $filePath)) {

                        $componentObject = new ComponentObject($component, $filePath);

                        self::addComponent($componentObject);

                        self::$is_connect = true;
                    }
                }

                if(is_dir($filePath)) {
                    self::loadViews($filePath, $component);
                }
            }
        }

        public static function addComponent (ComponentObject $componentObject)  {

            if (!isset(self::$_stack[$componentObject->_id()])) {
                self::$_stack[$componentObject->_id()] = $componentObject;
                return self::$_stack[$componentObject->_id()];
            }

            return false;
        }

        public static function get ($id) {

            if (isset(self::$_stack[$id])) {
                return self::$_stack[$id];
            }

            return null;
        }

        public static function load ($id) {

            if (!isset(self::$_stack[$id])) {
                self::loadViews( ROOT , $id );
                if (!self::$is_connect) {
                    trigger_error( "Component `$id` undefined" , E_USER_ERROR );
                }
            }

            $component = self::get($id);

            return $component;
        }

        public static function preload ($dir) {

            self::$_preloading = true;

            $ffs = scandir($dir);

            unset($ffs[array_search('.', $ffs, true)]);
            unset($ffs[array_search('..', $ffs, true)]);

            if (count($ffs) < 1) return false;

            foreach($ffs as $ff){
                $filePath = $dir.DS.$ff;
                $fileName = explode(".",$ff);

                if (substr($fileName[0], -3) == COMPONENT && $fileName[1] == PHP_FILE_EXTENSION) {
                    $component = explode(COMPONENT, $fileName[0])[0];
                    if (!self::checkExistingOfComponent($component, $filePath)) {

                        $componentObject = new ComponentObject($component, $filePath);

                        self::addComponent($componentObject);
                    }
                }

                if(is_dir($filePath)) {
                    self::preload($filePath);
                }
            }
        }

    }