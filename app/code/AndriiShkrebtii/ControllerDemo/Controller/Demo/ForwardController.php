<?php
declare(strict_types=1);

namespace AndriiShkrebtii\ControllerDemo\Controller\Demo;

use Magento\Framework\Controller\Result\Forward as ForwardResponse;

class ForwardController implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
     */
    private $forwardResponseFactory;

    /**
     * Controller constructor.
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
     */
    public function __construct(
        \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
    ) {
        $this->forwardResponseFactory = $forwardResponseFactory;
    }

    /**
     * @return ForwardResponse
     */
    public function execute(): ForwardResponse
    {
        return $this->forwardResponseFactory->create()
            ->setController('DataController')
            ->setParams([
                '_secure' => true,
                'name' => 'Andrii',
                'surname' => 'Shkrebtii',
                'repourl' => 'https://github.com/jimmywilson111'
            ])
            ->forward('action');
    }
}
