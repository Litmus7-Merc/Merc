<?php
/**
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */

namespace Litmus7\Merc\Block\Adminhtml\Product;

use \Magento\Catalog\Block\Adminhtml\Product\Edit;

class ProductEdit extends Edit 
{
    /**
     * @var string
     */
    protected $_template = 'Magento_Catalog::catalog/product/edit.phtml';
    
    /**
    * @var data
    */
    protected $redis;
    
        
    
    /**
     * Add elements in layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        /** @var \Magento\Framework\UrlInterface $urlInterface */
        $urlInterface       =   \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\UrlInterface');
        $currentUrl         =   $urlInterface->getCurrentUrl();
        $editproductUrl     =   strpos($currentUrl, '/catalog/product/edit/');
        if($editproductUrl == true) { // Making sure this change will not affect the add new product page.
            
            $objectManager  =   \Magento\Framework\App\ObjectManager::getInstance();
            $sku_ar         =   explode('-', $this->getProductSku());
            $searchKeyId    =   'CATALOG_PRODUCT_VIEW_ID_' . $this->getProductId();
            $searchKeySku   =   'CATALOG_PRODUCT_VIEW_SKU_' . $sku_ar[0] . '_' . $sku_ar[1];
            $objectManager  =   \Magento\Framework\App\ObjectManager::getInstance();
            $redisObj       =   $objectManager->create('Litmus7\Merc\Helper\Data');
            $redis          =   $redisObj->getRedisInstance();
            $keys           =   $redis->getRedis()->keys("*$searchKeyId");
            if(count($keys)>0) {
                            
                    $this->getToolbar()->addChild(
                    'delete_product_redis_keys',
                    'Magento\Backend\Block\Widget\Button',
                    [
                        'label' => __('Delete Redis Key'),
                        'title' => __('Delete Redis Key'),
                        'onclick' => 'setLocation(\'' . $this->getUrl(
                            'merc/statistics/deleteproductkey/id/'.$this->getProductId().'/sku/'.$this->getProductSku() ,
                            ['store' => $this->getRequest()->getParam('store', 0)]
                        ) . '\')',
                        'class' => 'action-default primary'
                    ]
                );
            }
        }
        
        return parent::_prepareLayout();
    }
    
    /**
     * @return mixed
     */
    public function getProductSku()
    {
        return $this->getProduct()->getSku();  
    }
    
}
