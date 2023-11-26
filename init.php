<?php

$conflictFiles = [
    'container/viewPhpConf.php',
    'container/viewSmartyConf.php'
];

foreach ($conflictFiles as $conflictFile) {
    if (file_exists($conflictFile)) {
        unlink($conflictFile);
    }
}
