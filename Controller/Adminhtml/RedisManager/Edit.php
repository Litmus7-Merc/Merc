<?php

namespace Litmus7\Merc\Controller\Adminhtml\RedisManager;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     * @throws \Exception
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id     = $this->getRequest()->getParam('id');
        $model  = $this->_objectManager->create('Litmus7\Merc\Model\Redismanager');
        $registryObject = $this->_objectManager->get('Magento\Framework\Registry');
        // 2. Initial checking
        if ($id) {
            try {
                  $model->load($id);
            } catch(\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        // 3. Set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $registryObject->register('litmus7_redis_configuration', $model);
        
        $this->resultPage = $this->resultPageFactory->create();
        $this->resultPage->setActiveMenu('Litmus7_Merc::redis');
        $this->resultPage->getConfig()->getTitle()->prepend(__('Magento Extension For Redis Cache - Configuration'));
        return $this->resultPage;
    }
    public function _isAllowed()
    {
        return true;
    }
}
