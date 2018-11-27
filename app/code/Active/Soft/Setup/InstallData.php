<?php

namespace Active\Soft\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
 
/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
 
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
 
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        if (version_compare($context->getVersion(), '1.0.0') < 0){





		$eavSetup -> removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'test_attr_cat');

		
			$eavSetup -> addAttribute(\Magento\Catalog\Model\Category :: ENTITY, 'test_attr_cat', [
                        'type' => 'varchar',
                        'label' => 'category test',
                        'input' => 'text',
						'required' => false,
                        'sort_order' => 110,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                        'group' => 'General Information',
						"default" => "",
						"class"    => "",
						"note"       => ""
			]
			);
					
	
	

				
				$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				$salesSetup = $objectManager->create('Magento\Sales\Setup\SalesSetup');
				
$salesSetup->addAttribute('order', 'order_test', ['type' =>'text']);
				$quoteSetup = $objectManager->create('Magento\Quote\Setup\QuoteSetup');
				
				

		}

    }
}