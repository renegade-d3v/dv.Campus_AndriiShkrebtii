<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;

class RemoveUniqueIndex implements \Magento\Framework\Setup\Patch\SchemaPatchInterface, DataPatchInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface $schemaSetup
     */
    private $schemaSetup;

    /**
     * RemoveOldForeignKeys constructor.
     * @param \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
     */
    public function __construct(
        \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
    ) {
        $this->schemaSetup = $schemaSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->schemaSetup->getConnection()->startSetup();
        $this->schemaSetup->getConnection()->dropIndex(
            $this->schemaSetup->getIdxName($this->schemaSetup->getTable('andriishkrebtii_regular_customer_request'), ['email', 'website_id'], 'unique')
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
