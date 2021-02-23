<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Controller\Index;

use Magento\Framework\Controller\Result\Json as JsonResponse;
use AndriiShkrebtii\RegularCustomer\Model\DiscountRequest;

class Request implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    private $request;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     */
    private $jsonResponseFactory;

    /**
     * @var \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     */
    private $discountRequestFactory;

    /**
     * @var \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     */
    private $discountRequestResource;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \Psr\Log\LoggerInterface $logger
     */
    private $logger;

    /**
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     * @param \AndriiShkrebtii\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
     * @param \Magento\Customer\Model\Session $customerSession
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
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->jsonResponseFactory = $jsonResponseFactory;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->customerSession = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->storeManager = $storeManager;
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
            if (!$this->formKeyValidator->validate($this->request)) {
                throw new \InvalidArgumentException('Form key is not valid');
            }

            $customerId = $this->customerSession->getCustomerId()
                ? (int) $this->customerSession->getCustomerId()
                : null;
            $productId = (int) $this->request->getParam('product_id');
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            if ($this->customerSession->isLoggedIn()) {
                $discountRequest->setCustomerId($customerId);
            }

            $discountRequest->setName($this->request->getParam('name'))
                ->setEmail($this->request->getParam('email'))
                ->setProductId($productId)
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
