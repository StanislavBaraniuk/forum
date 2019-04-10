<?php

/**
 * Class Route
 */
class Route
{

    /**
     * @var null
     */
    private static $controller = null;
    /**
     * @var null
     */
    private static $action = null;

    /**
     * @return mixed|string
     */

    /**
     * @param $uri
     */
    protected static function getRoute($uri)
    {

        $projectPath = explode(DS,realpath(dirname('')));

        for ($i = 0; $i < count($projectPath); $i++) {
            for ($j = 0; $j < count($uri); $j++) {
                if (isset($projectPath[ $i ], $uri[ $j ])) {
                    if ($projectPath[ $i ] === $uri[ $j ]) {
                        unset( $uri[ $j ] );
                        unset( $projectPath[ $i ] );
                    }
                }
            }
        }

        $uri = array_values($uri);

        if ($uri[0] === "") {
            array_shift($uri);
        }
        if (isset($uri[0]) && $uri[0] === 'index.php') {
            array_shift($uri);
        }

        self::$controller = !empty($uri[0]) ? $uri[0] : HOME_CONTROLLER;
        self::$action = !empty($uri[1]) ? $uri[1] : DEFAULT_ACTION;

        unset($uri[0]);
        unset($uri[1]);

        return $uri;
    }

    /**
     *
     */
    public static function Start()
    {

        $route = self::cutRoute();
        $route = self::getRoute($route);

        $className = ucfirst(self::$controller).'Controller';

        $controller_name = class_exists($className) ? $className  : ucfirst(DEFAULT_404) . 'Controller';
        $action_name = self::$action . 'Action';

        $controller = new $controller_name();

        if (!method_exists($controller, self::$action . 'Action')) {
            $action_name = DEFAULT_ACTION . 'Action';
        }

        $getParams = self::createInputParams($route);

        $_GET = array_merge($_GET, $getParams);

        $controller->$action_name(count($getParams) > 1 ? $getParams : Aquilon::getByKey($getParams, 0));
    }

    private static function cutRoute () {
        $route = explode('/', $_SERVER['REQUEST_URI']);

        unset($route[0]);

        return $route;
    }

    public static function createInputParams ($params) {

        $return_array = [];
        $params_array =  is_array($params) ? $params : explode("&&", $params);

        foreach ($params_array as $param) {
            $key_value = explode( '=' , $param );

            if (count( $key_value ) == 2 && !empty($key_value[ 0 ])) {
                $return_array[ $key_value[ 0 ] ] = $key_value[ 1 ];
            } else {
                $return_array[] = $param;
            }
        }

        if (!empty($_GET)) {
            end($return_array);
            unset($return_array[key($return_array)]);
        }

        return $return_array;
    }

    /**
     * @return null
     */
    public static function getAction()
     {
        return self::$action;
     }

    /**
     * @return null
     */
    public static function getController()
     {
        return self::$controller;
     }

}
