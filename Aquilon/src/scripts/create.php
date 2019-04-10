<?php

for ($i = 10; $i < 10000; $i++) {
    file_put_contents("TestClass$i.php", '<?php class TestClass'.$i.' { static function e($val) { echo $val; }  } ?>');
}