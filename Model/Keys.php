<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Model;

use Magento\Framework\Exception\DepartmentException;

/**
 * Redis Dashboard Keys model
 */
class Keys extends \Magento\Framework\Model\AbstractModel
{
	
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\Db $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Litmus7\Merc\Model\ResourceModel\Keys');
    }

	public function clearRedischacheTemp()
	{
		$obj = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
		$connection = $obj->getConnection();
		$connection->truncateTable('litmus7_redis_keys');
	}
	
	public function deletekey($keyId)
	{
		$obj = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
		$connection = $obj->getConnection();
		$connection->delete('litmus7_redis_keys', ["id = $keyId"]);
	}
}
