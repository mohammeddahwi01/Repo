<?php
namespace Tirth\Module\Model;
 
use Tirth\Module\Model\ResourceModel\Post\CollectionFactory;
 
class DataProvider2 extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $employeeCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $employeeCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $employeeCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }
}