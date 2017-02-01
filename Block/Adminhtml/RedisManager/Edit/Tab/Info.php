<?php
 
namespace Litmus7\Merc\Block\Adminhtml\RedisManager\Edit\Tab;
 
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
 
class Info extends Generic implements TabInterface
{
 
   /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }
 
    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        /** @var $model \Litmus7\Merc\Model\Redismanager */
        $model = $this->_coreRegistry->registry('litmus7_redis_configuration');
 
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('redismanager_');
 
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Redis Cache Configuration Details')]
        );
        if ($model->getId()) {
            $fieldset->addField(
                'config_id',
                'hidden',
                ['name' => 'id']
            );
        }
        $fieldset->addField(
            'server',
            'text',
            [
                'name'        => 'server',
                'label'       => __('Server'),
                'style' => "border-radius: 10px;",
                'required'    => true
            ]
        );
        $fieldset->addField(
            'port',
            'text',
            [
                'name'      => 'port',
                'label'     => __('Port'),
                'style' => "border-radius: 10px;",
                'required'  => true
            ]
        );
        $fieldset->addField(
            'persistent',
            'text',
            [
                'name'      => 'persistent',
                'label'     => __('Persistent'),
                'style' => "border-radius: 10px;",
                'required'  => false
            ]
        );
        $fieldset->addField(
            'db',
            'select',
            [
                'name'      => 'db',
                'label'     => __('DB'),
                'values' => array('0' => 'DB0','1' => 'DB1', '2' => 'DB2', '3' => 'DB3', '4' => 'DB4', '5' => 'DB5', '6' => 'DB6', '7' => 'DB7',
                                   '8' => 'DB8', '9' => 'DB9', '10' => 'DB10', '11' => 'DB11', '12' => 'DB12', '13' => 'DB14', '15' => 'DB15'),
                'required'  => true
            ]
        );
        $fieldset->addField(
            'force_standalone',
            'radios',
            [
                'name'      => 'force_standalone',
                'label'     => __('Force Standalone'),
                'style' => "border-radius: 10px;",
                'values' => array(
                            array('value'=>'0','label'=>'Phpredis'),
                            array('value'=>'1','label'=>'Standalone PHP'),
                       ),
                'required'  => true
            ]
        );
        $fieldset->addField(
            'connect_retries',
            'text',
            [
                'name'      => 'connect_retries',
                'label'     => __('Connect Retries'),
                'style' => "border-radius: 10px;",
                'after_element_html' => '<small>Reduces errors due to random connection failures; a value of 1 will not retry after the first failure.</small>',
                'required'  => true
            ]
        );
        $fieldset->addField(
            'read_timeout',
            'text',
            [
                'name'      => 'read_timeout',
                'label'     => __('Read Timeout'),
                'style' => "border-radius: 10px;",
                'after_element_html' => '<small>Upto this time(sec) server will not close the connection if the client is in an idle state.</small>',
                'required'  => true
            ]
        );
        $fieldset->addField(
            'automatic_cleaning_factor',
            'radios',
            [
                'name'      => 'automatic_cleaning_factor',
                'label'     => __('Automatic Cleaning Factor'),
                'values' => array(
                            array('value'=>'0','label'=>'Disable'),
                            array('value'=>'1','label'=>'Enable'),
                       ),
                'required'  => true
            ]
        );
        
        $fieldset->addField(
            'compress_data',
            'select',
            [
                'name'      => 'compress_data',
                'label'     => __('Compress Data'),
                'values' => array('0' => '0','1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7',
                                   '8' => '8', '9' => '9'),
                'after_element_html' => '<small>Recommended: 0 or 1</small>',
                'required'  => true
            ]
        );
        $fieldset->addField(
            'compress_tags',
            'select',
            [
                'name'      => 'compress_tags',
                'label'     => __('Compress Tags'),
                'values' => array('0' => '0','1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7',
                                   '8' => '8', '9' => '9'),
                'after_element_html' => '<small>Recommended: 0 or 1</small>',
                'required'  => true
            ]
        );
        $fieldset->addField(
            'compress_threshold',
            'text',
            [
                'name'      => 'compress_threshold',
                'label'     => __('Compress Threshold'),
                'style' => "border-radius: 10px;",
                'after_element_html' => '<small>Strings below this size will not be compressed</small>',
                'required'  => true
            ]
        );
        $fieldset->addField(
            'compression_lib',
            'text',
            [
                'name'      => 'compression_lib',
                'label'     => __('Compression Lib'),
                'style' => "border-radius: 10px;",
                'after_element_html' => '<small>Supports gzip, lzf and snappy</small>',
                'required'  => true
            ]
        );
        $fieldset->addField(
            'password',
            'password',
            [
                'name'      => 'password',
                'label'     => __('Password'),
                'style' => "border-radius: 10px;",
                'required'  => false
            ]
        );
        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);
        
        return parent::_prepareForm();
    }
 
    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('RedisManager Info');
    }
 
    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('RedisManager Info');
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
}
 