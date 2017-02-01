<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper  
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    
    /** @var Magento\Framework\App\DeploymentConfig */
    protected $deploymentConfig;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context,
                                \Magento\Framework\ObjectManagerInterface $objectManager,
                                \Magento\Framework\App\DeploymentConfig $deploymentConfig
    ) {
        parent::__construct($context);
        $this->_objectManager = $objectManager;
        $this->deploymentConfig = $deploymentConfig;
    }
    /**
     * Get Redis client
     *
     * @param  string $host
     * @param  string $port
     * @param  string $pass
     * @param  string $db
     *
     * @return Litmus7\Merc\Model\Backend\Redis\Cm
     */
     
    public function getRedisInstance()
    {
         if (class_exists('Cm_Cache_Backend_Redis')) {
            return $this->_objectManager->create('Litmus7\Merc\Model\Backend\Redis\Cm');
        }
        
    }
    
    public function generalStats($data){
         
         $redis = $this->getRedisInstance();
         
        switch($data){
           
            case "CPU":
                $Stats = $redis->getRedis()->info($data);
                return $Stats;
                break;
            case "Memory":
                $Stats = $redis->getRedis()->info($data);
                return $Stats;
                break;
            case "Clients":
                $Stats = $redis->getRedis()->info($data);
                return $Stats;
                break;
            case "Replication":
                $Stats = $redis->getRedis()->info($data);
                return $Stats;
                break;
            case "Persistence":
                $Stats = $redis->getRedis()->info($data);
                return $Stats;
                break;
            case "Stats":
                $Stats = $redis->getRedis()->info($data);
                return $Stats;
                break;
            case "Server":
                $Stats = $redis->getRedis()->info($data);
                return $Stats;
                break;
        }
    }
    
    public function config(){
        $modelObj               = $this->deploymentConfig->getConfigData();
        $modelData              = $modelObj['cache']['frontend']['default']['backend_options'];
        $options                = array(
                                    'server'                => $modelData['server'],
                                    'port'                  => $modelData['port'],
                                    'timeout'               => $modelData['read_timeout'],
                                    'compress_threshold'    => $modelData['compress_threshold'],
                                    'compression_lib'       => $modelData['compression_lib']
                                );
        return $options;
                                
    }
}
