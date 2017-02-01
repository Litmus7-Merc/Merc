<?php

namespace Litmus7\Merc\Model\ResourceModel\Redismanager;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        /**
         * @var string
         */
        $this->_init('Litmus7\Merc\Model\Redismanager', 'Litmus7\Merc\Model\ResourceModel\Redismanager');
        
    }
}
