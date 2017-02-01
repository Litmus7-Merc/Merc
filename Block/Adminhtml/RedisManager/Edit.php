<?php
 
namespace Litmus7\Merc\Block\Adminhtml\RedisManager;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
 
class Edit extends Container
{
   /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
 
    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }
 
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId    = 'id';
        $this->_controller  = 'adminhtml_statistics';
        $this->_blockGroup  = 'Litmus7_Merc';
 
        parent::_construct();
 
        $this->removeButton('delete');
        $this->removeButton('reset');
        $this->buttonList->update('save', 'label', __('Save'));
    }
 
}