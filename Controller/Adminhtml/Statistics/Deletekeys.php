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

class Deletekeys extends \Magento\Backend\App\Action
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

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, data $redis)
    {
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->redis             = $redis;
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
            $collection     = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            $modelObj       = $this->_objectManager->create('Litmus7\Merc\Model\Keys');
            
            foreach ($collection as $item) {
                $key    = $item->getName();
                $redis  = $this->redis->getRedisInstance();
                $redis->getRedis()->del($key);
            }
            
            $this->messageManager->addSuccess(__('A total of %1 keys(s) have been deleted.', $collectionSize));
    
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('merc/statistics/index/source/redis');
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
