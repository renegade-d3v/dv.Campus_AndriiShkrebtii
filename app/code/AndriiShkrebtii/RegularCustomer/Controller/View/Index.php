<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Controller\View;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\ResponseInterface;

class Index extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\View\Result\PageFactory $pageResponseFactory;

    private \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory;

    private \AndriiShkrebtii\RegularCustomer\Helper\Config $configHelper;

    private \Magento\Customer\Model\Session $customerSession;

    /**
     * Controller constructor.
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory
     * @param \AndriiShkrebtii\RegularCustomer\Helper\Config $configHelper;
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory,
        \AndriiShkrebtii\RegularCustomer\Helper\Config $configHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->pageResponseFactory = $pageResponseFactory;
        $this->forwardFactory = $forwardFactory;
        $this->configHelper = $configHelper;
        $this->customerSession = $customerSession;
    }

    /**
     * Check customer authentication for some actions
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function dispatch(RequestInterface $request): ResponseInterface
    {
        if ($this->configHelper->enabled() && !$this->customerSession->authenticate()) {
            $this->_actionFlag->set('', 'no-dispatch', true);
        }

        return parent::dispatch($request);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        if (!$this->configHelper->enabled()) {
            $resultForward = $this->forwardFactory->create();
            return $resultForward->forward('noroute');
        }

        return $this->pageResponseFactory->create();
    }
}
