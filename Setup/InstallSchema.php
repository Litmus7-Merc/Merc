<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Setup;
 
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
 
/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    protected $deploymentConfig;
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
     public function __construct(\Magento\Framework\App\DeploymentConfig $deploymentConfig)
    {
        $this->deploymentConfig = $deploymentConfig;
		
        
    }
    /**
     * @throws \Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        try
        {
            $installer = $setup;
     
            $installer->startSetup();
     
            /*
             * Create table 'litmus7_redis_keys'
             */
     
            $table = $installer->getConnection()->newTable(
                $installer->getTable('litmus7_redis_keys')
                )->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'ID'
                )->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    300,
                    ['nullable' => false],
                    'Key Name'
                )->setComment('Database Table To Store Keys');
            
            $installer->getConnection()->createTable($table);
            
            
            /*
             * Create table 'litmus7_redis_configuration'
             */
     
            $table = $installer->getConnection()->newTable(
                $installer->getTable('litmus7_redis_configuration')
                )->addColumn(
                    'config_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'ID'
                )->addColumn(
                    'server',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Server'
                )->addColumn(
                    'port',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Port'
                )->addColumn(
                    'persistent',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => true],
                    'Persistent'
                )->addColumn(
                    'db',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'DB'
                )->addColumn(
                    'force_standalone',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Force Standalone'
                )->addColumn(
                    'connect_retries',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Connect Retries'
                )->addColumn(
                    'read_timeout',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Read Timeout'
                )->addColumn(
                    'automatic_cleaning_factor',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Automatic Cleaning Factor'
                )->addColumn(
                    'compress_data',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Compress Data'
                )->addColumn(
                    'compress_tags',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Compress Tags'
                )->addColumn(
                    'compress_threshold',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Compress Threshold'
                )->addColumn(
                    'compression_lib',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Compression Lib'
                )->addColumn(
                    'password',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => true],
                    'password'
                )->addColumn(
                    'server_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Server_pagecache'
                )->addColumn(
                    'port_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Port_pagecache'
                )->addColumn(
                    'persistent_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => true],
                    'Persistent_pagecache'
                )->addColumn(
                    'db_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'DB_pagecache'
                )->addColumn(
                    'force_standalone_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Force Standalone_pagecache'
                )->addColumn(
                    'connect_retries_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Connect Retries_pagecache'
                )->addColumn(
                    'read_timeout_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Read Timeout_pagecache'
                )->addColumn(
                    'automatic_cleaning_factor_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Automatic Cleaning Factor_pagecache'
                )->addColumn(
                    'compress_data_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Compress Data_pagecache'
                )->addColumn(
                    'compress_tags_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Compress Tags_pagecache'
                )->addColumn(
                    'compress_threshold_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Compress Threshold_pagecache'
                )->addColumn(
                    'compression_lib_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => false],
                    'Compression Lib_pagecache'
                )->addColumn(
                    'password_pagecache',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable' => true],
                    'password_pagecache'
                )->setComment('Database Table To Store Redis Configuration');
            
            $installer->getConnection()->createTable($table);
            
            
            $modelObj   			= $this->deploymentConfig->getConfigData('cache');
            
            if(!empty($modelObj))
            {   
                $modelObj   			= $this->deploymentConfig->getConfigData();
                $modelData  			= $modelObj['cache']['frontend']['default']['backend_options'];
                $modelData_pagecache     = $modelObj['cache']['frontend']['page_cache']['backend_options'];
                /**
                * Insert Config Data
                */
                $installer->getConnection()->insertForce(
                    $installer->getTable('litmus7_redis_configuration'),
                    ['config_id'                           => 1,
                    'server'                               => $modelData['server'],
                    'port'                                 => $modelData['port'],
                    'persistent'                           => $modelData['persistent'],
                    'db'                                   => $modelData['database'],
                    'force_standalone'                     => $modelData['force_standalone'],
                    'connect_retries' 	            	   => $modelData['connect_retries'],
                    'read_timeout' 			               => $modelData['read_timeout'],
                    'automatic_cleaning_factor'            => $modelData['automatic_cleaning_factor'],
                    'compress_data' 	              	   => $modelData['compress_data'],
                    'compress_tags' 	            	   => $modelData['compress_tags'],
                    'compress_threshold'            	   => $modelData['compress_threshold'],
                    'compression_lib' 	            	   => $modelData['compression_lib'],
                    'password'                             => $modelData['password'],
                    'server_pagecache'                     => $modelData_pagecache['server'],
                    'port_pagecache'                       => $modelData_pagecache['port'],
                    'persistent_pagecache'                 => $modelData_pagecache['persistent'],
                    'db_pagecache'                         => $modelData_pagecache['database'],
                    'force_standalone_pagecache'           => $modelData_pagecache['force_standalone'],
                    'connect_retries_pagecache' 		   => $modelData_pagecache['connect_retries'],
                    'read_timeout_pagecache' 			   => $modelData_pagecache['read_timeout'],
                    'automatic_cleaning_factor_pagecache'  => $modelData_pagecache['automatic_cleaning_factor'],
                    'compress_data_pagecache' 	  	       => $modelData_pagecache['compress_data'],
                    'compress_tags_pagecache' 		       => $modelData_pagecache['compress_tags'],
                    'compress_threshold_pagecache' 	       => $modelData_pagecache['compress_threshold'],
                    'compression_lib_pagecache' 		   => $modelData_pagecache['compression_lib'],
                    'password_pagecache'                   => $modelData_pagecache['password']
                    ]
                 );
            }
         }
        catch(\Exception $e)
        {
            $this->messageManager->addError($e->getMessage());
        }
            $installer->endSetup();
    }
}
