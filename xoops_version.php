<?php

$modversion['name'] = _MI_MESSAGE_NAME;
$modversion['dirname'] = basename(__DIR__);
$modversion['version'] = 0.15;
$modversion['author'] = 'Marijuana';

$modversion['image'] = 'slogo.png';

$modversion['cube_style'] = true;
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][] = '{prefix}_{dirname}_inbox';
$modversion['tables'][] = '{prefix}_{dirname}_outbox';

$modversion['hasAdmin'] = 0;
$modversion['templates'][] = ['file' => 'message_index.html'];
$modversion['templates'][] = ['file' => 'message_new.html'];
$modversion['templates'][] = ['file' => 'message_view.html'];
$modversion['templates'][] = ['file' => 'message_send.html'];
$modversion['templates'][] = ['file' => 'message_sendview.html'];

$modversion['hasMain'] = 1;
$modversion['sub'][] = ['name' => _MI_MESSAGE_SUB_SEND, 'url' => 'index.php?action=send'];
$modversion['sub'][] = ['name' => _MI_MESSAGE_SUB_NEW, 'url' => 'index.php?action=new'];
