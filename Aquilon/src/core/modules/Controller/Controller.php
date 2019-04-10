<?php
/**
 * Created by PhpStorm.
 * User: stanislaw
 * Date: 1/12/19
 * Time: 00:02
 */

abstract class Controller extends AquilonCoreElement
{
    protected $_model;

    public function _initModel ($className = null) {

        if (empty($className)) {
            $className = get_called_class();
        }

        $this->_model = $this->getModel($className);
    }

    public function __call($name, $arguments)
    {

        echo "$name";
    }
}