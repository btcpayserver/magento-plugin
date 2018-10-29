<?php
/**
 * @license Copyright 2011-2015 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */

class Btcpay_Core_Model_SpecificCountry
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $country = \Mage::getModel('adminhtml/system_config_source_country')->toOptionArray();
        
        $allowCountry = array();
        foreach($country as $v)
        {
            if($v['value'] != '' && $v['value'] != 'SY' && $v['value'] != 'IR' && $v['value'] != 'KP' && $v['value'] != 'SD' && $v['value'] != 'CU')
            {
                $allowCountry[] = $v;
            }
        }
        
        return $allowCountry;
    }
}
