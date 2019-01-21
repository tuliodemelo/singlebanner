<?php

namespace Fulcrum\Banner\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 */
interface BannersSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get banner list.
     *
     * @return \Fulcrum\Banner\Api\Data\BannersInterface[]
     */
    public function getItems();

    /**
     * Set banner list.
     *
     * @param \Fulcrum\Banner\Api\Data\BannersInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}