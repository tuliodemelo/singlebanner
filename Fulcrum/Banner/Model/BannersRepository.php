<?php

namespace Fulcrum\Banner\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Registry;
use \Fulcrum\Banner\Model\ResourceModel\Banners\CollectionFactory as BannersCollection;

class BannersRepository implements \Fulcrum\Banner\Api\BannersRepositoryInterface
{
    /**
     * @access protected
     * @var \Fulcrum\Banner\Api\Data\BannersInterfaceFactory
     */
    protected $objectFactory;

    /**
     * @access protected
     * @var \Fulcrum\Banner\Model\ResourceModel\Banners\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @access protected
     * @var \Magento\Framework\Api\SearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @access protected
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @access protected
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var \Fulcrum\Banner\Api\Data\BannersInterface
     */
    protected $objectModel;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var BannersCollection
     */
    protected $bannersCollection;

    /**
     * BannersRepository constructor.
     * @param \Fulcrum\Banner\Api\Data\BannersInterfaceFactory $objectFactory
     * @param \Fulcrum\Banner\Api\Data\BannersInterface $objectModel
     * @param ResourceModel\Banners\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
     * @param Registry $registry
     * @param BannersCollection $bannersCollection
     */
    public function __construct(
        \Fulcrum\Banner\Api\Data\BannersInterfaceFactory $objectFactory,
        \Fulcrum\Banner\Api\Data\BannersInterface $objectModel,
        \Fulcrum\Banner\Model\ResourceModel\Banners\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        Registry $registry,
        BannersCollection $bannersCollection
    )
    {
        $this->objectFactory = $objectFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->objectModel = $objectModel;
        $this->registry = $registry;
        $this->bannersCollection = $bannersCollection;
    }


    public function save(\Fulcrum\Banner\Api\Data\BannersInterface $banner)
    {
        try {
            $banner->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $banner;
    }

    /**
     * @param int $id
     * @return \Fulcrum\Banner\Api\Data\BannersInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $banner = $this->objectFactory->create();
        $banner->load($id);
        if (!$banner->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
        }
        return $banner;
    }

    /**
     * @param \Fulcrum\Banner\Api\Data\BannersInterface $banner
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Fulcrum\Banner\Api\Data\BannersInterface $banner)
    {
        try {
            $banner->delete();
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Yandeh\Quotation\Api\Data\QuotationSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $collection = $this->collectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {

            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;
    }

    public function getActive()
    {
        $bannersCollection = $this->bannersCollection->create();
        $bannersCollection->addFieldToFilter('is_active', 1);
        return $bannersCollection->fetchItem();
    }

}