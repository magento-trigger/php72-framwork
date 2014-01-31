<?php
/**
 * Form Element Multiselect Data Model
 *
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
 * @package     Magento_Customer
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magento\Customer\Model\Metadata\Form;

class Multiselect extends Select
{
    /**
     * Extract data from request and return value
     *
     * @param \Magento\App\RequestInterface $request
     * @return array|string
     */
    public function extractValue(\Magento\App\RequestInterface $request)
    {
        $values = $this->_getRequestValue($request);
        if ($values !== false && !is_array($values)) {
            $values = array($values);
        }
        return $values;
    }

    /**
     * Export attribute value to entity model
     *
     * @param array|string $value
     * @return \Magento\Customer\Model\Metadata\Form\Multiselect
     */
    public function compactValue($value)
    {
        if (is_array($value)) {
            $value = implode(',', $value);
        }
        return parent::compactValue($value);
    }

    /**
     * Return formated attribute value from entity model
     *
     * @param string $format
     * @return array|string
     */
    public function outputValue($format = \Magento\Eav\Model\AttributeDataFactory::OUTPUT_FORMAT_TEXT)
    {
        $values = $this->_value;
        if (!is_array($values)) {
            $values = explode(',', $values);
        }

        switch ($format) {
            case \Magento\Eav\Model\AttributeDataFactory::OUTPUT_FORMAT_JSON:
            case \Magento\Eav\Model\AttributeDataFactory::OUTPUT_FORMAT_ARRAY:
                $output = $values;
            default:
                $output = array();
                foreach ($values as $value) {
                    if (!$value) {
                        continue;
                    }
                    $optionText = false;
                    foreach ($this->getAttribute()->getOptions() as $optionKey => $optionValue) {
                        if ($optionValue == $value) {
                            $optionText = $optionKey;
                        }
                    }
                    $output[] = $optionText;
                }
                $output = implode(', ', $output);
                break;
        }

        return $output;
    }
}