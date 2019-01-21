<?php

namespace Fulcrum\Banner\Controller\Adminhtml\Banner;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Fulcrum\Banner\Api\BannersRepositoryInterface;

class Delete extends Action
{
    /**
     * @var bool|PageFactory
     */
    protected $resultPageFactory = false;

    /**
     * @var BannersRepositoryInterface
     */
    protected $bannersRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param BannersRepositoryInterface $bannersRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BannersRepositoryInterface $bannersRepository
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->bannersRepository = $bannersRepository;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->bannersRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The banner has been deleted.'));
                $resultRedirect->setPath('banners/*/');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The banner no longer exists.'));
                return $resultRedirect->setPath('banners/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('banners/banner/edit', ['id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the banner'));
                return $resultRedirect->setPath('banners/banner/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a banner to delete.'));
        $resultRedirect->setPath('banner/*/');
        return $resultRedirect;
    }
}