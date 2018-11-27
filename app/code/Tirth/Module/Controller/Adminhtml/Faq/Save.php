<?php
namespace Tirth\Module\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $dataPersistor;
    protected $imageUploader;
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;



    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context); 
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        
        $data = $this->getRequest()->getParams();
        //echo "<pre>";print_r($data['logo'][0]['name']);exit;
        echo "<pre>";print_r($data);exit;
        if ($data) {
             $model = $this->_objectManager->create('Tirth\Module\Model\Post');
           // echo $data['logo'][0]['name'];exit;
             //image save
             if (isset($data['logo'][0]['name']) && isset($data['logo'][0]['tmp_name'])) 
            {
                $data['logo'] =$data['logo'][0]['name'];
                $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Tirth\Module\ModuleImageUploader');
                $this->imageUploader->moveFileFromTmp($data['logo']);
            }
            elseif (isset($data['logo'][0]['image']) && !isset($data['logo'][0]['tmp_name'])) 
            {
                $data['logo'] = $data['logo'][0]['image'];
                //echo $data['photo'];
            }
            //echo $data['logo'][0]['name'];exit;
            //echo "<pre>"; print_r($data);exit;
            //save over
            $id = $this->getRequest()->getParam('id');
            $model->load($id);
            $model->setData('question',$data['question'])
                  ->setData('answer',$data['answer'])
                  ->setData('status',$data['status'])
                  ->setData('image',$data['logo']);
            
            try {
                $model->save();
                $this->messageManager->addSuccess(__('The FAQ Has been Saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }
                $this->_redirect('*/*/index');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __($e->getMessage()));
            }
            return;
        }
        $this->_redirect('*/*/');
    }
}