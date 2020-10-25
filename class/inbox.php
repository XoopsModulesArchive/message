<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class MessageInboxObject extends XoopsSimpleObject
{
    public function __construct()
    {
        $this->initVar('inbox_id', XOBJ_DTYPE_INT, 0);

        $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);

        $this->initVar('from_uid', XOBJ_DTYPE_INT, 0, true);

        $this->initVar('title', XOBJ_DTYPE_STRING, '', true, 255);

        $this->initVar('message', XOBJ_DTYPE_TEXT, '', true);

        $this->initVar('utime', XOBJ_DTYPE_INT, time(), true);

        $this->initVar('is_read', XOBJ_DTYPE_INT, 0);
    }
}

class MessageInboxHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'message_inbox';

    public $mPrimary = 'inbox_id';

    public $mClass = 'MessageInboxObject';

    public function __construct($db)
    {
        parent::XoopsObjectGenericHandler($db);
    }

    public function getCountUnreadByFromUid($uid)
    {
        $criteria = new CriteriaCompo(new Criteria('is_read', 0));

        $criteria->add(new Criteria('uid', $uid));

        return $this->getCount($criteria);
    }
}
