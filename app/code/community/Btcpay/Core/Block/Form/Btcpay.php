<?php
/**
 * @license Copyright 2011-2014 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */

class Btcpay_Core_Block_Form_Btcpay extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        $payment_template = 'btcpay/form/btcpay.phtml';

        parent::_construct();
        
        $this->setTemplate($payment_template);
    }
}
