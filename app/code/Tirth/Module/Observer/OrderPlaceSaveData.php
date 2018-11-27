<?php
namespace Tirth\Module\Observer;

use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteRepository;
use Tirth\Module\Model\FormFactory;
use Magento\Sales\Model\OrderFactory;

class OrderPlaceSaveData implements ObserverInterface
{

    protected $_formFactory;
    //protected $_orderFactory;

    public function __construct(
        Session $session,
         \Tirth\Module\Model\FormFactory $formFactory,
        // \Magento\Sales\Model\OrderFactory $OrderFactory,
        QuoteRepository $quoteRepository
    )
    {
        $this->session = $session;
         $this->_formFactory = $formFactory;
      //   $this->_orderFactory = $OrderFactory;
        $this->quoteRepository = $quoteRepository;
    }

    public function execute(Observer $observer)
    {			
        // echo "hiii";die();

       $orderId = $observer->getEvent()->getOrderIds();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('\Magento\Sales\Model\Order')->load($orderId[0]);
       $quoteId=$order->getQuoteId();
              // $quoteId=$order->getData();

              // echo "<pre>";
              // print_r($quoteId);
              // die();
        
        if ($quoteId) {
            $quote = $this->quoteRepository->get($quoteId);
            //print_r($quote->getRfname());die();

            $name=$quote->getRfname();

            $email=$quote->getRfemail();
            $telephone=$quote->getRftelephone();
            $comment=$quote->getRfcomment();

            if(!empty($name)){


                $orderData = $objectManager->create('\Magento\Sales\Model\Order')->load($orderId[0]);
                $orderData->addData([
                    "rfname"=>$name,
                    "rfemail"=>$email,
                    "rftelephone"=>$telephone,
                    "rfcomment"=>$comment
                    ]);
                $save=$orderData->save(); 

                $form = $this->_formFactory->create();
                $form->addData([
                    "rfname"=>$name,
                    "rfemail"=>$email,
                    "rftelephone"=>$telephone,
                    "rfcomment"=>$comment
                    ]);
                $savedata=$form->save();

            }

       // 
          
        }
        return $this;
    }
}