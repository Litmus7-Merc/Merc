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

class Flushkeys extends \Magento\Backend\App\Action
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
     * Flushkeys action
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $redis  = $this->redis->getRedisInstance();
            $keys   = $redis->getRedis()->flushAll();
            $this->messageManager->addSuccess( __('Keys flushed successfully...'));
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('merc/statistics/index/source/redis');
            
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
    }
    
    /*
     * Check permission via ACL resource
     */
    protected function _isAllowed()
    {
        return true;
    }
}
