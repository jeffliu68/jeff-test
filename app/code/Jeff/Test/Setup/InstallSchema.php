<?php

namespace Jeff\Test\Setup;
 
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
 
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
 
        $table = $setup->getConnection()->newTable(
            $setup->getTable('jefftest_bidprice')
        )->addColumn(
            'bidprice_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Bid Price Id'
        )->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => false, 'unsigned' => true, 'nullable' => false, 'primary' => false],
            'Product Id'
        )->addColumn(
            'customer_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => false, 'unsigned' => true, 'nullable' => false, 'primary' => false],
            'Customer Id'
        )->addColumn(
            'bid_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
            null,
            [],
            'Bid Time'
        )->addColumn(
            'winning',
            \Magento\Framework\Db\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Winning Bid Yes or No'
        )->addColumn(
            'bid_price',
            \Magento\Framework\Db\Ddl\Table::TYPE_DECIMAL,
            '12,4',
            ['default' => '0.0000'],
            'Bid Price'
        )->setComment(
            'Bid Price Table'
        );
        $setup->getConnection()->createTable($table);
 
        $setup->endSetup();
}
}