<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Helper;

use Magento\Framework\App\Helper\Context;

class CurrentProduct extends \Magento\Framework\App\Helper\AbstractHelper
{
    private \Magento\Framework\Registry $registry;

    /**
     * CurrentProduct constructor.
     * @param \Magento\Framework\Registry $registry
     * @param Context $context
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
        $this->registry = $registry;
    }

    /**
     * @return int
     */
    public function getCurrentProductId(): int
    {
        // Must throw exception if there is no product in the registry
        return (int) $this->registry->registry('product')->getId();
    }
}
