<?php
 
namespace Litmus7\Merc\Controller\Adminhtml\RedisManager;
 
use Magento\Backend\App\Action;
 
class NewAction extends \Magento\Backend\App\Action
{
  /**
    * Create new news action
    *
    * @return void
    */
    public function execute()
    {
        $this->_forward('edit');
    }
   
    public function _isAllowed()
    {
        return true;
    }
}
