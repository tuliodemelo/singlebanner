<?php

namespace Fulcrum\Banner\Model;

class Banners extends \Magento\Framework\Model\AbstractModel implements \Fulcrum\Banner\Api\Data\BannersInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'fulcrum_banner_banners';

    protected $_cacheTag = 'fulcrum_banner_banners';

    protected $_eventPrefix = 'fulcrum_banner_banners';

    protected function _construct()
    {
        $this->_init('Fulcrum\Banner\Model\ResourceModel\Banners');
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    /**
     * @return int|mixed|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @return mixed|string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @return mixed|string
     */
    public function getHtmlContent()
    {
        return $this->getData(self::HTML_CONTENT);
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * @param mixed $id
     * @return \Fulcrum\Banner\Api\Data\BannersInterface|Banners|\Magento\Framework\Model\AbstractModel
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @param $title
     * @return \Fulcrum\Banner\Api\Data\BannersInterface|Banners
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @param $html_content
     * @return \Fulcrum\Banner\Api\Data\BannersInterface|Banners
     */
    public function setHtmlContent($html_content)
    {
        return $this->setData(self::HTML_CONTENT, $html_content);
    }

    /**
     * @param $is_active
     * @return Banners|mixed
     */
    public function setIsActive($is_active)
    {
        return $this->setData(self::IS_ACTIVE, $is_active);
    }
}