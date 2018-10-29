<?php
/**
 * @license Copyright 2011-2015 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */

/**
 */
class Btcpay_Core_Model_Mysql4_Invoice extends Mage_Core_Model_Mysql4_Abstract
{
    protected $_isPkAutoIncrement = false;

    /**
     */
    protected function _construct()
    {
        $this->_init('btcpay/invoice', 'id');
    }
}
