<?php
namespace Tirth\Module\Block;
 
// //use Tirth\Module\Model\Post;
// use Magento\Framework\Data\Collection;
 use Magento\Framework\View\Element\Template;
// use Magento\Framework\View\Element\Template\Context;

class Allorders extends Template{
     
      public function __construct(
    \Magento\Backend\Block\Template\Context $context,        
     \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
    array $data = [])
{    
   $this->_orderCollectionFactory = $orderCollectionFactory;  
    parent::__construct($context, $data);
}

 public function getOrderCollection()
{
    $collection = $this->_orderCollectionFactory->create();
    $collection->addAttributeToSelect('*');
    //$collection->setPageSize(3); // fetching only 3 products
    return $collection;
}
}