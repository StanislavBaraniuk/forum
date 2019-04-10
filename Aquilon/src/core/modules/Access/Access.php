<?php
/**
 * Created by PhpStorm.
 * User: stanislaw
 * Date: 1/17/19
 * Time: 22:58
 */

class Access
{
    static private $filters = [];

    public static function _USE_ () {
    }

    static public function _RUN_ ($filters, $radical = true) {

        if (is_array($filters)) {
            foreach ($filters as $filter) {
                self::load(ROOT, $filter);
            }
        } else {
            self::load(ROOT, $filters);
        }

        $isFind = false;

        if (count(self::$filters) > 0) {
            foreach ($filters as $filter) {
                if (isset(self::$filters[$filter])) {
                    $filter_req = require self::$filters[$filter];
                    if (!$filter_req[0]) {
                        http_response_code($filter_req[2]);

                        if ($radical) {
                            echo $filter_req[1];
                            exit(0);
                        } else {
                            return array( 'value' => false , "message" => "Filter `$filter` return false;` " );
                        }
                    } else {
                        return array( 'value' => true , "message" => null );
                    }
                } else {
                    if ($radical) {
                        trigger_error( "Filter `$filter` undefined" , E_USER_ERROR );
                    } else {
                        return array( 'value' => false , "message" => "Filter `$filter` undefined" );
                    }
                }
            }

        } else {
            if ($radical) {
                trigger_error("Filters not found");
            } else {
                return array('value' => false, "message" => "Filters not found");
            }
        }

        if ($radical) {
            trigger_error( "Something went wrong" , E_USER_ERROR );
        } else {
            return array('value' => false, "message" => "Something went wrong");
        }
    }

    static private function load ($dir, $filter_name) {
        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        if (count($ffs) < 1) return false;

        foreach($ffs as $ff){
            $filePath = $dir.'/'.$ff;
            $fileName = explode(".",$ff);

            if (isset($fileName[ 1 ], $fileName[ 0 ]) ) {
                if ($fileName[ 1 ] == PHP_FILE_EXTENSION && $fileName[ 0 ] == $filter_name . FILTER && strpos( $fileName[ 0 ] , FILTER ) && strpos( file_get_contents( $filePath ) , 'Access::_USE_()' )) {
                    self::$filters[ explode( FILTER , $fileName[ 0 ] )[ 0 ] ] = $filePath;
                    return true;
                }
            }

            if(is_dir($filePath)) {
                self::load($filePath, $filter_name);
            }
        }
    }

}