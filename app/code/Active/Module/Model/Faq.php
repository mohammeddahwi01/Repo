<?php
namespace Active\Module\Model;

class Faq extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Active\Module\Model\ResourceModel\Faq');
    }
}
?>