<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class MessageOutboxObject extends XoopsSimpleObject
{
    public function __construct()
    {
        $this->initVar('outbox_id', XOBJ_DTYPE_INT, 0, true);

        $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);

        $this->initVar('to_uid', XOBJ_DTYPE_INT, 0, true);

        $this->initVar('title', XOBJ_DTYPE_STRING, '', true, 255);

        $this->initVar('message', XOBJ_DTYPE_TEXT, '', true);

        $this->initVar('utime', XOBJ_DTYPE_INT, time(), true);
    }
}

class MessageOutboxHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'message_outbox';

    public $mPrimary = 'outbox_id';

    public $mClass = 'MessageOutboxObject';

    public function __construct($db)
    {
        parent::XoopsObjectGenericHandler($db);
    }
}
