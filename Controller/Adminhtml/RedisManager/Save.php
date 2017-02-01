<?php

namespace Litmus7\Merc\Controller\Adminhtml\RedisManager;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Litmus7\Merc\Helper\Data as data;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Litmus7\Merc\Model\Backend\Redis\Credis\Client as client;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var data
     */
    protected $redis;
    /** @var Litmus7\Merc\Model\Backend\Redis\Credis\Client */
    protected $_redis;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Litmus7\Merc\Model\Backend\Redis\Credis\Client $client
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
     * Save action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $model  = $this->_objectManager->create('Litmus7\Merc\Model\Redismanager');
            
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
            try {
                $model->setServer($data['server']);
                $model->setServer_pagecache($data['server_pagecache']);
                
                $model->setPort($data['port']);
                $model->setPort_pagecache($data['port_pagecache']);
                
                $model->setPersistent($data['persistent']);
                $model->setPersistent_pagecache($data['persistent_pagecache']);
                
                $model->setDb($data['db']);
                $model->setDb_pagecache($data['db_pagecache']);
                
                $model->setForce_standalone($data['force_standalone']);
                $model->setForce_standalone_pagecache($data['force_standalone_pagecache']);
                
                $model->setConnect_retries($data['connect_retries']);
                $model->setConnect_retries_pagecache($data['connect_retries_pagecache']);
                
                $model->setRead_timeout($data['read_timeout']);
                $model->setRead_timeout_pagecache($data['read_timeout_pagecache']);
                
                $model->setAutomatic_cleaning_factor($data['automatic_cleaning_factor']);
                $model->setAutomatic_cleaning_factor_pagecache($data['automatic_cleaning_factor_pagecache']);
                
                $model->setCompress_data($data['compress_data']);
                $model->setCompress_data_pagecache($data['compress_data_pagecache']);
                
                $model->setCompress_tags($data['compress_tags']);
                $model->setCompress_tags_pagecache($data['compress_tags_pagecache']);
                
                $model->setCompress_threshold($data['compress_threshold']);
                $model->setCompress_threshold_pagecache($data['compress_threshold_pagecache']);
                
                $model->setCompression_lib($data['compression_lib']);
                $model->setCompression_lib_pagecache($data['compression_lib_pagecache']);
                
                $model->setPassword($data['password']);
                if (empty($data['password'])){
                    $pass = null;
                }else
                    $pass = $data['password'];
                
                $model->setPassword_pagecache($data['password_pagecache']);
                if (empty($data['password_pagecache'])){
                    $pass = null;
                }else
                    $pass = $data['password_pagecache'];
                $model->save();
                
                
                $this->_redis   = new client($host = $data['server'], $port = $data['port'], $timeout = $data['read_timeout'], $persistent = $data['persistent'], $db = $data['db'], $password = $pass);
               
               try{
                $this->_redis->connect();
            }catch (\Exception $e) {
                    $this->messageManager->addException($e, __('Connection to Redis failed due to cache configuration error.'));
                    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                    return $resultRedirect->setPath('merc/redismanager/edit/id/1');
                }
                
                $this->_redis   = new client($host = $data['server_pagecache'], $port = $data['port_pagecache'], $timeout = $data['read_timeout_pagecache'], $persistent = $data['persistent_pagecache'], $db = $data['db_pagecache'], $password = $pass);
        
            try{
                $this->_redis->connect();
            }catch (\Exception $e) {
                    $this->messageManager->addException($e, __('Connection to Redis failed due to page cache configuration error'));
                    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                    return $resultRedirect->setPath('merc/redismanager/edit/id/1');
                }
                    
                    $model  = $this->_objectManager->create('Litmus7\Merc\Model\Redismanager');
                    $model->setRedisConfig($data['server'],$data['server_pagecache'],$data['port'],$data['port_pagecache'],$data['persistent'],$data['persistent_pagecache'],$data['db'],$data['db_pagecache'],$data['force_standalone'],$data['force_standalone_pagecache'],$data['connect_retries'],$data['connect_retries_pagecache'],$data['read_timeout'],$data['read_timeout_pagecache'],$data['automatic_cleaning_factor'],$data['automatic_cleaning_factor_pagecache'],$data['compress_data'],$data['compress_data_pagecache'],$data['compress_tags'],$data['compress_tags_pagecache'],$data['compress_threshold'],$data['compress_threshold_pagecache'],$data['compression_lib'],$data['compression_lib_pagecache'],$data['password'],$data['password_pagecache']);
                
                $this->messageManager->addSuccess(__('Connection to Redis Successfull and the Configuration details are saved. '));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while updating the configuration details.'));
            }
            
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('merc/redismanager/edit/id/1');

        }
    }
    protected function _isAllowed()
    {
        return true;
    }
}
