<?php

namespace Tirth\Module\Controller\Index;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Quote\Model\QuoteRepository;
use Magento\Catalog\Model\ResourceModel\Product\Collection;



class Request extends \Magento\Framework\App\Action\Action
{    

    protected $formKey;
protected $_productFactory;
protected $_cart;
protected $messageManager;
protected $collectionFactory;
public function __construct(
    Context $context,
    \Magento\Framework\Data\Form\FormKey $formKey,
    \Magento\Framework\Message\ManagerInterface $managerInterface,
    \Magento\Catalog\Model\ProductFactory $productFactory,
    \Magento\Catalog\Model\ResourceModel\Product\Collection $collectionFactory,
    \Magento\Checkout\Model\Cart $cart,
    Session $session,
        QuoteRepository $quoteRepository
) {
    parent::__construct($context);
    $this->formKey = $formKey;
    $this->_productFactory = $productFactory;
    $this->collectionFactory = $collectionFactory;
    $this->_cart = $cart;
    $this->messageManager = $managerInterface;
    $this->session = $session;
        $this->quoteRepository = $quoteRepository;
} //construct



   public function execute()
    {
       
        $post = (array) $this->getRequest()->getPost();

        if (!empty($post)) {
           
            $name = $post['name'];
            $email = $post['email'];
            $telephone = $post['phone'];
            $comment = $post['comment'];

            // echo $comment;die();
            // $sku=$post['sku'];
            $pid=$post['chk'];//products
            $price= $post['mrp']; //mrp
        
        // $cp = $this->getCollection();

        // echo "<pre>";
        // print_r($cp->getData());exit();
    // print_r($cart_product);exit();
            if($pid){
                foreach ($pid as $value) {
        $this->addCartProduct($value);

            } //foreach
            $this->_cart->save();
             } //pid
            // $this->messageManager->addSuccess('Shopping cart updated succesfully.');

        //     $data = new \Magento\Framework\DataObject($post);
        // $this->_eventManager->dispatch(
        //     'tirth_module_add_data',
        //      ['add_data' => $data]);

            

            $this->messageManager->addSuccessMessage('success..!!!!');

            
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('module/index/request');

            return $resultRedirect;
       
    } //post
        $this->_view->loadLayout();
        $this->_view->renderLayout();
 }  //execute


public function addCartProduct($productID)
{
    $product = $this->_productFactory->create()->load($productID);

    $info = new \Magento\Framework\DataObject(
        [
            //'form_key' => $this->formKey->getFormKey(),
            'product_id' => $productID,
            // 'price' => $product->setPrice($price),
            // 'qty' => 1,
              //'price' => $price,
            
        ]
    );
    return $this->_cart->addProduct($product, $info);
}


} //class