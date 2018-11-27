<?php
namespace Tirth\Module\Block;
 

use Tirth\Module\Model\Post;
use Magento\Framework\Data\Collection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Block\Product\ListProduct;

class Allproduct extends Template{
     
      public function __construct(
    \Magento\Backend\Block\Template\Context $context,        
    \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,        
     \Magento\Catalog\Block\Product\ListProduct $listProductBlock,
    array $data = [])
{    
    $this->_productCollectionFactory = $productCollectionFactory;    
    parent::__construct($context, $data);
    $this->listProductBlock = $listProductBlock;
}

 public function getProductCollection()
{
    $collection = $this->_productCollectionFactory->create();
   
    // print_r(get_class_methods($collection));exit();
    $collection->addAttributeToSelect('*');
    $collection->setPageSize(15); // fetching only 3 products
    //$collection->addCategoriesFilter(['eq' => 9]);
    // $collection->setOrder('created_at','desc');
    return $collection;
}
public function getAddToCartUrl($product)
{

    return $this->listProductBlock->getAddToCartUrl($product);

}
}