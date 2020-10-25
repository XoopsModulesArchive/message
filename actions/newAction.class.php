<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
require _MY_MODULE_PATH . 'forms/MessageForm.class.php';

class newAction
{
    public $isError = false;

    public $errMsg = '';

    public $mActionForm;

    public function __construct()
    {
        $this->mActionForm = new MessageForm();

        $this->mActionForm->prepare();
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

        $inboxid = (int)$root->mContext->mRequest->getRequest('res');

        $to_userid = (int)$root->mContext->mRequest->getRequest('to_userid');

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $this->mActionForm->fetch();

            $this->mActionForm->validate();

            if ($this->mActionForm->hasError()) {
                $this->errMsg = $this->mActionForm->getErrorMessages();
            } elseif ('' != $this->mActionForm->get('Legacy_Event_User_Submit')) {
                $this->isError = true;

                $modHand = xoops_getModuleHandler('inbox');

                $modObj = $modHand->create();

                $this->mActionForm->update($modObj);

                if (!$modHand->insert($modObj)) {
                    $this->errMsg = _MD_MESSAGE_ACTIONMSG5;
                } else {
                    if (!$this->update_outbox($modObj)) {
                        $this->errMsg = _MD_MESSAGE_ACTIONMSG6;
                    } else {
                        $this->errMsg = _MD_MESSAGE_ACTIONMSG7;
                    }
                }
            }
        } elseif ($inboxid > 0) {
            $modHand = xoops_getModuleHandler('inbox');

            $modObj = $modHand->get($inboxid);

            $this->mActionForm->setRes($modObj);
        } elseif ($to_userid > 0) {
            $userhand = xoops_getHandler('user');

            $user = $userhand->get($to_userid);

            $this->mActionForm->setUser($user);
        }
    }

    public function update_outbox($obj)
    {
        $outHand = xoops_getModuleHandler('outbox');

        $outObj = $outHand->create();

        $outObj->set('uid', $obj->get('from_uid'));

        $outObj->set('to_uid', $obj->get('uid'));

        $outObj->set('title', $obj->get('title'));

        $outObj->set('message', $obj->get('message'));

        $outObj->set('utime', $obj->get('utime'));

        return $outHand->insert($outObj);
    }

    public function executeView($render)
    {
        $render->setTemplateName('message_new.html');

        $render->setAttribute('mActionForm', $this->mActionForm);

        $render->setAttribute('errMsg', $this->errMsg);
    }
}
