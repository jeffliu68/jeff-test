<?php

namespace Jeff\Test\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Install attributes
 */
class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    /**
     * @var \Magento\Catalog\Setup\CategorySetupFactory
     */
    protected $categorySetupFactory;

    /**
     * Init
     *
     * @param \Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory
     */
    public function __construct(
        \Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory
    ) {
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Catalog\Setup\CategorySetup $categorySetup */
        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);

        $setup->startSetup();

        $categorySetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'bid_sell_price',
            [
                'type'                  => 'decimal',
                'label'                 => 'Bid Sell Price',
                'input'                 => 'price',
                'backend'                => 'Magento\Catalog\Model\Product\Attribute\Backend\Price',
                'sort_order'            => 100,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'                 => 'Bid', // If this does not exist, a new group will be created.
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => true,
                'is_filterable_in_grid' => true,
                'used_for_promo_rules'  => false,
                'required'              => false
            ]
        )->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'bid_from_date',
            [
                'type'                  => 'datetime',
                'label'                 => 'Bid Start Date',
                'input'                 => 'date',
                'backend'               => 'Magento\Catalog\Model\Attribute\Backend\Startdate',
                'required'              => false,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'                 => 'Bid',
                'visible'               => true,
                'required'              => false,
                'user_defined'          => true,
                'default'               => '',
                'searchable'            => true,
                'filterable'            => true,
                'filterable_in_search'  => true,
                'visible_in_advanced_search' => true,
                'comparable'            => false,
                'visible_on_front'      => false,
                'used_in_product_listing' => true,
                'unique'                => false
            ]
        )->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'bid_to_date',
            [
                'type'                  => 'datetime',
                'label'                 => 'Bid End Date',
                'input'                 => 'date',
                'backend'               => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
                'required'              => false,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'                 => 'Bid',
                'visible'               => true,
                'required'              => false,
                'user_defined'          => true,
                'default'               => '',
                'searchable'            => true,
                'filterable'            => true,
                'filterable_in_search'  => true,
                'visible_in_advanced_search' => true,
                'comparable'            => false,
                'visible_on_front'      => false,
                'used_in_product_listing' => true,
                'unique'                => false
            ]
        );

        $setup->endSetup();
    }
}