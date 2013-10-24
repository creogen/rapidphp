<?php

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(__DIR__ . '/../src/'),
    get_include_path(),
)));

require_once 'Rapid/Loader.php';
//\Rapid\Loader::setAutoLoaders();
$loader = new Rapid\Loader();
$loader->registerNamespace('Rapid', __DIR__ . '/../src/Rapid');
$loader->register();