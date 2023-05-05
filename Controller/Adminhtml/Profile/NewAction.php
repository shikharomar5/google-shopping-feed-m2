<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_GShop
 * @author        CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\GShop\Controller\Adminhtml\Profile;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class NewAction
 * @package Ced\GShop\Controller\Adminhtml\Profile
 */
class NewAction extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Ced_GShop::GXpress';
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Ced\GShop\Helper\MultiAccount
     */
    protected $multiAccountHelper;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfigManager;

    /**
     * NewAction constructor.
     * @param Context $context
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Ced\GShop\Helper\MultiAccount $multiAccountHelper
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->multiAccountHelper = $multiAccountHelper;
        $this->scopeConfigManager = $this->_objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface');
    }

    public function execute()
    {
        $accounts = $this->multiAccountHelper->getAllAccounts();
        //$totalAccounts = $accounts->getSize();
        $accountID = $this->getRequest()->getParam('account_id');

        if(!$accountID) {
            $accountID = $this->scopeConfigManager->getValue('gshop_config/gshop_setting/primary_account');
        }
        /** @var \Ced\GShop\Model\Accounts $account */
        $account = $this->multiAccountHelper->getAccountRegistry($accountID);

        if ($accountID && $accountID != '' && $account->getId()/* || $totalAccounts == 1*/) {
            return $this->resultForwardFactory->create()->forward('edit');
        }
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ced_GShop::GXpress');
        $resultPage->getConfig()->getTitle()->prepend(__('Profiles'));
        $resultPage->getConfig()->getTitle()->prepend(__('Select Account'));
        return $resultPage;
    }
}
