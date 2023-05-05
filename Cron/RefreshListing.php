<?php


namespace Ced\GShop\Cron;

use \Ced\GShop\Helper\Data;
use \Ced\GShop\Helper\Logger;

class RefreshListing
{
    /** @var \Ced\GShop\Helper\Logger $logger */
    public $logger;

    /** @var \Ced\GShop\Helper\Data $dataHelper */
    public $dataHelper;

    /** @var \Magento\Framework\App\RequestInterface $request */
    public $request;

    /** @var \Ced\GShop\Model\ResourceModel\Profile\CollectionFactory $profileCollection */
    public $profileCollection;

    /** @var \Ced\GShop\Helper\Profile $profileHelper */
    public $profileHelper;

    public function __construct(
        Logger $logger,
        \Ced\GShop\Model\ResourceModel\Profile\CollectionFactory $profile,
        \Ced\GShop\Helper\Profile $profileHelper,
        \Magento\Framework\App\RequestInterface $request,
        Data $dataHelper
    ) {
        $this->logger = $logger;
        $this->profileCollection = $profile;
        $this->profileHelper = $profileHelper;
        $this->dataHelper = $dataHelper;
        $this->request = $request;
    }

    public function execute()
    {
        try {
            $this->request->setParam('is_query_used', true);
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
                } catch (\Exception $e) {
                    $this->logger->addError('In Mass Assign Products Profile: ' . $e->getMessage(), ['path' => __METHOD__]);
                }
            }
        } catch (\Exception $exception) {
            $this->dataHelper->logger(
                "Google Shopping",
                "Refresh listing",
                $exception->getMessage(),
                1,
                1
            );
        } catch (\Error $error) {
            $this->dataHelper->logger(
                "Google Shopping",
                "Refresh listing",
                $error->getMessage(),
                1,
                1
            );
        }

    }
}
