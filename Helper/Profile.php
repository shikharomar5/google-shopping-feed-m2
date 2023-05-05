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
 * @package   Ced_GShop
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CedCommerce (http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\GShop\Helper;

use Magento\Framework\App\Helper\Context;

class Profile extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Ced\GShop\Helper\MultiAccount
     */
    protected $multiAccountHelper;

    /** @var Logger \Ced\GShop\Helper\Logger */
    public $logger;

    /**
     * Profile constructor.
     * @param Context $context
     * @param MultiAccount $multiAccountHelper
     * @param Logger $logger
     */
    public function __construct(
        Context $context,
        \Ced\GShop\Helper\MultiAccount $multiAccountHelper,
        \Ced\GShop\Helper\Logger $logger
    )
    {
        parent::__construct($context);
        $this->multiAccountHelper = $multiAccountHelper;
        $this->logger = $logger;
    }

    public function assignProductsByGoogleCategoryId($profile)
    {
        $profileAttr = $this->multiAccountHelper->getProfileAttrForAcc($profile->getAccountId());
        $profileProducts = $this->getGoogleCategoryIdProducts($profile);
        if (is_array($profileProducts) && count($profileProducts) > 0) {
            $profile->updateProducts($profileProducts, $profileAttr, true);
        }
        return true;
    }

    public function getGoogleCategoryIdProducts($profile)
    {
        $profileProducts = [];
        if ($profile->getConditionsSerializedId()) {
            $this->_eventManager->dispatch('integrator_query_save_after', ['data_object' => $profile]);
            $profileProducts = $profile->getProfileProductIds();
        }
        return $profileProducts;
    }
}
