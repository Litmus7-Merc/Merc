<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Controller\Adminhtml\Statistics;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Litmus7\Merc\Helper\Data as data;
use Magento\Framework\Controller\ResultFactory;
use Litmus7\Merc\Model\Backend\Redis\Credis\Client as client;

class Index extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
    * @var data
    */
    protected $redis;
    
    protected $deploymentConfig;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        data $redis,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig
    ) {
        parent::__construct($context);
        $this->redis             = $redis;
        $this->resultPageFactory = $resultPageFactory;
        $this->deploymentConfig = $deploymentConfig;
    }
    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     * @throws \Exception
     */
    public function execute()
    {
        
        $modelObj               = $this->deploymentConfig->getConfigData('cache');
        if(empty($modelObj)){
            $this->messageManager->addError(__('Please provide redis configuration details.'));
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('merc/redismanager/edit/id/1');
        }
        
            $model  = $this->_objectManager->create('Litmus7\Merc\Model\Redismanager');
            $model->load('1');
            $host = $model->getServer();
            $port = $model->getPort();
            $timeout = $model->getRead_timeout();
            $persistent = $model->getPersistent();
            $db = $model->getDb();
            $password = null;
            
            $this->_redis   = new client($host, $port, $timeout, $persistent, $db, $password);
               
               try{
                $this->_redis->connect();
            }catch (\Exception $e) {
                    $this->messageManager->addException($e, __('Please provide valid redis configuration parameters.'));
                    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                    return $resultRedirect->setPath('merc/redismanager/edit/id/1');
                }
        
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        try {
            $source = $this->getRequest()->getParam('source');  
            if($source=='redis'){
                $redis      = $this->redis->getRedisInstance();
                $modelObj   = $this->_objectManager->create('Litmus7\Merc\Model\Keys');
                $modelObj->clearRedischacheTemp();
                $keys       = $redis->getRedis()->keys('*');
                                
                foreach($keys as $id => $name){
                    $dbmodelObj = $this->_objectManager->create('Litmus7\Merc\Model\Keys');
                    $dbmodelObj->setName($name);
                    $dbmodelObj->save();
                }
            }
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        
        $this->resultPage = $this->resultPageFactory->create();
        $this->resultPage->setActiveMenu('Litmus7_Merc::redis');
        $this->resultPage->getConfig()->getTitle()->prepend(__('MERC - Keys'));
        return $this->resultPage;       
    }
    
    /*
     * Check permission via ACL resource
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Litmus7_Merc::redis_configuration');
    }
}
