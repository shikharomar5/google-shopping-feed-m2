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
 * @license      http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\GShop\Controller\Adminhtml\Product;

use Ced\GShop\Helper\Logger;

/**
 * Class Refresh
 * @package Ced\GShop\Controller\Adminhtml\Product
 */
class Refresh extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Ced_GShop::GXpress';

    /** @var \Ced\GShop\Model\ResourceModel\Profile\CollectionFactory $profileCollection */
    public $profileCollection;

    /** @var \Ced\GShop\Helper\Profile */
    protected $profileHelper;

    /** @var Logger \Ced\GShop\Helper\Logger */
    public $logger;

    public $filter;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Ced\GShop\Model\ResourceModel\Profile\CollectionFactory $profile,
        \Ced\GShop\Helper\Profile $profileHelper,
        \Ced\GShop\Helper\Logger $logger
    )
    {
        parent::__construct($context);
        $this->profileCollection = $profile;
        $this->filter = $filter;
        $this->profileHelper = $profileHelper;
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->getRequest()->setParam('is_query_used', true);
        $collection = $this->profileCollection->create();
        $profileIds = $collection->getAllIds();
        if (!empty($profileIds)) {
            try {
                $updatedProfile = [];
                $profileColl = $this->profileCollection->create()
                    ->addFieldToFilter('id', ['in' => $profileIds]);
                foreach ($profileColl as $profile) {
                    $assigned = $this->profileHelper->assignProductsByGoogleCategoryId($profile);
                    if ($assigned) {
                        $updatedProfile[] = $profile->getId();
                    }
                }
                $this->messageManager->addSuccessMessage(__('Total of %1 profile(s) have been updated.', count($updatedProfile)));
            } catch (\Exception $e) {
                $this->logger->addError('In Mass Assign Products Profile: ' . $e->getMessage(), ['path' => __METHOD__]);
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
