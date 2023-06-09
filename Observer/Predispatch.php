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

namespace Ced\GShop\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
class Predispatch  implements ObserverInterface
{
    protected $_feed;
    protected $_url;
    protected $_backendAuthSession;
    protected $_objectManager;
    protected $_request;
    protected $dataHelper;
    
    public function __construct(
        \Ced\GShop\Model\Feed $_feed,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        \Magento\Backend\Model\Auth\Session $backendAuthSession,
        \Ced\GShop\Helper\Data $helper,
        \Magento\Framework\UrlInterface $urlRedirect,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->_url = $urlRedirect;
        $this->_request = $request;
        $this->_feed = $_feed;
        $this->_backendAuthSession = $backendAuthSession;
        $this->_objectManager = $objectInterface;
        $this->dataHelper = $helper;
    }

    
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($this->_request->getModuleName() != 'gshop') {
            return $this;
        }
        if ($this->_backendAuthSession->isLoggedIn()) {
            $this->_feed->checkUpdate();
            $licenceState = $this->dataHelper->checkForLicence();
        }
        return $this;
    }
}
