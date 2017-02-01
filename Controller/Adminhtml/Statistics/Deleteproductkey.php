<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Controller\Adminhtml\Statistics;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Litmus7\Merc\Model\ResourceModel\Keys\CollectionFactory;
use Litmus7\Merc\Helper\Data as data;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;

class Deleteproductkey extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
    * @var data
    */
    protected $redis;
    
    protected $deploymentConfig;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, data $redis, \Magento\Framework\App\DeploymentConfig $deploymentConfig)
    {
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->redis             = $redis;
        $this->deploymentConfig  = $deploymentConfig;
        parent::__construct($context);
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     * @throws \Exception
     */
    public function execute()
    {
        try
        {
            $redisObj       = $this->deploymentConfig->getConfigData('cache');
            if(empty($redisObj)) {
                $this->messageManager->addError(__('Please configure Redis to establish connection to the Redis. '));
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                return $resultRedirect->setPath('merc/redismanager/edit/id/1');
            }
            
            $id             =   $this->getRequest()->getParam('id');
            $sku            =   $this->getRequest()->getParam('sku');
            $sku_ar         =   explode('-', $sku);
            $searchKeyId    =   'CATALOG_PRODUCT_VIEW_ID_' . $id;
            $searchKeySku   =   'CATALOG_PRODUCT_VIEW_SKU_' . $sku_ar[0] . '_' . $sku_ar[1];
            $objectManager  =   \Magento\Framework\App\ObjectManager::getInstance();
            $redisObj       =   $objectManager->create('Litmus7\Merc\Helper\Data');
            $collection     =   array();
            $redis          =   $redisObj->getRedisInstance();
            $collectionArr1 =   $redis->getRedis()->keys("*$searchKeyId");
            $collectionArr2 =   $redis->getRedis()->keys("*$searchKeySku");
            $keys           =   $redis->getRedis()->sMembers($collectionArr1[0]);
            array_push($collection, $collectionArr1[0], $collectionArr2[0]);
            
            if(count($keys)>0) {
                /*************** Deleting Keys **************************/
                foreach($keys as $id => $name) {
                    $key = 'zc:k:'.$name;
                    $redis->getRedis()->del($key);
                }
                
                /***************** Deleting Tags ************************/
                foreach($collection as $id => $name) {
                    $redis->getRedis()->del($name);
                }

                $this->messageManager->addSuccess(__('A total of %1 keys(s) have been deleted.', count($keys)));
            }
            else
                $this->messageManager->addSuccess(__('No Redis keys are found for the selected product.'));
            
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('catalog/product/index');
        }
        catch(\Exception $e)
        {
            $this->messageManager->addError($e->getMessage());
        }
    }
     protected function _isAllowed()
    {
      return true;
    }
}
