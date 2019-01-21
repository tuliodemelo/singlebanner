<?php

namespace Fulcrum\Banner\Api;

/**
 * @api
 */
interface BannersRepositoryInterface
{
    /**
     * Save banner.
     *
     * @param \Fulcrum\Banner\Api\Data\BannersInterface $banner
     * @return \Fulcrum\Banner\Api\Data\BannersInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Fulcrum\Banner\Api\Data\BannersInterface $banner);

    /**
     * Retrieve Banner.
     *
     * @param int $bannerId
     * @return \Fulcrum\Banner\Api\Data\BannersInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($bannerId);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete banner.
     *
     * @param \Fulcrum\Banner\Api\Data\BannersInterface $banner
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Fulcrum\Banner\Api\Data\BannersInterface $banner);

    /**
     * Delete banner by ID.
     *
     * @param int $bannerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($bannerId);
}