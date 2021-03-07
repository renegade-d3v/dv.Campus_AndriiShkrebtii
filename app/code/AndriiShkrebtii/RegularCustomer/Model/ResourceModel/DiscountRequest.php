<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Model\ResourceModel;

class DiscountRequest extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $_idFieldName = 'customer_request_id';

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('andriishkrebtii_regular_customer_request', 'customer_request_id');
    }
}
