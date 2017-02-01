<?php
 
namespace Litmus7\Merc\Block\Adminhtml\RedisManager\Edit;
 
use Magento\Backend\Block\Widget\Tabs as WidgetTabs;
 
class Tabs extends WidgetTabs
{
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('redismanager_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Redis Configuration'));
    }
 
    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'redismanager_cache_info',
            [
                'label'     => __('Cache'),
                'title'     => __('Cache'),
                'content'   => $this->getLayout()->createBlock(
                    'Litmus7\Merc\Block\Adminhtml\RedisManager\Edit\Tab\Info'
                )->toHtml(),
                'active'    => 1
            ]
        );
        
        $this->addTab(
            'redismanager_pagecache_info',
            [
                'label'     => __('Page Cache'),
                'title'     => __('Page Cache'),
                'content'   => $this->getLayout()->createBlock(
                    'Litmus7\Merc\Block\Adminhtml\RedisManager\Edit\Tab\PageCache'
                )->toHtml(),
                'active'    => 2
            ]
        );
 
        return parent::_beforeToHtml();
    }
}
 