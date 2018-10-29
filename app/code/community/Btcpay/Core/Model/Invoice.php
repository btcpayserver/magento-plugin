<?php
/**
 * @license Copyright 2011-2015 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */

/**
 */
class Btcpay_Core_Model_Invoice extends Mage_Core_Model_Abstract
{
    /**
     */
    protected function _construct()
    {
        $this->_init('btcpay/invoice');
    }

    /**
     * Adds data to model based on an Invoice that has been retrieved from
     * BitPay's API
     *
     * @param Bitpay\Invoice $invoice
     * @return Btcpay_Core_Model_Invoice
     */
    public function prepareWithBitpayInvoice($invoice)
    {
        if (false === isset($invoice) || true === empty($invoice)) {
            \Mage::helper('btcpay')->debugData('[ERROR] In Btcpay_Core_Model_Invoice::prepareWithBitpayInvoice(): Missing or empty $invoice parameter.');
            throw new \Exception('In Btcpay_Core_Model_Invoice::prepareWithBitpayInvoice(): Missing or empty $invoice parameter.');
        }
        
        $this->addData(
            array(
                'id'               => $invoice->getId(),
                'url'              => $invoice->getUrl(),
                'pos_data'         => $invoice->getPosData(),
                'status'           => $invoice->getStatus(),
                'price'            => $invoice->getPrice(),
                'currency'         => $invoice->getCurrency()->getCode(),
                'order_id'         => $invoice->getOrderId(),
                'invoice_time'     => intval(date_format($invoice->getInvoiceTime(), 'U') / 1000),
                'expiration_time'  => intval(date_format($invoice->getExpirationTime(), 'U') / 1000),
                'current_time'     => intval(date_format($invoice->getCurrentTime(), 'U') / 1000),
                'exception_status' => $invoice->getExceptionStatus(),
                'transactionCurrency' => $invoice->getTransactionCurrency()
            )
        );

        return $this;
    }

    /**
     * Adds information to based on the order object inside magento
     *
     * @param Mage_Sales_Model_Order $order
     * @return Btcpay_Core_Model_Invoice
     */
    public function prepareWithOrder($order)
    {
        if (false === isset($order) || true === empty($order)) {
            \Mage::helper('btcpay')->debugData('[ERROR] In Btcpay_Core_Model_Invoice::prepateWithOrder(): Missing or empty $order parameter.');
            throw new \Exception('In Btcpay_Core_Model_Invoice::prepateWithOrder(): Missing or empty $order parameter.');
        }
        
        $this->addData(
            array(
                'quote_id'     => $order['quote_id'],
                'increment_id' => $order['increment_id'],
            )
        );

        return $this;
    }
}
