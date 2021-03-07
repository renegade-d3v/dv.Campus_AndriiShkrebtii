<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Controller\Adminhtml\Discount;

use AndriiShkrebtii\RegularCustomer\Model\Authorization;
use AndriiShkrebtii\RegularCustomer\Model\DiscountRequest;

class Save extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    public const ADMIN_RESOURCE = Authorization::ACTION_DISCOUNT_REQUEST_EDIT;

    private \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    private \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    private \Magento\Backend\Model\Auth\Session $authSession;

    /**
     * Save constructor.
     *
     * @param \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->storeManager = $storeManager;
        $this->authSession = $authSession;
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $discountRequest = $this->discountRequestFactory->create();
            $admin_user_Id = $this->authSession->getUser()->getId();
            $customerId = $this->getRequest()->getParam('customer_id') ?: null;

            $discountRequest->setProductId($this->getRequest()->getParam('product_id'))
                ->setCustomerId($customerId)
                ->setName($this->getRequest()->getParam('name'))
                ->setEmail($this->getRequest()->getParam('email'))
                ->setWebsiteId((int)$this->storeManager->getStore()->getWebsiteId())
                ->setStatus(DiscountRequest::STATUS_PENDING)
                ->setAdminUserId($admin_user_Id);

            $this->messageManager->addSuccessMessage(__('Request saved!'));

            $this->discountRequestResource->save($discountRequest);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('*/*/edit');
    }
}
