<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class viewAction
{
    public $isError = false;

    public $errMsg = '';

    public $inout = 'inbox';

    public $msgdata = null;

    public function __construct()
    {
    }

    public function getisError()
    {
        return $this->isError;
    }

    public function geterrMsg()
    {
        return $this->errMsg;
    }

    public function execute()
    {
        $root = &XCube_Root::getSingleton();

        if ('in' == $root->mContext->mRequest->getRequest('inout')) {
            $this->inout = 'inbox';
        } else {
            $this->inout = 'outbox';
        }

        $boxid = (int)$root->mContext->mRequest->getRequest($this->inout);

        $modHand = xoops_getModuleHandler($this->inout);

        $modObj = $modHand->get($boxid);

        if (!is_object($modObj)) {
            $this->isError = true;

            $this->errMsg = _MD_MESSAGE_ACTIONMSG1;

            return;
        }

        if ($modObj->get('uid') != $root->mContext->mXoopsUser->get('uid')) {
            $this->isError = true;

            $this->errMsg = _MD_MESSAGE_ACTIONMSG8;

            return;
        }

        foreach (array_keys($modObj->gets()) as $var_name) {
            $this->msgdata[$var_name] = $modObj->getShow($var_name);
        }

        if ('inbox' == $this->inout) {
            $this->msgdata['fromname'] = XoopsUserUtility::getUnameFromId($this->msgdata['from_uid']);
        } else {
            $this->msgdata['toname'] = XoopsUserUtility::getUnameFromId($this->msgdata['to_uid']);
        }

        $modObj->set('is_read', 1);

        $modHand->insert($modObj, true);
    }

    public function executeView($render)
    {
        $root = &XCube_Root::getSingleton();

        if ('inbox' == $this->inout) {
            $render->setTemplateName('message_view.html');
        } else {
            $render->setTemplateName('message_sendview.html');
        }

        $render->setAttribute('msgdata', $this->msgdata);
    }
}
