<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(
            \AndriiShkrebtii\RegularCustomer\Model\DiscountRequest::class,
            \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest::class
        );
    }
}
