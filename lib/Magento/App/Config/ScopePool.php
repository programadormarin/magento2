<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\App\Config;

class ScopePool
{
    const CACHE_TAG = 'config_scopes';

    /**
     * @var \Magento\App\Config\Scope\ReaderPoolInterface
     */
    protected $_readerPool;

    /**
     * @var \Magento\App\Config\DataFactory
     */
    protected $_dataFactory;

    /**
     * @var \Magento\Cache\FrontendInterface
     */
    protected $_cache;

    /**
     * @var string
     */
    protected $_cacheId;

    /**
     * @var \Magento\App\Config\DataInterface[]
     */
    protected $_scopes = array();

    /**
     * @param \Magento\App\Config\Scope\ReaderPoolInterface $readerPool
     * @param \Magento\App\Config\DataFactory $dataFactory
     * @param \Magento\Cache\FrontendInterface $cache
     * @param string $cacheId
     */
    public function __construct(
        \Magento\App\Config\Scope\ReaderPoolInterface $readerPool,
        \Magento\App\Config\DataFactory $dataFactory,
        \Magento\Cache\FrontendInterface $cache,
        $cacheId = 'default_config_cache'
    ) {
        $this->_readerPool = $readerPool;
        $this->_dataFactory = $dataFactory;
        $this->_cache = $cache;
        $this->_cacheId = $cacheId;
    }

    /**
     * Retrieve config section
     *
     * @param string $scopeType
     * @param string $scopeCode
     * @return \Magento\App\Config\Data
     */
    public function getScope($scopeType, $scopeCode = null)
    {
        $code = $scopeType . '|' . $scopeCode;
        if (!isset($this->_scopes[$code])) {
            $cacheKey = $this->_cacheId . '|' . $code;
            $data = $this->_cache->load($cacheKey);
            if ($data) {
                $data = unserialize($data);
            } else {
                $reader = $this->_readerPool->getReader($scopeType);
                if ($scopeType === \Magento\BaseScopeInterface::SCOPE_DEFAULT) {
                    $data = $reader->read();
                } else {
                    $data = $reader->read($scopeCode);
                }
                $this->_cache->save(serialize($data), $cacheKey, array(self::CACHE_TAG));
            }
            $this->_scopes[$code] = $this->_dataFactory->create(array('data' => $data));
        }
        return $this->_scopes[$code];
    }

    /**
     * Clear cache of all scopes
     */
    public function clean()
    {
        $this->_scopes = array();
        $this->_cache->clean(\Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(self::CACHE_TAG));
    }
}
