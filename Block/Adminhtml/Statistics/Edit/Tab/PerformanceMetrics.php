<?php
/**
 *
 * Copyright © 2016 Litmus7ecommerce. All rights reserved.
 */
namespace Litmus7\Merc\Block\Adminhtml\Statistics\Edit\Tab;

use Litmus7\Merc\Helper\Data as data;

class PerformanceMetrics extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    /**
    * @var data
    */
    protected $redis;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        data $redis,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
        $this->redis        = $redis;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    public function genStats()
    {
        $GenStat = $this->redis->generalStats("Stats");
        return $GenStat;
    }
    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Perfomance Metrics');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Perfomance Metrics');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
      return true;
    }
}
