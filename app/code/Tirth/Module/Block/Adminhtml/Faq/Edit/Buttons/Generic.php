<?php
namespace Tirth\Module\Block\Adminhtml\Faq\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
/**
 * Class GenericButton
 */
class Generic
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * Return Epp ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->context->getRequest()->getParam('faq_id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}