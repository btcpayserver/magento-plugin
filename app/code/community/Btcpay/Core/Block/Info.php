<?php
/**
 * @license Copyright 2011-2014 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */

class Btcpay_Core_Block_Info extends Mage_Payment_Block_Info
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('btcpay/info/default.phtml');
    }

    public function getBtcpayInvoiceUrl()
    {
        $order       = $this->getInfo()->getOrder();

        if (false === isset($order) || true === empty($order)) {
            \Mage::helper('btcpay')->debugData('[ERROR] In Btcpay_Core_Block_Info::getBtcpayInvoiceUrl(): could not obtain the order.');
            throw new \Exception('In Btcpay_Core_Block_Info::getBtcpayInvoiceUrl(): could not obtain the order.');
        }

        $incrementId = $order->getIncrementId();

        if (false === isset($incrementId) || true === empty($incrementId)) {
            \Mage::helper('btcpay')->debugData('[ERROR] In Btcpay_Core_Block_Info::getBtcpayInvoiceUrl(): could not obtain the incrementId.');
            throw new \Exception('In Btcpay_Core_Block_Info::getBtcpayInvoiceUrl(): could not obtain the incrementId.');
        }

        $btcpayInvoice = \Mage::getModel('btcpay/invoice')->load($incrementId, 'increment_id');

        if (true === isset($btcpayInvoice) && false === empty($btcpayInvoice)) {
            return $btcpayInvoice->getUrl();
        }
        else {
            \Mage::helper('btcpay')->debugData('[ERROR] In Btcpay_Core_Block_Info::getBtcpayInvoiceUrl(): invoice is null or empty.');
        }
    }
}
