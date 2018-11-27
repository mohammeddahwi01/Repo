<?php
namespace Tirth\Module\Block;
 
use Tirth\Module\Model\Post;
use Magento\Framework\Data\Collection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Block\Product\ListProduct;

   class Request extends \Magento\Framework\View\Element\Html\Link
{
/**
* Render block HTML.
*
* @return string
*/
protected function _toHtml()
    {
     if (false != $this->getTemplate()) {
     return parent::_toHtml();
     }
     return '<li><a ' . $this->getLinkAttributes() . ' >' . $this->escapeHtml($this->getLabel()) . '</a></li>';
    }
   
 public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Block\Product\ListProduct $listProductBlock,
        array $data = []
    )
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->listProductBlock = $listProductBlock; 
        parent::__construct($context, $data);
       }

    
    public function getFormAction()
    {
            

        return 'module/index/request';
       
    }
    public function getProductCollection()
{
    $collection = $this->_productCollectionFactory->create();
   
    // print_r(get_class_methods($collection));exit();
    $collection->addAttributeToSelect('*');
    $collection->setPageSize(5); // fetching only 3 products
    //$collection->addCategoriesFilter(['eq' => 9]);
    //$collection->setOrder('created_at','desc');
    return $collection;
}
}