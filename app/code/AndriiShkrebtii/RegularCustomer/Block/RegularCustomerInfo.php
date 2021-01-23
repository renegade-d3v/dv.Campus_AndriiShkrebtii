<?php
declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Block;

use AndriiShkrebtii\RegularCustomer\Model\DiscountRequest;
use AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;
use Magento\Framework\Phrase;

class RegularCustomerInfo extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactorys
     */
    private $collectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * PersonalDiscountInfo constructor.
     * @param \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
    }

    /**
     * @return DiscountRequest|null
     */
    public function getPersonalDiscount(): ?DiscountRequest
    {
        /** @var DiscountRequestCollection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('customer_id', (int)$this->customerSession->getCustomerId());
        $collection->addFieldToFilter('email', 'john-doe@example.com');
        // @TODO: check if accounts are shared or not
        $collection->addFieldToFilter('website_id', $this->storeManager->getStore()->getWebsiteId());
        /** @var DiscountRequest $discountRequest */
        $discountRequest = $collection->getFirstItem();

        return $discountRequest->getCustomerRequestId() ? $discountRequest : null;
    }

    /**
     * @param DiscountRequest $discountRequest
     * @return Phrase
     */
    public function getStatusMessage(DiscountRequest $discountRequest): Phrase
    {
        switch ($discountRequest->getStatus()) {
            case DiscountRequest::STATUS_PENDING:
                return __('pending');
            case DiscountRequest::STATUS_APPROVED:
                return __('approved');
            case DiscountRequest::STATUS_DECLINED:
            default:
                return __('declined');
        }
    }
}
