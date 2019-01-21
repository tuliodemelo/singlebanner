<?php

namespace Fulcrum\Banner\Model;

use Fulcrum\Banner\Model\ResourceModel\Banners\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannerCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannerCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $banner) {
            $this->_loadedData[$banner->getId()] = $banner->getData();
        }
        return $this->_loadedData;
    }
}
