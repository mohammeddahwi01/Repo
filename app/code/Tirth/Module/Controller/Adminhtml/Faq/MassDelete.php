<?php

namespace Tirth\Module\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Tirth\Module\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class MassDelete  extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    protected $post;
    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, 
        \Tirth\Module\Model\Post $post)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->post = $post;
        parent::__construct($context);
    }
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {


        $data= $this->getRequest()->getParams('id');
        
    $totalId=count($data['selected']);

        $post = $this->post;    
        for ($i=0; $i <$totalId ; $i++) { 
            $idd = $data['selected'][$i];
            $post->load($idd);
            $post->delete();
        }
        
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.',$totalId));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}