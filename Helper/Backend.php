<?php

namespace Litmus7\Merc\Helper;
 
class Backend
{
    /**
     * Frontend or Core directives
     *
     * =====> (int) lifetime :
     * - Cache lifetime (in seconds)
     * - If null, the cache is valid forever
     *
     * =====> (int) logging :
     * - if set to true, a logging is activated throw Zend_Log
     *
     * @var array directives
     */
    protected $_directives = array(
        'lifetime' => 3600,
        'logging'  => false,
        'logger'   => null
    );

    /**
     * Available options
     *
     * @var array available options
     */
    protected $_options = array();

    /**
     * Constructor
     *
     * @param  array $options Associative array of options
     */
    public function __construct(array $options = array())
    {
        foreach ($options as $name => $value) {
            $this->setOption($name, $value);
        }
    }

    /**
     * Set the frontend directives
     *
     * @param  array $directives Assoc of directives
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    public function setDirectives($directives)
    {
        if (!is_array($directives)) throw new \Magento\Framework\Exception\LocalizedException(__('Directives parameter must be an array'));
        while (list($name, $value) = each($directives)) {
            if (!is_string($name)) {
                throw new \Magento\Framework\Exception\LocalizedException(__("Incorrect option name : $name"));
            }
            $name = strtolower($name);
            if (array_key_exists($name, $this->_directives)) {
                $this->_directives[$name] = $value;
            }

        }

        $this->_loggerSanity();
    }

    /**
     * Set an option
     *
     * @param  string $name
     * @param  mixed  $value
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    public function setOption($name, $value)
    {
        if (!is_string($name)) {
            throw new \Magento\Framework\Exception\LocalizedException(__("Incorrect option name : $name"));
        }
        $name = strtolower($name);
        if (array_key_exists($name, $this->_options)) {
            $this->_options[$name] = $value;
        }
    }

    /**
     * Returns an option
     *
     * @param string $name Optional, the options name to return
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return mixed
     */
    public function getOption($name)
    {
        $name = strtolower($name);

        if (array_key_exists($name, $this->_options)) {
            return $this->_options[$name];
        }

        if (array_key_exists($name, $this->_directives)) {
            return $this->_directives[$name];
        }

        throw new \Magento\Framework\Exception\LocalizedException(__("Incorrect option name : {$name}"));
    }

    /**
     * Get the life time
     *
     * if $specificLifetime is not false, the given specific life time is used
     * else, the global lifetime is used
     *
     * @param  int $specificLifetime
     * @return int Cache life time
     */
    public function getLifetime($specificLifetime)
    {
        if ($specificLifetime === false) {
            return $this->_directives['lifetime'];
        }
        return $specificLifetime;
    }

    /**
     * Return true if the automatic cleaning is available for the backend
     *
     * DEPRECATED : use getCapabilities() instead
     *
     * @deprecated
     * @return boolean
     */
    public function isAutomaticCleaningAvailable()
    {
        return true;
    }

    /**
     * Make sure if we enable logging that the Zend_Log class
     * is available.
     * Create a default log object if none is set.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    protected function _loggerSanity()
    {
        if (!isset($this->_directives['logging']) || !$this->_directives['logging']) {
            return;
        }

        if (isset($this->_directives['logger'])) {
            if ($this->_directives['logger'] instanceof Zend_Log) {
                return;
            }
            throw new \Magento\Framework\Exception\LocalizedException(__('Logger object is not an instance of Zend_Log class.'));
        }

        // Create a default logger to the standard output stream
        #require_once 'Zend/Log.php';
        #require_once 'Zend/Log/Writer/Stream.php';
        #require_once 'Zend/Log/Filter/Priority.php';
        $logger = new Zend_Log(new Zend_Log_Writer_Stream('php://output'));
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::WARN, '<='));
        $this->_directives['logger'] = $logger;
    }

    /**
     * Log a message at the WARN (4) priority.
     *
     * @param  string $message
     * @param  int    $priority
     * @return void
     */
    protected function _log($message, $priority = 4)
    {
        if (!$this->_directives['logging']) {
            return;
        }

        if (!isset($this->_directives['logger'])) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Logging is enabled but logger is not set.'));
        }
        $logger = $this->_directives['logger'];
        if (!$logger instanceof Zend_Log) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Logger object is not an instance of Zend_Log class.'));
        }
        $logger->log($message, $priority);
    }
}
