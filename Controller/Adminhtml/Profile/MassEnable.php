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
 * @category  Ced
  * @package  Ced_GShop
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CedCommerce (http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\GShop\Controller\Adminhtml\Profile;

use Ced\GShop\Model\Data;

/**
 * Class MassEnable
 * @package Ced\GShop\Controller\Adminhtml\Profile
 */
class MassEnable extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Ced_GShop::GXpress';

    public function execute()
    {
        $pIds = $this->getRequest()->getParam('selected');
        $excluded = $this->getRequest()->getParam('excluded', false);
        if (!is_array($pIds) && !$excluded) {
            $this->messageManager->addErrorMessage(__('Please select Profile(s).'));
        } else if ($excluded == "false") {
            $pIds = $this->_objectManager->create('Ced\GShop\Model\Profile')->getCollection()->getAllIds();
        }


        if (!empty($pIds)) {
            try {
                foreach ($pIds as $profileId) {
                    $profile = $this->_objectManager->create('Ced\GShop\Model\Profile')->load($profileId);
                    $profile->setProfileStatus(1);
                    $profile->getResource()->save($profile);
                }
                $this->messageManager->addSuccessMessage(__('Total of %1 record(s) have been enabled.', count($pIds)));
            } catch (\Exception $e) {
                $this->_objectManager->create('Ced\GShop\Helper\Logger')->addError('In Mass Enable Profile: ' . $e->getMessage(), ['path' => __METHOD__]);
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}