<?php
namespace Tirth\Module\Observer;

use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteRepository;

class ProductAddToCart implements ObserverInterface
{
    public function __construct(
        Session $session,
        QuoteRepository $quoteRepository
    )
    {
        $this->session = $session;
        $this->quoteRepository = $quoteRepository;
    }

    public function execute(Observer $observer)
    {			

    	// echo "tirth";die(); 

        $quoteId = $this->session->getQuote()->getId();
        //echo $quoteId;die();  
        if ($quoteId) {
            $quote = $this->quoteRepository->get($quoteId);
            if (!$quote->getIsActive()) {
                return;
            }

        $product = $observer->getEvent()->getDataByKey('add_data');
        $name =$product->getName();
        $email =$product->getEmail();
        $telephone= $product->getPhone();
        $comment=$product->getComment();

        // echo $telephone;die();

        // echo "string";die();
        //print_r($product);die();

       // print_r($product);die();
        /** @var \Magento\Quote\Model\Quote\Item $item */
        $item = $this->session->getQuote()->getItemByProduct($product);
        //print_r($item);die();
      //  $itemId = $quoteId;
        // echo $itemId;die();
      //  $quoteItem = $quote->getItemById($itemId);
        // Prepare your custom field value here
        $quote->setRfname($name);
        $quote->setRfemail($email);
        $quote->setRftelephone($telephone);
        $quote->setRfcomment($comment);
         // Set custom field value
        // print_r($quoteItem);die();
        // $quoteItem->setRfemail($email);
        
        $quote->save();

       // echo $quote->getRfname();die();
          
        }
        return $this;
    }
}