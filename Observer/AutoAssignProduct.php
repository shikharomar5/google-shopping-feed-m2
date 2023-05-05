<?php

namespace Ced\GShop\Observer;

use Ced\GShop\Model\ResourceModel\Profile\Collection;

class AutoAssignProduct implements \Magento\Framework\Event\ObserverInterface
{
    /** @var \Ced\GShop\Helper\Logger $logger */
    public $logger;

    /** @var Collection */
    public $profileCollection;

    /**
     * @var \Ced\GShop\Helper\MultiAccount
     */
    protected $multiAccountHelper;

    public function __construct(
        Collection $profileCollection,
        \Ced\GShop\Helper\MultiAccount $multiAccountHelper,
        \Ced\GShop\Helper\Logger $logger
    )
    {
        $this->profileCollection = $profileCollection;
        $this->multiAccountHelper = $multiAccountHelper;
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $prodIdsWithCondIds = $observer->getEvent()->getData('product_ids_with_condition_id');
            if ($prodIdsWithCondIds) {
                $prodIdsWithCondIds = array_column(json_decode($prodIdsWithCondIds, true), 'product_ids', 'query_condition_id');
                $profiles = $this->profileCollection->addFieldToFilter('conditions_serialized_id', [
                        'in' => array_keys($prodIdsWithCondIds)
                    ]
                );
                foreach ($profiles as $profile) {
                    $profileAttr = $this->multiAccountHelper->getProfileAttrForAcc($profile->getAccountId());
                    $condSerializedId = $profile->getConditionsSerializedId();
                    $prodIdsToAssign = isset($prodIdsWithCondIds[$condSerializedId]) ? $prodIdsWithCondIds[$condSerializedId] : [];
                    if (is_array($prodIdsToAssign) && count($prodIdsToAssign) > 0) {
                        $profile->updateProducts($prodIdsToAssign, $profileAttr, true);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->error('Auto Assign Product Observer', ['path' => __METHOD__, 'exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }
}
