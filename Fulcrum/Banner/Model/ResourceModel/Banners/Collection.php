<?php

namespace Fulcrum\Banner\Model\ResourceModel\Banners;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'fulcrum_banner_banners_collection';
    protected $_eventObject = 'banners_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Fulcrum\Banner\Model\Banners', 'Fulcrum\Banner\Model\ResourceModel\Banners');
    }

}