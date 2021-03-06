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
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Customer\Block\Account\Dashboard;

class Hello extends \Magento\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Customer\Helper\View
     */
    protected $_viewHelper;

    /**
     * @var \Magento\Customer\Service\V1\CustomerServiceInterface
     */
    protected $_customerService;

    /**
     * Constructor
     *
     * @param \Magento\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Helper\View $viewHelper
     * @param \Magento\Customer\Service\V1\CustomerServiceInterface $customerService
     * @param array $data
     */
    public function __construct(
        \Magento\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Helper\View $viewHelper,
        \Magento\Customer\Service\V1\CustomerServiceInterface $customerService,
        array $data = array()
    ) {
        $this->_customerSession = $customerSession;
        $this->_viewHelper = $viewHelper;
        $this->_customerService = $customerService;
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
    }

    /**
     * Concatenate all customer name parts into full customer name.
     *
     * @return string
     */
    public function getCustomerName()
    {
        $customer = $this->_customerService->getCustomer($this->_customerSession->getCustomerId());
        return $this->_viewHelper->getCustomerName($customer);
    }
}
