<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
require XOOPS_ROOT_PATH . '/core/XCube_PageNavigator.class.php';

class Message_PageNavi
{
    public $_mCriteria = null;

    public $_mHandler = null;

    public $mNavi = null;

    public $_mPagenum = 10;

    public $_mUrl = 'index.php';

    public function __construct(&$handler, $criteria = null)
    {
        $this->_mHandler = &$handler;

        if (is_object($criteria)) {
            $this->_mCriteria = &$criteria;
        } else {
            $this->_mCriteria = new CriteriaCompo();
        }
    }

    public function setPagenum($num)
    {
        $this->_mPagenum = $num;
    }

    public function setUrl($url)
    {
        $this->_mUrl = $url;
    }

    public function addSort($sort, $order = 'ASC')
    {
        $this->_mCriteria->setSort($sort, $order);
    }

    public function addCriteria($criteria)
    {
        $this->_mCriteria->add($criteria);
    }

    public function getTotalItems(&$total)
    {
        $total = $this->_mHandler->getCount($this->getCriteria());
    }

    public function fetch()
    {
        $this->mNavi = new XCube_PageNavigator('index.php');

        $this->mNavi->mGetTotalItems->add([&$this, 'getTotalItems']);

        $this->mNavi->setPerpage($this->_mPagenum);

        $this->mNavi->fetch();
    }

    public function getCriteria()
    {
        $this->_mCriteria->setStart($this->mNavi->getStart());

        $this->_mCriteria->setLimit($this->mNavi->getPerpage());

        return $this->_mCriteria;
    }
}
