<?php
namespace Tirth\Module\Block;
 
use Tirth\Module\Model\Post;
use Magento\Framework\Data\Collection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

       class Faq extends Template
       {
              // protected $_modelextratagsFactory;
               protected $_postFactory;
               protected $helper;
            public function __construct(Context $context, 
                   /* ExtratagsFactory $MainmodelextratagsFactory,*/
                    \Tirth\Module\Model\PostFactory $postFactory, 
                    \Tirth\Module\Helper\HelperData $helper,
                    array $data = [])
                {
                 /*   $this->_modelextratagsFactory = $MainmodelextratagsFactory;*/
                    $this->_postFactory = $postFactory;
                    $this->helper = $helper;
                    parent::__construct($context, $data);
                }
                
           public function getHelperData(){

            $data = $this->helper->getConfig('helloworld/general/display_text');
            return $data;
           }
           public function faqdata()
           {
            
              $MyCollection = $this->_postFactory->create()
                            ->getCollection();
               return $MyCollection;
           }
        }