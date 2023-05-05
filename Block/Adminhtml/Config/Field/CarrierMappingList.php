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
 * Class CarrierMappingList
 * @package Ced\GShop\Block\Adminhtml\Config\Field
 */
class CarrierMappingList extends \Magento\Framework\View\Element\Html\Select
{
    /**
     * @var
     */
    private $_shippingCarrier;

    /**
     * @var \Ced\GShop\Model\Config\ShippingCarrier
     */
    private $_shipMethod;

    /**
     * CarrierMappingList constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Ced\GShop\Model\Config\ShippingCarrier $shipMethod
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Ced\GShop\Model\Config\ShippingCarrier $shipMethod,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_shipMethod = $shipMethod;
    }


    /**
     * @return array
     */
    protected function _getGXpressCarrier()
    {
        $shipCarriers = [];
        if ($this->_shippingCarrier === null) {
            $this->_shippingCarrier = $this->_shipMethod->toOptionArray();
        }
        return $this->_shippingCarrier;
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
            foreach ($this->_getGXpressCarrier() as $method) {
                $this->addOption($method['value'], addslashes($method['label']));
            }
        }
        return parent::_toHtml();
    }
}
