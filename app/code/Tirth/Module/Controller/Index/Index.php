<?php

namespace Tirth\Module\Controller\Index;
 
use Magento\Framework\App\Action\Context;
// use Tirth\Module\Helper;
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_formFactory;
    protected $_postFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Tirth\Module\Model\PostFactory $postFactory,
        \Tirth\Module\Model\FormFactory $formFactory,
        \Tirth\Module\Helper\HelperData $helper
        )
    {
        $this->_pageFactory = $pageFactory;
        $this->_postFactory = $postFactory;
        $this->_formFactory = $formFactory;
        
        return parent::__construct($context);
    }

    public function execute()
    {    
       

       return $this->_pageFactory->create();
    }
}