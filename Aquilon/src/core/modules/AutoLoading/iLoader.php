<?php
/**
 * Created by PhpStorm.
 * User: stanislaw
 * Date: 1/15/19
 * Time: 11:57
 */

class iLoader
{
    public static function classFinder($dir, $class_name){

        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        if (count($ffs) < 1) return false;

        foreach($ffs as $ff){
            $filePath = $dir.DS.$ff;
            $fileName = explode(".",$ff);

            if (
                isset($fileName[ 1 ], $fileName[ 0 ])
            ) {
                if (
                    $fileName[ 1 ] == PHP_FILE_EXTENSION
                    && $fileName[ 0 ] == $class_name
                    && strpos( file_get_contents( $filePath ) , "class " . $fileName[ 0 ] )
                ) {
                    require_once $filePath;
                    return true;
                }
            }

            if(is_dir($filePath)) {
                self::classFinder($filePath, $class_name);
            }
        }

        return false;
    }

    public static function load($class_names = []) {

        foreach ($class_names as $class_name) {
            self::classFinder(ROOT, $class_name);
        }
    }

    public static function find($dir, $file) {

        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        if (count($ffs) < 1) return false;

        foreach($ffs as $ff){

            $filePath = $dir.DS.$ff;

            if ($ff == $file) {
                return $filePath;
            }

            if(is_dir($filePath)) {
                self::classFinder($filePath, $file);
            }
        }
    }


}