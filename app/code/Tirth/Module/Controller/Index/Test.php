<?php

namespace Tirth\Module\Controller\Index;

class Test extends \Magento\Framework\App\Action\Action
{
	public function execute()
	{
		$textDisplay = new \Magento\Framework\DataObject(array('text' => 'Mageplaza'));
		$this->_eventManager->dispatch(
			'tirth_module_display_text',
			 ['mp_text' => $textDisplay]);
		
		echo $textDisplay->getText();
		exit;
	}
}