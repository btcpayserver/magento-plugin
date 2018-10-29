<?php
/**
 * @license Copyright 2011-2015 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */

/**
 */
class Btcpay_Core_Model_Mysql4_Ipn extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     */
    protected function _construct()
    {
        $this->_init('btcpay/ipn', 'id');
    }
}
