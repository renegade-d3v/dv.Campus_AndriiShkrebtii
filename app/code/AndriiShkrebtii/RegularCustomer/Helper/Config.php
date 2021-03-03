<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Helper;

use AndriiShkrebtii\RegularCustomer\Helper\Config as ConfigHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    public const XML_PATH_ANDRII_SHKREBTII_REGULAR_CUSTOMER_GENERAL_ENABLED
        = 'AndriiShkrebtii_RegularCustomer/general/enabled';

    public const XML_PATH_ANDRII_SHKREBTII_REGULAR_CUSTOMER_GENERAL_ALLOW_FOR_GUESTS
        = 'AndriiShkrebtii_RegularCustomer/general/allow_for_guests';

    /**
     * @return bool
     */
    public function enabled(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            ConfigHelper::XML_PATH_ANDRII_SHKREBTII_REGULAR_CUSTOMER_GENERAL_ENABLED,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function allowForGuests(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            ConfigHelper::XML_PATH_ANDRII_SHKREBTII_REGULAR_CUSTOMER_GENERAL_ALLOW_FOR_GUESTS,
            ScopeInterface::SCOPE_WEBSITE
        );
    }
}
