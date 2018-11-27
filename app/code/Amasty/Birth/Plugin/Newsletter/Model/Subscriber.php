<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2018 Amasty (https://www.amasty.com)
 * @package Amasty_Birth
 */

namespace Amasty\Birth\Plugin\Newsletter\Model;

class Subscriber
{
    /**
     * @var \Amasty\Birth\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory
     */
    protected $ruleCollectionFactory;

    /**
     * Subscriber constructor.
     *
     * @param \Amasty\Birth\Helper\Data $helper
     * @param \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory $ruleCollectionFactory
     */
    public function __construct(
        \Amasty\Birth\Helper\Data $helper,
        \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory $ruleCollectionFactory
    ) {
        $this->helper = $helper;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
    }

    /**
     * @param \Magento\Newsletter\Model\Subscriber $subject
     */
    public function beforeSendConfirmationSuccessEmail(
        \Magento\Newsletter\Model\Subscriber $subject
    ) {
        $email = $subject->getEmail();

        if ($this->helper->getModuleConfig('newsletter/enabled')) {
            $couponName = 'Special Coupon: Newsletter for ' . $email;
            $firstCoupon = true;
            $coupon = "";

            /** @var \Magento\SalesRule\Model\ResourceModel\Rule\Collection $collection */
            $collection = $this->ruleCollectionFactory->create();
            foreach ($collection as $rule) {
                if ($rule->getName() == $couponName) {
                    $firstCoupon = false;
                    $coupon = $rule->getCode();
                }
            }
            if ($firstCoupon) {
                $coupon = $this->helper->generateCoupon('newsletter', null, $email);
            }
            $subject->setCoupon($coupon);
        }
    }
}
