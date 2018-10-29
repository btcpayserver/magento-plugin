<?php
/**
 * @license Copyright 2011-2015 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */

class Btcpay_Core_Model_Mysql4_Ipn_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('btcpay/ipn');
    }
}
