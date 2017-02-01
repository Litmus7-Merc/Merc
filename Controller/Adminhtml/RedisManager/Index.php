<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Controller\Adminhtml\RedisManager;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Litmus7\Merc\Helper\Data as data;

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

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        data $redis
    ) {
        parent::__construct($context);
        $this->redis             = $redis;
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     * @throws \Exception
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage
         */
        try {
            $source = $this->getRequest()->getParam('source');  
            if ($source=='redis') {
                $redis      = $this->redis->getRedisInstance();
                $modelObj   = $this->_objectManager->create('Litmus7\Merc\Model\Keys');
                $modelObj->clearRedischacheTemp();
                $keys       = $redis->getRedis()->keys('*');
                                
                foreach ($keys as $id => $name) {
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
        $this->resultPage->getConfig()->getTitle()->prepend(__('Magento Extension For Redis Cache-Keys'));
        return $this->resultPage;
    }
    
    /*
     * Check permission via ACL resource
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Litmus7_Merc::redis_configuration');
    }
}
