<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare (strict_types = 1);

namespace Ced\GShop\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class CreateAttr for Create Custom Product Attribute using Data Patch.
 */
class CreateAttr implements DataPatchInterface {

    /**
     * ModuleDataSetupInterface
     *
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * EavSetupFactory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory          $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply() {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            'catalog_product',
            'google_profile_id',
            [
                'group' => 'Google',
                'note' => 'Google Profile Id ',
                'input' => 'text',
                'type' => 'varchar',
                'label' => 'Google Profile Id',
                'backend' => '',
                'visible' => 0,
                'required' => 0,
                'sort_order' => 5,
                'user_defined' => 0,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'is_configurable' => false,
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'google_condition',
            [
                'group' => 'Google',
                'note' => 'Google Condition',
                'input' => 'select',
                'type' => 'varchar',
                'label' => 'Google Condition',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 5,
                'user_defined' => 1,
                'source' => 'Ced\GShop\Model\Source\Productcondition',
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'is_configurable' => false
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'google_product_validation',
            [
                'group' => 'Google',
                'note' => 'Google Validation',
                'input' => 'hidden',
                'type' => 'text',
                'label' => 'Google Validation',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 5,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'google_product_status',
            [
                'group' => 'Google',
                'note' => 'Google Status',
                'input' => 'text',
                'type' => 'text',
                'label' => 'Google Status',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 5,
                'user_defined' => 1,
                'source' => 'Ced\GShop\Model\Source\Productstatus',
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            ]
        );

        $eavSetup->addAttribute('catalog_product', 'google_product_expires', [
            'group' => 'Google',
            'note' => ' Product Expire date on Google express',
            'input' => 'text',
            'type' => 'varchar',
            'label' => 'Product Expire on',
            'backend' => '',
            'visible' => 1,
            'required' => 0,
            'sort_order' => 3,
            'user_defined' => 1,
            'comparable' => 0,
            'visible_on_front' => 0,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL
        ]);

        $eavSetup->addAttribute('catalog_product', 'google_category_id', [
            'group' => 'Google',
            'note' => 'Google Category Id',
            'input' => 'text',
            'type' => 'varchar',
            'label' => 'Google Category Id',
            'backend' => '',
            'visible' => 1,
            'required' => 0,
            'sort_order' => 3,
            'user_defined' => 1,
            'comparable' => 0,
            'visible_on_front' => 0,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL
        ]);

        $eavSetup->addAttribute('catalog_product', 'google_status', [
            'group' => 'Google',
            'note' => 'Google Status',
            'input' => 'boolean',
            'type' => 'text',
            'label' => 'Google Status',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Table',
            'backend' => '',
            'visible' => 1,
            'required' => 0,
            'sort_order' => 3,
            'default' => 'Yes',
            'user_defined' => 1,
            'comparable' => 0,
            'visible_on_front' => 0,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'option' => ['values' => ['Yes', 'No']]
        ]);

        $eavSetup->addAttribute(
            'catalog_product',
            'google_multipack',
            [
                'group' => 'Google',
                'note' => 'Multipack Quantity',
                'input' => 'text',
                'type' => 'int',
                'label' => 'Multipack Quantity',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'google_is_bundle',
            [
                'group' => 'Google',
                'note' => 'Is Bundle',
                'input' => 'boolean',
                'type' => 'text',
                'label' => 'Is Bundle',
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Table',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'default' => 'Yes',
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'option' => ['values' => ['Yes', 'No']]
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'adwords_tp_name',
            [
                'group' => 'Adwords',
                'note' => 'Adwords Title',
                'input' => 'text',
                'type' => 'varchar',
                'label' => 'Adwords Title',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'frontend_class' => 'validate-length maximum-length-150',
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'adwords_tp_description',
            [
                'group' => 'Adwords',
                'note' => 'Adwords Description',
                'input' => 'textarea',
                'type' => 'text',
                'label' => 'Adwords Description',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'frontend_class' => 'validate-length maximum-length-5000',
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'adwords_tp_price',
            [
                'group' => 'Adwords',
                'note' => 'Adwords Price',
                'input' => 'price',
                'type' => 'decimal',
                'label' => 'Adwords Price',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'adwords_tp_sale_price',
            [
                'group' => 'Adwords',
                'note' => 'Adwords Sale Price',
                'input' => 'price',
                'type' => 'decimal',
                'label' => 'Adwords Sale Price',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'adwords_tp_sale_price_effective_date',
            [
                'group' => 'Adwords',
                'note' => 'Adwords Sale Price Effective Date',
                'input' => 'date',
                'type' => 'datetime',
                'label' => 'Adwords Sale Price Effective Date',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'adwords_tp_product_type',
            [
                'group' => 'Adwords',
                'note' => 'Adwords Product Type',
                'input' => 'text',
                'type' => 'varchar',
                'label' => 'Adwords Product Type',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'adwords_tp_condition',
            [
                'group' => 'Adwords',
                'note' => 'Adwords Item Condition',
                'input' => 'select',
                'type' => 'text',
                'label' => 'Adwords Item Condition',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'default' => 'new',
                'option' => ['values' => [
                    '' => '--select condition--',
                    'new' => 'new',
                    'refurbished' => 'refurbished',
                    'used' => 'used'
                ]]
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'adwords_tp_status',
            [
                'group' => 'Adwords',
                'note' => 'Adwords Status',
                'input' => 'boolean',
                'type' => 'int',
                'label' => 'Adwords Status',
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'default' => 1,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            'catalog_product',
            'adwords_tp_buffer_quantity',
            [
                'group' => 'Adwords',
                'note' => 'Adwords Buffer Quantity',
                'input' => 'text',
                'type' => 'varchar',
                'label' => 'Adwords Buffer Quantity',
                'backend' => '',
                'visible' => 1,
                'required' => 0,
                'sort_order' => 3,
                'user_defined' => 1,
                'comparable' => 0,
                'visible_on_front' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'frontend_class' => 'validate-length maximum-length-150',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies() {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases() {
        return [];
    }
}