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
 * @category    Magento
 * @package     Magento
 * @subpackage  static_tests
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * PHP Code Sniffer Cli wrapper
 */
namespace Magento\TestFramework\CodingStandard\Tool\CodeSniffer;

class Wrapper extends \PHP_CodeSniffer_CLI
{
    /**
     * Emulate console arguments
     *
     * @param $values
     * @return \Magento\TestFramework\CodingStandard\Tool\CodeSniffer\Wrapper
     */
    public function setValues($values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * Return the current version of php code sniffer
     *
     * @return string
     */
    public function version()
    {
        $version = '0.0.0';
        if (defined('\PHP_CodeSniffer::VERSION')) {
            $phpcs = new \PHP_CodeSniffer();
            $version = $phpcs::VERSION;
        }
        return $version;
    }
}
