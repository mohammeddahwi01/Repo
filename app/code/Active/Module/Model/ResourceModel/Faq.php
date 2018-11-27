<?php
namespace Active\Module\Model\ResourceModel;

class Faq extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('table', 'id');
    }
}
?>