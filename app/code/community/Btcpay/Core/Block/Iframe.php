<?php
/**
 * @license Copyright 2011-2014 Bitpay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 * 
 */

class Btcpay_Core_Block_Iframe extends Mage_Checkout_Block_Onepage_Payment
{
    /**
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('btcpay/iframe.phtml');
    }

    /**
     * create an invoice and return the url so that iframe.phtml can display it
     *
     * @return string
     */
    public function getIframeUrl()
    {
        
        if (!($quote = Mage::getSingleton('checkout/session')->getQuote()) 
            or !($payment = $quote->getPayment())
            or !($paymentMethod = $payment->getMethod())
            or ($paymentMethod !== 'btcpay') )
        {
            return 'notbtcpay';
        }

        \Mage::helper('btcpay')->registerAutoloader();

        if (\Mage::getModel('btcpay/ipn')->getQuotePaid($this->getQuote()->getId())) {
            return 'paid'; // quote's already paid, so don't show the iframe
        }

        return 'redirect';
    }
}
