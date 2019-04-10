<?php

require_once 'src/core/modules/AutoLoading/iLoader.php';

function generate_dependencies($dir, &$write_to_file){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    if (count($ffs) < 1) return false;

    foreach($ffs as $ff){
        $filePath = $dir.DS.$ff;

        if (count(explode(".",$ff)) > 1) {
            array_push($write_to_file, ["$ff" => "$filePath"]);
        }

        if(is_dir($filePath)) {
            generate_dependencies($filePath, $write_to_file);
        }
    }
}

$write_to_file = [];
generate_dependencies(ROOT, $write_to_file);

file_put_contents(ROOT.DS."dependency.json", json_encode(array_values($write_to_file)));
