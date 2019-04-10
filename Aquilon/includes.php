<?php

require_once 'config/constants.php';
require_once 'src/core/modules/AutoLoading/iLoader.php';

function ClassesAutoloader($class_name) {
    $escape = false;

    foreach (get_included_files() as $item) {
        $file = explode(DS, $item);
        if ($class_name == $file[count($file)-1]) {
            $escape = true;
        }
    }
    if (!$escape) {
        iLoader::classFinder(ROOT, $class_name);
    }
}

spl_autoload_register("ClassesAutoloader");

?>
