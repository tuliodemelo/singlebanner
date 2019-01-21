<?php

namespace Fulcrum\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Session;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Fulcrum\Banner\Api\BannersRepositoryInterface;
use Fulcrum\Banner\Api\Data\BannersInterface;
use Fulcrum\Banner\Api\Data\BannersInterfaceFactory;

class Save extends Action
{
    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var BannersInterfaceFactory
     */
    protected $bannersFactory;


    /**
     * @var BannersRepositoryInterface
     */
    protected $bannersRepository;

    /**
     * Save constructor.
     * @param Registry $registry
     * @param BannersRepositoryInterface $bannersRepository
     * @param PageFactory $resultPageFactory
     * @param Context $context
     * @param BannersInterfaceFactory $bannersFactory
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        Registry $registry,
        BannersRepositoryInterface $bannersRepository,
        PageFactory $resultPageFactory,
        Context $context,
        BannersInterfaceFactory $bannersFactory,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper
    )
    {
        $this->bannersFactory = $bannersFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->bannersRepository = $bannersRepository;
        parent::__construct($context);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /** @var \Fulcrum\Banner\Api\Data\BannersInterface $banner */
        $banner = null;
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['id']) ? $data['id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            if ($id) {
                $banner = $this->bannersRepository->getById((int)$id);
            } else {
                unset($data['id']);
                $banner = $this->bannersFactory->create();

            }

            $banner->setTitle($data['title']);
            $banner->setHtmlContent($data['html_content']);
            $banner->setIsActive($data['is_active']);
            $this->bannersRepository->save($banner);
            $this->messageManager->addSuccessMessage(__('You saved the banner'));
            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('banners/banner/edit', ['id' => $banner->getId()]);
            } else {
                $resultRedirect->setPath('banners/banner/index');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            if ($banner != null) {
                $this->storeBannerDataToSession(
                    $this->dataObjectProcessor->buildOutputDataArray(
                        $banner,
                        BannersInterface::class
                    )
                );
            }
            $resultRedirect->setPath('banners/banner/edit', ['author_id' => $id]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a problem saving the banner'));
            if ($banner != null) {
                $this->storeBannerDataToSession(
                    $this->dataObjectProcessor->buildOutputDataArray(
                        $banner,
                        BannersInterface::class
                    )
                );
            }
            $resultRedirect->setPath('banners/banner/edit', ['id' => $id]);
        }
        return $resultRedirect;
    }

    /**
     * @param $bannerData
     */
    protected function storeBannerDataToSession($bannerData)
    {
        $this->_getSession()->setBannerData($bannerData);
    }
}