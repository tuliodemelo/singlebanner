<?php

namespace Fulcrum\Banner\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Fulcrum\Core\Helper\Setup;

class InstallSchema implements InstallSchemaInterface
{
    protected $setupHelper;

    public function __construct(Setup $setupHelper)
    {
        $this->setupHelper = $setupHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $fields = [
            [
                'name' => 'id',
                'type' => Table::TYPE_INTEGER,
                'options' => ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'comment' => 'Banner ID'
            ],
            [
                'name' => 'title',
                'type' => Table::TYPE_TEXT,
                'options' => ['nullable' => false],
                'comment' => 'Banner Title'
            ],
            [
                'name' => 'html_content',
                'type' => Table::TYPE_TEXT,
                'options' => ['nullable' => false],
                'comment' => 'Banner HTML Content'
            ],
            [
                'name' => 'is_active',
                'type' => Table::TYPE_INTEGER,
                'options' => ['nullable' => false],
                'comment' => 'Banner Status'
            ]
        ];

        $this->setupHelper->createTable($setup, 'banners', $fields, 'Fulcrum Banner Table');

        $installer->endSetup();
    }
}