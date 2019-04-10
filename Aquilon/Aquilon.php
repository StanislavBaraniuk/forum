<?php
/**
 * Created by PhpStorm.
 * User: stanislaw
 * Date: 1/12/19
 * Time: 00:04
 */
//

class Aquilon extends AquilonCoreElement
{

    public static function start ()
    {
        /**
         * @var ErrorHandler
         * Runs checking of the default Aquilon accesses.
         */
        self::startDefaultAccesses();

        /**
         *
         * Default session.
         */
        session_start();

        /**
         * @var ErrorHandler
         * Aquilon error handler
         */
        self::startErrorHandler();

        /**
         * @var Component
         * Loading of the Front-end components
         */
        if (COMPONENTS_PRELOADING) {
            self::startComponentsPreloading();
        }



        Route::Start();
    }

    public static function getUrl () {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".$GLOBALS['projectPath'];
    }

    protected static function startDefaultAccesses () {
        Access::_RUN_(explode(",",DEFAULT_ACCESS_RULE));
    }

    protected static function startComponentsPreloading () {
        Component::preload(ROOT);
    }

    protected static function startErrorHandler () {
        ErrorHandler::_init();
    }
}