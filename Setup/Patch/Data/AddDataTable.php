<?php

namespace Ced\GShop\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Ced\GShop\Helper\Logger;
use \Magento\Framework\Module\Dir;

if (defined('DS') === false) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Class for Add Data to Tables
 */
class AddDataTable implements DataPatchInterface
{
    /** @var \Ced\GShop\Model\CategoryFactory $categoryFactory */
    private $categoryFactory;

    /** @var \Magento\Framework\Filesystem\DirectoryList $directoryList */
    private $directoryList;

    /** @var \Ced\GShop\Helper\Data $data */
    private $data;

    /** @var \Magento\Framework\ObjectManagerInterface $objectInterface */
    private $_objectManager;

    /** @var ModuleDataSetupInterface $moduleDataSetup */
    private $moduleDataSetup;

    /** @var Logger $logger */
    public $logger;

    /** @var Dir $moduleDir */
    public $moduleDir;

    public function __construct(
        \Ced\GShop\Model\CategoryFactory $categoryFactory,
        \Ced\GShop\Helper\Data $data,
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        ModuleDataSetupInterface $moduleDataSetup,
        Logger $logger,
        Dir $moduleDir
    ) {
          $this->data = $data;
          $this->categoryFactory = $categoryFactory;
          $this->directoryList = $directoryList;
          $this->_objectManager = $objectInterface;
          $this->moduleDataSetup = $moduleDataSetup;
          $this->logger = $logger;
          $this->moduleDir = $moduleDir;
    }   

    public function apply()
    {
        $appPath = $this->directoryList->getRoot();
        // $gxpressPath = $appPath . DS . "app" . DS . "code" . DS . "Ced" . DS . "GShop" . DS . "Setup" . DS . "GXpressJson" . DS;

        $gxpressPath = $this->moduleDir->getDir('Ced_GShop', \Magento\Framework\Module\Dir::MODULE_SETUP_DIR) . DS. 'GXpressJson' . DS;

        $path = $gxpressPath . "gxpress_category.json";
        $categories = $this->data->loadFile($path);
        
        $categories = json_decode(json_encode($categories), true);

        $path1 = $gxpressPath . "gxpress_attribute.json";
        $attributes = $this->data->loadFile($path1);

        try {
            $this->moduleDataSetup->getConnection()->delete($this->moduleDataSetup->getTable('gxpress_category'));
            $this->moduleDataSetup->getConnection()->insertArray(
                $this->moduleDataSetup->getTable('gxpress_category'),
                [
                    'id',
                    'csv_firstlevel_id',
                    'csv_secondlevel_id',
                    'csv_thirdlevel_id',
                    'csv_fourthlevel_id',
                    'csv_fifthlevel_id',
                    'csv_sixthlevel_id',
                    'csv_seventhlevel_id',
                    'name',
                    'path',
                    'level',
                    'magento_cat_id',
                    'gxpress_required_attributes',
                    'gxpress_attributes'
                ],
                is_array($categories) ? $categories : []
            );

            $this->moduleDataSetup->getConnection()->delete($this->moduleDataSetup->getTable('gxpress_attribute'));
            $this->moduleDataSetup->getConnection()->insertArray(
                $this->moduleDataSetup->getTable('gxpress_attribute'),
                [
                    "id",
                    "gxpress_attribute_name",
                    "magento_attribute_code",
                    "gxpress_attribute_doc",
                    "is_mapped",
                    "gxpress_attribute_enum",
                    "gxpress_attribute_level",
                    "gxpress_attribute_type",
                    "gxpress_attribute_depends_on",
                    "default_value"
                ],
                is_array($attributes) ? $attributes : []
            );
        } catch (\Exception $e) {
            $this->logger->addError($e->getMessage());
        }
    }

     public static function getDependencies()
     {
          return [];
     }

     public function getAliases()
     {
          return [];
     }
     
}