<?php
namespace Active\Soft\Model;

class Faq extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Active\Soft\Model\ResourceModel\Faq');
    }
}
?>