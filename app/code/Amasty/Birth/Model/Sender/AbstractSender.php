<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2018 Amasty (https://www.amasty.com)
 * @package Amasty_Birth
 */

namespace Amasty\Birth\Model\Sender;

/**
 * Class AbstractSender
 *
 * @package Amasty\Birth\Model\Sender
 */
class AbstractSender
{
    /**
     * @var \Amasty\Birth\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Amasty\Birth\Model\ResourceModel\Log\CollectionFactory
     */
    protected $logCollectionFactory;

    /**
     * @var \Amasty\Birth\Model\LogFactory
     */
    protected $logFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * AbstractSender constructor.
     *
     * @param \Amasty\Birth\Helper\Data $helper
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $collectionFactory
     * @param \Amasty\Birth\Model\ResourceModel\Log\CollectionFactory $logCollectionFactory
     * @param \Amasty\Birth\Model\LogFactory $logFactory
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Customer\Helper\View $customerHelper
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        \Amasty\Birth\Helper\Data $helper,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $collectionFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Amasty\Birth\Model\ResourceModel\Log\CollectionFactory $logCollectionFactory,
        \Amasty\Birth\Model\LogFactory $logFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->helper = $helper;
        $this->objectManager = $objectManager;
        $this->collectionFactory = $collectionFactory;
        $this->logCollectionFactory = $logCollectionFactory;
        $this->logFactory = $logFactory;
        $this->date = $date;
        $this->transportBuilder = $transportBuilder;
        $this->messageManager = $messageManager;
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
        $this->customerFactory = $customerFactory;
    }


    /**
     * @return \Magento\Customer\Model\ResourceModel\Customer\Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _getCollection()
    {
        /** @var \Magento\Customer\Model\ResourceModel\Customer\Collection */
        $collection = $this->collectionFactory->create()
            ->addNameToSelect()
            ->addAttributeToSelect('email')
            ->setPageSize(300)
            ->setCurPage(1);

        return $collection;
    }

    /**
     * @param \Magento\Customer\Model\Customer $customer
     * @param $type
     */
    protected function _emailToCustomer(\Magento\Customer\Model\Customer $customer, $type)
    {
        if (!$this->helper->getModuleConfig($type . '/enabled', $customer->getStoreId())) {
            return;
        }

        $groupId = $customer->getGroupId();
        $groups = $this->helper->getModuleConfig(
            $type . '/customer_group',
            $customer->getStoreId()
        );
        if (count($groups)) {
            $groups = explode(',', $groups);
            if (!in_array($groupId, $groups)) {
                return;
            }
        }

        /** @var \Amasty\Birth\Model\ResourceModel\Log\Collection $logCollection */
        $logCollection = $this->logCollectionFactory->create()
            ->addFieldToFilter('type', $type)
            ->addFieldToFilter('customer_id', $customer->getId());

        if (in_array($type, ['birth', 'wishlist', 'activity'])) {
            $logCollection->addFieldToFilter('y', $this->date->date('Y'));
        }

        if ($logCollection->getSize() > 0) {
            return;
        }

        $this->_sendMailToCustomer($customer, $type);

        $logModel = $this->logFactory->create()
            ->setY($this->date->date('Y'))
            ->setType($type)
            ->setCustomerId($customer->getId())
            ->setSentDate($this->date->date('Y-m-d H:i:s'));

        $logModel->save();
    }

    /**
     * @param \Magento\Customer\Model\Customer $customer
     * @param $mailType
     */
    protected function _sendMailToCustomer(\Magento\Customer\Model\Customer $customer, $mailType)
    {
        try {
            $storeId = $customer->getStoreId();
            $store = $customer->getStore();
            $templateId = $this->helper->getModuleConfig($mailType . '/template', $storeId);
            $data = [
                'website_name' => $store->getWebsite()->getName(),
                'group_name' => $store->getGroup()->getName(),
                'store_name' => $store->getName(),
                'coupon' => $this->helper->generateCoupon($mailType, $store, $customer->getEmail()),
                'coupon_days' => $this->helper->getModuleConfig($mailType . '/coupon_days', $storeId),
                'customer_name' => $customer->getName(),
            ];
            if ($mailType === "regbirth") {
                $year = $this->date->date('y', $this->date->date()) - $this->date->date(
                        'y',
                        $this->date->timestamp($customer->getData('created_at'))
                    );
                $data['years_from_reg'] = $year;
            }

            $transport = $this->transportBuilder->setTemplateIdentifier(
                $templateId
            )->setTemplateOptions(
                ['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $storeId]
            )->setTemplateVars(
                $data
            )->setFrom(
                $this->helper->getModuleConfig('general/identity', $storeId)
            )->addTo(
                $customer->getEmail(),
                $customer->getName()
            )->getTransport();

            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Can\'t send customer email'));
        }
    }
}
