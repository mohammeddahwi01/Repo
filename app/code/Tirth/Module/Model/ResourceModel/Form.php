<?php
namespace Tirth\Module\Model\ResourceModel;


class Form extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{

		$this->_init('request_form_table', 'rf_id');
	}
	
}