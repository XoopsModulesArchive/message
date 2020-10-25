<?php

require dirname(__DIR__, 2) . '/mainfile.php';
define('_MY_DIRNAME', basename(__DIR__));
define('_MY_MODULE_PATH', XOOPS_MODULE_PATH . '/' . _MY_DIRNAME . '/');
define('_MY_MODULE_URL', XOOPS_MODULE_URL . '/' . _MY_DIRNAME . '/');

require _MY_MODULE_PATH . 'kernel/message.class.php';

$root = &XCube_Root::getSingleton();
$root->mController->executeHeader();

$message = new message();
$root->mController->mExecute->add([&$message, 'execute']);
$root->mController->execute();

$root->mController->executeView();
