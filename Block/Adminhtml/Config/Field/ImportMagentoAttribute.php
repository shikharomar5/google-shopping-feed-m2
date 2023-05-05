<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement(EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category  Ced
  * @package  Ced_GShop
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\GShop\Block\Adminhtml\Config\Field;

/**
 * Class GlobalShippingMethodList
 * @package Ced\GShop\Block\Adminhtml\Config\Field
 */
class ImportMagentoAttribute extends \Magento\Framework\View\Element\Html\Select
{
    /**
     * @var
     */
    private $_shippingMethod;
    /**
     * @var \Ced\GShop\Model\Config\InternationalShippingService
     */
    private $_shipMethod;

    private $_attrCollectionFactory;

    /**
     * GlobalShippingMethodList constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Ced\GShop\Model\Config\InternationalShippingService $shipMethod
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $attrCollection,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_attrCollectionFactory = $attrCollection;
    }

    public function getMagentoAttributes()
    {
        $attributes = $this->_attrCollectionFactory->create()->getItems();
        $mattributecode = '--please select--';
        $magentoattributeCodeArray[] = array(
            'value' => '',
            'label' => $mattributecode
        );
        foreach ($attributes as $attribute) {
            $magentoattributeCodeArray[] = array(
                'value' => $attribute->getAttributecode(),
                'label' => $attribute->getFrontendLabel()
            );
        }
        return $magentoattributeCodeArray;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            foreach ($this->getMagentoAttributes() as $method) {
                $this->addOption($method['value'], addslashes($method['label']));
            }
        }
        return parent::_toHtml();
    }
}
