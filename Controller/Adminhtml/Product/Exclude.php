<?php


namespace Ced\GShop\Controller\Adminhtml\Product;


use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Ui\Component\MassAction\Filter;

class Exclude extends \Magento\Backend\App\Action
{

    /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
    public $collection;

    /** @var \Magento\Catalog\Model\Product\Action $action */
    public $action;

    /** @var Filter $filter */
    public $filter;

    public function __construct(
        Action\Context $context,
        Filter $filter,
        \Magento\Catalog\Model\Product\Action $action
    )
    {
        parent::__construct($context);
        $this->action = $action;
        $this->filter = $filter;
    }

    public function execute()
    {
        try {
            $ids = $this->getRequest()->getParam('selected');
            if (!$ids) {
                $ids = $this->filter->getCollection(
                    $this->_objectManager->create('Magento\Catalog\Model\Product')
                        ->getCollection()
                )->getAllIds();
            }
            $this->action->updateAttributes(
                $ids,
                ['adwords_tp_status' => 0],
                0
            );
            $this->messageManager->addSuccessMessage(_('Products Enabled for Adwords'));

        } catch (\Exception $exception) {
            $this->messageManager
                ->addErrorMessage(_('Products Failed to enable for Adwords'));
        } catch (\Error $error) {
            $this->messageManager
                ->addErrorMessage(_('Products Failed to enable for Adwords'));
        }
        $this->_redirect('*/*/index');
    }
}
