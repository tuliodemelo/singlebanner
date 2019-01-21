<?php

namespace Fulcrum\Banner\Block\Adminhtml\Banners\Edit\Buttons;

use Fulcrum\Banner\Api\BannersRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Fulcrum\Banner\Api\BannerRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Generic
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var BannersRepositoryInterface
     */
    protected $bannersRepository;

    /**
     * Generic constructor.
     * @param Context $context
     * @param BannersRepositoryInterface $bannersRepository
     */
    public function __construct(
        Context $context,
        BannersRepositoryInterface $bannersRepository
    ) {
        $this->context = $context;
        $this->bannersRepository = $bannersRepository;
    }

    /**
     * @return int|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getId()
    {
        try {
            return $this->bannersRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}