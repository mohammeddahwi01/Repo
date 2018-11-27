<?php

namespace Tirth\Module\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;

		$installer->startSetup();

		
			if (!$installer->tableExists('tirth_module_faq')) {
				$table = $installer->getConnection()->newTable(
					$installer->getTable('tirth_module_faq')
				)
					->addColumn(
						'faq_id',
						\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
						null,
						[
							'identity' => true,
							'nullable' => false,
							'primary'  => true,
							'unsigned' => true,
						],
						'FAQ ID'
					)
					->addColumn(
						'question',
						\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
						255,
						['nullable => false'],
						'question'
					)
					->addColumn(
						'answer',
						\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
						255,
						[],
						'answer'
					)
					->addColumn(
						'created_at',
        				\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
        				null,
        				['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
        				'Created At'
					)
					->addColumn(
						'status',
						\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
						1,
						[],
						'faq status'
					)
					->setComment('FAQ Table');
				$installer->getConnection()->createTable($table);

				$installer->getConnection()->addIndex(
				$installer->getTable('tirth_module_faq'),
				$setup->getIdxName(
					$installer->getTable('tirth_module_faq'),
					['question', 'answer'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['question', 'answer'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
			}
		

		$installer->endSetup();
	}
}