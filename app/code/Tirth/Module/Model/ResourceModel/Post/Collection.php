<?php
namespace Tirth\Module\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	


	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Tirth\Module\Model\Post', 'Tirth\Module\Model\ResourceModel\Post');
		//$this->_init('Tirth\Module\Model\Form', 'Tirth\Module\Model\ResourceModel\Post');
	}

}
