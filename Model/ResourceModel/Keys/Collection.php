<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Model\ResourceModel\Keys;

/**
 * Keys Collection
 *
 */
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
        $this->_init('Litmus7\Merc\Model\Keys', 'Litmus7\Merc\Model\ResourceModel\Keys');
    }
}