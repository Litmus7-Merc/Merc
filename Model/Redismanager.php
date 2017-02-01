<?php
/**
 * Copyright © 2016 Litmus7. All rights reserved.
 */

namespace Litmus7\Merc\Model;

use Magento\Framework\Exception\DepartmentException;
use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\App\DeploymentConfig\Writer;
use Magento\Framework\Config\File\ConfigFilePool;

/**
 * Redis Dashboard Redismanager model
 */
class Redismanager extends \Magento\Framework\Model\AbstractModel
{
    /**
	 * Deployment configuration
	 *
	 * @var DeploymentConfig
	 */
	private $config;

	/**
	 * Deployment configuration storage writer
	 *
	 * @var Writer
	 */
	private $writer;
	
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\Db $resourceCollection
     * @param \Magento\Framework\App\DeploymentConfig $config
     * @param \Magento\Framework\App\DeploymentConfig\Writer $writer
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\DeploymentConfig $config, 
		\Magento\Framework\App\DeploymentConfig\Writer $writer,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->config = $config;
        $this->writer = $writer;
    }

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Litmus7\Merc\Model\ResourceModel\Redismanager');
    }
    
    public function setRedisConfig($server,$server_pagecache, $port,$port_pagecache, $persistent,$persistent_pagecache, $db,$db_pagecache, $force_standalone,                               $force_standalone_pagecache, $connect_retries,$connect_retries_pagecache, $read_timeout,$read_timeout_pagecache,
                                   $automatic_cleaning_factor,$automatic_cleaning_factor_pagecache, $compress_data,$compress_data_pagecache, $compress_tags,$compress_tags_pagecache,$compress_threshold,$compress_threshold_pagecache, $compression_lib,$compression_lib_pagecache, $password,$password_pagecache)
	{
		$configData 	= $this->config->getConfigData('cache');
		$newElement 	= $configData['frontend']['default']['backend_options'];
		$configArray 	= array (
						'frontend' => 
							array (
								'default' => 
									array (
										'backend' => 'Cm_Cache_Backend_Redis',
										'backend_options' => 
											array (
											  'server' => $server,
											  'port' => $port,
											  'persistent' => $persistent,
											  'database' => $db,
											  'force_standalone' => $force_standalone,
											  'connect_retries' => $connect_retries,
											  'read_timeout' => $read_timeout,
											  'automatic_cleaning_factor' => $automatic_cleaning_factor,
											  'compress_data' => $compress_data,
											  'compress_tags' => $compress_tags,
											  'compress_threshold' => $compress_threshold,
											  'compression_lib' => $compression_lib,
											  'password' => $password,
											),
									),
								'page_cache' => 
									array (
										'backend' => 'Cm_Cache_Backend_Redis',
										'backend_options' => 
											array (
											  'server' => $server_pagecache,
											  'port' => $port_pagecache,
											  'persistent' => $persistent_pagecache,
											  'database' => $db_pagecache,
											  'force_standalone' => $force_standalone_pagecache,
											  'connect_retries' => $connect_retries_pagecache,
											  'read_timeout' => $read_timeout_pagecache,
											  'automatic_cleaning_factor' => $automatic_cleaning_factor_pagecache,
											  'compress_data' => $compress_data_pagecache,
											  'compress_tags' => $compress_tags_pagecache,
											  'compress_threshold' => $compress_threshold_pagecache,
											  'compression_lib' => $compression_lib_pagecache,
											  'password' => $password_pagecache,
											),
									),
							),
						);
		$this->writer->saveConfig([ConfigFilePool::APP_ENV => ['cache' => $configArray]]);
	}
	
}