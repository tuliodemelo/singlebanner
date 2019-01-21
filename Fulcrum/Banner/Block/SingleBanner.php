<?php

namespace Fulcrum\Banner\Block;

use Magento\Framework\View\Element\Template;
use Fulcrum\Banner\Api\BannersRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class SingleBanner extends \Magento\Framework\View\Element\Template
{
    /**
     * @var BannersRepositoryInterface
     */
    protected $bannerRepository;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * SingleBanner constructor.
     * @param Template\Context $context
     * @param BannersRepositoryInterface $bannersRepository
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        BannersRepositoryInterface $bannersRepository,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->bannerRepository = $bannersRepository;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getActiveBanner()
    {
        $activeBanner = $this->bannerRepository->getActive();
        return $activeBanner;
    }

    /**
     * @return mixed
     */
    public function isConfigEnabled()
    {
        return $this->scopeConfig->getValue(
            "banner/general/enable_frontend",
            ScopeInterface::SCOPE_STORE,
            null
        );
    }
}