<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
require _MY_MODULE_PATH . 'kernel/MyPageNavi.class.php';

class sendAction
{
    public $isError = false;

    public $errMsg = '';

    public $mActionForm;

    public $listdata;

    public $mPagenavi = null;

    public function __construct()
    {
        $root = &XCube_Root::getSingleton();

        $modHand = xoops_getModuleHandler('outbox');

        $this->mPagenavi = new Message_PageNavi($modHand);

        $this->mPagenavi->setPagenum(15);

        $this->mPagenavi->addSort('utime', 'DESC');

        $this->mPagenavi->addCriteria(new Criteria('uid', $root->mContext->mXoopsUser->get('uid')));

        $this->mPagenavi->fetch();

        $modObj = &$modHand->getObjects($this->mPagenavi->getCriteria());

        foreach ($modObj as $key => $val) {
            foreach (array_keys($val->gets()) as $var_name) {
                $item_ary[$var_name] = $val->getShow($var_name);
            }

            $item_ary['fromname'] = XoopsUserUtility::getUnameFromId($item_ary['to_uid']);

            $this->listdata[] = &$item_ary;

            unset($item_ary);
        }
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
    }

    public function executeView($render)
    {
        $root = &XCube_Root::getSingleton();

        $render->setTemplateName('message_send.html');

        $render->setAttribute('ListData', $this->listdata);

        $render->setAttribute('pageNavi', $this->mPagenavi->mNavi);
    }
}
