<?php
namespace Tirth\Module\Block\Adminhtml\Faq\Edit\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
* Class DeleteButton
*/
class Delete extends Generic implements ButtonProviderInterface
{
/**
* @return array
*/
public function getButtonData()
{
$data = [];
if ($this->getId()) {
$data = [
'label' => __('Delete FAQ'),
'class' => 'delete',
'on_click' => 'deleteConfirm(\''
. __('Are you sure you want to delete this faq ?')
. '\', \'' . $this->getDeleteUrl() . '\')',
'sort_order' => 20,
];
}
return $data;
}

/**
* @return string
*/
public function getDeleteUrl()
{
return $this->getUrl('*/*/delete', ['faq_id' => $this->getId()]);
}
}