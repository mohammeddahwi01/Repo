<?php
namespace Tirth\Module\Model\ResourceModel\Form;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	


	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{

		$this->_init('Tirth\Module\Model\Form', 'Tirth\Module\Model\ResourceModel\Form');
	}

}
