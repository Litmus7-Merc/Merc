<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Controller\Adminhtml\Statistics;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Litmus7\Merc\Model\Backend\Redis\Credis\Client as client;

class Statistics extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    
    protected $deploymentConfig;
    
    
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig

    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->deploymentConfig = $deploymentConfig;
    }
    /**
     * Statistics action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $modelObj               = $this->deploymentConfig->getConfigData('cache');
        if(empty($modelObj)){
            $this->messageManager->addError(__('Please Provide Redis Configuration. '));
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
                    $this->messageManager->addException($e, __('Please Provide a valid redis configuration.'));
                    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                    return $resultRedirect->setPath('merc/redismanager/edit/id/1');
                }
            
            //die("68 contrlr stat");
            
            
        $this->resultPage = $this->resultPageFactory->create();
        $this->resultPage->setActiveMenu('Litmus7_Merc::redis');
        $this->resultPage->getConfig()->getTitle()->prepend(__('Magento Extension For Redis Cache - Statistics'));
        
        
        $modelObj   = $this->_objectManager->create('Litmus7\Merc\Model\Config');
        $modelObj->setRedisConfig();
        
        
        return $this->resultPage;       
    }
    
    /*
     * Check permission via ACL resource
     */
    protected function _isAllowed()
    {
        return true;
    }
}
