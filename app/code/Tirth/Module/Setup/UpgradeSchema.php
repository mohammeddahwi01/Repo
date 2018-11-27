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





        if(version_compare($context->getVersion(), '1.1.2', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable( 'tirth_module_faq' ),
                'image',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'image colum update',
                    'after' => 'status'
                ]
            );
        }



        if(version_compare($context->getVersion(), '1.1.8', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable( 'quote' ),
                'rfname',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'rf name',
                    'after' => 'delivery_comment'
                ]
            );
        }

        if(version_compare($context->getVersion(), '1.2.2', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable( 'quote' ),
                'rfemail',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'email',
                    'after' => 'rfname'
                ]
            );
        }

        if(version_compare($context->getVersion(), '1.2.3', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable( 'quote' ),
                'rftelephone',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'telephone',
                    'after' => 'rfemail'
                ]
            );
        }

        if(version_compare($context->getVersion(), '1.2.4', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable( 'quote' ),
                'rfcomment',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'comment',
                    'after' => 'rftelephone'
                ]
            );
        }

        if(version_compare($context->getVersion(), '1.2.5', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable( 'sales_order' ),
                'rfname',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'comment',
                    'after' => 'gift_message_id'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable( 'sales_order' ),
                'rfemail',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'comment',
                    'after' => 'gift_message_id'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable( 'sales_order' ),
                'rftelephone',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'comment',
                    'after' => 'gift_message_id'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable( 'sales_order' ),
                'rfcomment',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'comment',
                    'after' => 'gift_message_id'
                ]
            );

        }




        if (version_compare($context->getVersion(), '1.2.6', '<')) {
   
    $table = $installer->getConnection()
        ->newTable($installer->getTable('request_form_table'))
        ->addColumn(
                'rf_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary'  => true,
                            'unsigned' => true,
                        ],
                        'RF ID'

                    )->addColumn(
                        'rfname',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'rfname'

                    )->addColumn(
                        'rfemail',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'rfemail'

                    )->addColumn(
                        'rftelephone',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'rftelephone'

                    )->addColumn(
                        'rfcomment',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'rfcomment'

                    )->setComment('RequestForm Table');

    $installer->getConnection()->createTable($table);
    $installer->getConnection()->addIndex(
                $installer->getTable('request_form_table'),
                $setup->getIdxName(
                    $installer->getTable('request_form_table'),
                    ['rfname','rfemail','rftelephone', 'rfcomment'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['rfname','rfemail','rftelephone', 'rfcomment'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
            }


            if(version_compare($context->getVersion(), '1.2.7', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable( 'sales_order_grid' ),
                'rfname',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'comment',
                    'after' => 'total_refunded'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable( 'sales_order_grid' ),
                'rfemail',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'comment',
                    'after' => 'total_refunded'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable( 'sales_order_grid' ),
                'rftelephone',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'comment',
                    'after' => 'total_refunded'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable( 'sales_order_grid' ),
                'rfcomment',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                    'nullable' => false,
                    'comment' => 'comment',
                    'after' => 'total_refunded'
                ]
            );
            $installer->getConnection()->addIndex(
                $installer->getTable('sales_order_grid'),
                $setup->getIdxName(
                    $installer->getTable('sales_order_grid'),
                    ['rfname','rfemail','rftelephone', 'rfcomment'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['rfname','rfemail','rftelephone', 'rfcomment'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );

        }


        $installer->endSetup();
    }
}
