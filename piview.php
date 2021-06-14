<?php

// Show all information, defaults to INFO_ALL
phpinfo();

?><?php
require_once 'System.php';
var_dump(class_exists('System', false));
var_dump(extension_loaded('ssh2'));
?>