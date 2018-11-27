<?php
namespace Tirth\Module\Model;
class Form extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	 const CACHE_TAG = 'request_form_table';

	 protected $_cacheTag = 'request_form_table';

	 protected $_eventPrefix = 'request_form_table';

	protected function _construct()
	{
		$this->_init('Tirth\Module\Model\ResourceModel\Form');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	 public function getDefaultValues()
	 {
	 	$values = [];
	 	return $values;
	 }
}