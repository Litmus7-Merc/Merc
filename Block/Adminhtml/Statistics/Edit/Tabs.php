<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Block\Adminhtml\Statistics\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        
        parent::_construct();
        $this->setId('checkmodule_status_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('General Statistics'));
    }
}
