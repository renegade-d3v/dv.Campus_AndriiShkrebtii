<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Controller\Adminhtml\Discount;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Index extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'AndriiShkrebtii_RegularCustomer::listing';

    /**
     * @inheritDoc
     */
    public function execute(): ResultInterface
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
