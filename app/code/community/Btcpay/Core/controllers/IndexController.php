<?php
/**
 * @license Copyright 2011-2014 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */

/**
 * @route btcpay/index/
 */
class Btcpay_Core_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * @route bitpay/index/index?quote=n
     */
    public function indexAction()
    {
        \Mage::helper('btcpay')->registerAutoloader();
        \Mage::helper('btcpay')->debugData($params);

	$params  = $this->getRequest()->getParams();
	$quoteId = $params['quote'];

	if (!is_numeric($quoteId))
	{
	    return $this->getResponse()->setHttpResponseCode(400);
	}

        $paid = \Mage::getModel('btcpay/ipn')->GetQuotePaid($quoteId);
        $this->loadLayout();
        $this->getResponse()->setHeader('Content-type', 'application/json');
        
        return $this->getResponse()->setBody(json_encode(array('paid' => $paid)));
    }
}
