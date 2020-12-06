<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Controller\Index;

use Magento\Framework\Controller\Result\Json as JsonResponse;

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
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
    ) {
        $this->request = $request;
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    /**
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        // @TODO: pass message via notifications, not alert
        // @TODO: add form key validation and hideIt validation
        // @TODO: add Google Recaptcha to the form
        return $this->jsonResponseFactory->create();
    }
}
