<?php

if (!defined('XOOPS_ROOT_PATH')) {
    die();
}

class Message_Preload extends XCube_ActionFilter
{
    public function postFilter()
    {
        if ($this->mRoot->mContext->mUser->isInRole('Site.RegisteredUser')) {
            require_once XOOPS_MODULE_PATH . '/message/service/Service.class.php';

            $service = new Message_Service();

            $service->prepare();

            $this->mRoot->mServiceManager->addService('privateMessage', $service);

            $this->mRoot->mDelegateManager->add('Myfriend.NewAlert', 'Message_Preload::getNewMessage');

            $this->mRoot->mDelegateManager->add('Legacypage.Viewpmsg.Access', 'Message_Preload::accessToReadpmsg');

            $this->mRoot->mDelegateManager->add('Legacypage.Readpmsg.Access', 'Message_Preload::accessToReadpmsg');

            $this->mRoot->mDelegateManager->add('Legacypage.Pmlite.Access', 'Message_Preload::accessToReadpmsg');
        }
    }

    public function getNewMessage(&$arrays)
    {
        $root = &XCube_Root::getSingleton();

        if ($root->mContext->mUser->isInRole('Site.RegisteredUser')) {
            $uid = $root->mContext->mXoopsUser->get('uid');

            $modHand = xoops_getModuleHandler('inbox', 'message');

            $num = $modHand->getCountUnreadByFromUid($uid);

            if ($num > 0) {
                $root->mLanguageManager->loadModuleMessageCatalog('message');

                $arrays[] = [
                    'url' => XOOPS_MODULE_URL . '/message/index.php',
'title' => XCube_Utils::formatString(_MD_MESSAGE_NEWMESSAGE, $num),
                ];
            }
        }
    }

    public function accessToReadpmsg()
    {
        $root = &XCube_Root::getSingleton();

        $root->mController->executeForward(XOOPS_MODULE_URL . '/message/');
    }
}
