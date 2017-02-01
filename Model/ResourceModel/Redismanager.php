<?php
/**
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Model\ResourceModel;

/**
 * Redismanager resource
 */
class Redismanager extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('litmus7_redis_configuration', 'config_id');
    }

  
}
