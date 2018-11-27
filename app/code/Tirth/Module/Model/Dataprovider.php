<?php
namespace Tirth\Module\Model;
 
use Tirth\Module\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
 
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;

    protected $dataPersistor;
    public    $_storeManager;


    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $CollectionFactory
     * @param array $meta
     * @param array $data
     */
    protected $loadedData;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $CollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $CollectionFactory->create();
         $this->dataPersistor = $dataPersistor;
        $this->_storeManager=$storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        
        $items = $this->collection->getItems();
        $this->loadedData = array();

        foreach ($items as $faq) {
            
            $this->loadedData[$faq->getId()] = $faq->getData();
        }

        return $this->loadedData;
    }
}