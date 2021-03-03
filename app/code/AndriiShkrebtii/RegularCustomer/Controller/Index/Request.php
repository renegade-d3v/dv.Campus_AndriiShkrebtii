<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Controller\Index;

use Magento\Framework\Controller\Result\Json as JsonResponse;
use AndriiShkrebtii\RegularCustomer\Model\DiscountRequest;

class Request implements \Magento\Framework\App\Action\HttpPostActionInterface
{

    private \Magento\Framework\App\RequestInterface $request;

    private \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory;

    private \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    private \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    private \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator;

    private \Magento\Customer\Model\Session $customerSession;

    private \AndriiShkrebtii\RegularCustomer\Helper\Config $configHelper;

    private \Psr\Log\LoggerInterface $logger;

    /**
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     * @param \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \AndriiShkrebtii\RegularCustomer\Helper\Config $configHelper
     * @param \Psr\Log\LoggerInterface $logger
     */

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory,
        \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Customer\Model\Session $customerSession,
        \AndriiShkrebtii\RegularCustomer\Helper\Config $configHelper,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->jsonResponseFactory = $jsonResponseFactory;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->customerSession = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->storeManager = $storeManager;
        $this->configHelper = $configHelper;
        $this->logger = $logger;
    }

    /**
     * @return JsonResponse
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(): JsonResponse
    {
        // @TODO: pass message via notifications, not alert
        // @TODO: add form key validation and hideIt validation
        // @TODO: add Google Recaptcha to the form
        $response = $this->jsonResponseFactory->create();
        $formSaved = false;

        try {
            if (!$this->configHelper->enabled()) {
                throw new \BadMethodCallException('Personal Discount requested, but the request can\'t be handled');
            }

            if (!$this->customerSession->isLoggedIn()
                && !$this->configHelper->allowForGuests()
            ) {
                throw new \BadMethodCallException('Personal Discount requested, but the request can\'t be handled');
            }

            if (!$this->formKeyValidator->validate($this->request)) {
                throw new \InvalidArgumentException('Form key is not valid');
            }

            $customerId = $this->customerSession->getCustomerId()
                ? (int) $this->customerSession->getCustomerId()
                : null;

            if ($this->customerSession->isLoggedIn()) {
                $name = $this->customerSession->getCustomer()->getName();
                $email = $this->customerSession->getCustomer()->getEmail();
            } else {
                $name = $this->request->getParam('name');
                $email = $this->request->getParam('email');
            }

            $productId = (int) $this->request->getParam('product_id');
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            if ($this->customerSession->isLoggedIn()) {
                $discountRequest->setCustomerId($customerId);
            }

            $discountRequest->setName($name)
                ->setEmail($email)
                ->setCustomerId($customerId)
                ->setProductId((int)$this->request->getParam('product_id'))
                ->setWebsiteId((int)$this->storeManager->getStore()->getWebsiteId())
                ->setStatus(DiscountRequest::STATUS_PENDING);
            $this->discountRequestResource->save($discountRequest);

            if (!$this->customerSession->isLoggedIn()) {
                $this->customerSession->setDiscountRequestCustomerEmail($this->request->getParam('email'));
                $productIds = $this->customerSession->getDiscountRequestProductIds() ?? [];
                $productIds[] = $productId;
                $this->customerSession->setDiscountRequestProductIds(array_unique($productIds));
            }

            $formSaved = true;
        } catch (\InvalidArgumentException $e) {
            // No need to log form key validation errors
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        $message = $formSaved
            ? __('Your request for a discount for the product %1 has been accepted!', $this->request
                ->getParam('productName'))
            : __('Your request can\'t be sent. Please, contact us if you see this message.');

        $response->setData([
            'message' =>$message
        ]);
        return $response;
    }
}
