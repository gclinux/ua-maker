<?php
include '../src/class/UaMaker.php';
$UA = (new \gclinux\UaMaker)->makeUa('CN','android');
print_r($UA);
$UA = (new \gclinux\UaMaker)->makeUa('US','ios');
print_r($UA);