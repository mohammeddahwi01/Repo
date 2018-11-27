<?php

namespace Tirth\Module\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Store\Model\StoreManagerInterface;

class Topmenu
{

    /**
     * @var NodeFactory
     */
    protected $nodeFactory;
    public $_storeManager;
    public $url;
    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\Data\Tree\NodeFactory $nodeFactory
     */
    public function __construct(
        NodeFactory $nodeFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager

    ) {
        $this->nodeFactory = $nodeFactory;
        $this->_storeManager=$storeManager;
        
        
        // print_r($url);die();
    }

    /**
     *
     * Inject node into menu.
     **/
    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $node = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray(),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    /**
     *
     * Build node
     **/
    protected function getNodeAsArray()
    {
       
        
        return [
            'name' => __('Home'),
            'id' => 'home',
            // 'url' => '/magentonew/cms/index/index',
             'url' => $this->getUrl(),
            'has_active' => true,
            'is_active' => false
        ];
    }

    public function getUrl(){
        
        return $this->_storeManager->getStore()->getBaseUrl();
    }
}