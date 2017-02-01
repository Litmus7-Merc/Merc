<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Model\Backend\Redis;

class Cm extends \Litmus7\Merc\Helper\Redis
{
    /**
     * Get redis client
     *
     * @return Litmus7\Merc\Model\Backend\Redis\Credis\Client
     */
    public function getRedis()
    {
        return $this->_redis;
    }
}
