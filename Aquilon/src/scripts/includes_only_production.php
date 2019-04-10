<?php

function listFolderFiles($dir, &$arr){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);
    if (count($ffs) < 1)
        return;

    foreach($ffs as $ff){
        if (explode(".",$ff)[1] == "php") {
            $file = $dir.'/'.$ff;
            try {
                if (strpos(file_get_contents($file), "class ".explode(".",$ff)[0])) {
                    $arr[explode(".",$ff)[0].'_'.count($arr)] = $file;
                }
            } catch (Exception $e) {
                continue;
            }
        }
        if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff, $arr);
        file_put_contents('loader_conf.json', json_encode($arr));
    }
}

function myAutoloader($class_name) {
    $arr = [];
    listFolderFiles(getcwd(), $arr);
    if (file_exists('loader_conf.json') && strlen(file_get_contents('loader_conf.json')) > 0) {
        foreach (json_decode(file_get_contents('loader_conf.json')) as $key => $item) {
            if (explode("_", $key)[0] == $class_name) {
                require_once $item;
            }
        }
    }
}

spl_autoload_register("myAutoloader");