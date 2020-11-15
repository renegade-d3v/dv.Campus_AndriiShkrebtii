<?php

declare(strict_types=1);

namespace AndriiShkrebtii\LayoutDebug\Observer;

class DumpMergedLayout  implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer): void
    {
        $xml = $observer->getEvent()->getLayout()->getXmlString();
        $writer = new \Laminas\Log\Writer\Stream(BP . '/var/log/layout_block.xml');
        $logger = new \Laminas\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($xml);
    }
}
