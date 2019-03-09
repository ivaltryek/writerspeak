<?php

$string = "Don't you worry child";
$new_string = preg_replace('/\s+/', '', $string);
echo $new_string;

?>