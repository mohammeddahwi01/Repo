<?php
namespace Tirth\Module\Model;
class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	 const CACHE_TAG = 'tirth_module_faq';

	 protected $_cacheTag = 'tirth_module_faq';

	 protected $_eventPrefix = 'tirth_module_faq';

	protected function _construct()
	{
		$this->_init('Tirth\Module\Model\ResourceModel\Post');
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