<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Setup\Patch\Schema;

class RemoveUniqueIndex implements \Magento\Framework\Setup\Patch\SchemaPatchInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface $schemaSetup
     */
    private $schemaSetup;

    public function __construct(
        \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
    ) {
        $this->schemaSetup = $schemaSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(): void
    {
        $this->schemaSetup->getConnection()->startSetup();
        $this->schemaSetup->getConnection()->dropIndex(
            $this->schemaSetup->getTable('andriishkrebtii_regular_customer_request'),
            $this->schemaSetup->getIdxName('andriishkrebtii_regular_customer_request', ['email', 'website_id'], 'unique')
        );
        $this->schemaSetup->getConnection()->endSetup();
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
