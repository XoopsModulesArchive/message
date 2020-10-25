<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class deleteAction
{
    public $isError = false;

    public $errMsg = '';

    public $mActionForm;

    public $inout = 'inbox';

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

        $this->isError = true;

        if (!is_object($modObj)) {
            $this->errMsg = _MD_MESSAGE_ACTIONMSG1;

            return;
        }

        if ($modObj->get('uid') != $root->mContext->mXoopsUser->get('uid')) {
            $this->errMsg = _MD_MESSAGE_ACTIONMSG2;

            return;
        }

        if ($modHand->delete($modObj)) {
            $this->errMsg = _MD_MESSAGE_ACTIONMSG3;
        } else {
            $this->errMsg = _MD_MESSAGE_ACTIONMSG4;
        }
    }

    public function executeView(&$render)
    {
    }
}
