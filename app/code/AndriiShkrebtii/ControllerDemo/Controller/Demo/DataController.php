<?php
declare(strict_types=1);

namespace AndriiShkrebtii\ControllerDemo\Controller\Demo;

use Magento\Framework\View\Result\Page as PageResponse;

class DataController implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    private $pageResponseFactory;

    /**
     * Controller constructor.
     * @param \Magento\Framework\View\Result\PageFactory $pageResponseFactory
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageResponseFactory
    ) {
        $this->pageResponseFactory = $pageResponseFactory;
    }

    /**
     * @return PageResponse
     */
    public function execute(): PageResponse
    {
        $page = $this->pageResponseFactory->create();
        $page->getLayout()->getUpdate()->addHandle('andriishkrebtii_controller_demo_demo_data_controller');
        return $this->pageResponseFactory->create();
    }
}
