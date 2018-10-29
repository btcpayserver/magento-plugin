<?php
/**
 * @license Copyright 2011-2015 BTCPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */

class Btcpay_Core_Model_Observer {

	public function implementOrderStatus($e) {
		$order = $e -> getOrder();
		$paymentCode = $order -> getPayment() -> getMethodInstance() -> getCode();
		if ($paymentCode == 'btcpay') {
			$order -> setState(Mage_Sales_Model_Order::STATE_NEW, true);
			$order -> save();
		}

		//	Mage::log('$order = $event->getOrder();' . $order -> getState());
	}

	/*
	 * Queries BTCPay to update the order states in magento to make sure that
	 * open orders are closed/canceled if the BTCPay invoice expires or becomes
	 * invalid.
	 */
	public function updateOrderStates() {
		$apiKey = \Mage::getStoreConfig('payment/btcpay/api_key');

		if (false === isset($apiKey) || empty($apiKey)) {
			\Mage::helper('btcpay') -> debugData('[INFO] Btcpay_Core_Model_Observer::updateOrderStates() could not start job to update the order states because the API key was not set.');
			return;
		} else {
			\Mage::helper('btcpay') -> debugData('[INFO] Btcpay_Core_Model_Observer::updateOrderStates() started job to query BTCPay to update the existing order states.');
		}

		/*
		 * Get all of the orders that are open and have not received an IPN for
		 * complete, expired, or invalid.
		 */
		$orders = \Mage::getModel('btcpay/ipn') -> getOpenOrders();

		if (false === isset($orders) || empty($orders)) {
			\Mage::helper('btcpay') -> debugData('[INFO] Btcpay_Core_Model_Observer::updateOrderStates() could not retrieve the open orders.');
			return;
		} else {
			\Mage::helper('btcpay') -> debugData('[INFO] Btcpay_Core_Model_Observer::updateOrderStates() successfully retrieved existing open orders.');
		}

		/*
		 * Get all orders that have been paid using btcpay and
		 * are not complete/closed/etc
		 */
		foreach ($orders as $order) {
			/*
			 * Query BTCPay with the invoice ID to get the status. We must take
			 * care not to anger the API limiting gods and disable our access
			 * to the API.
			 */
			$status = null;

			// TODO:
			// Does the order need to be updated?
			// Yes? Update Order Status
			// No? continue
		}

		\Mage::helper('btcpay') -> debugData('[INFO] Btcpay_Core_Model_Observer::updateOrderStates() order status update job finished.');
	}

	/**
	 * Method that is called via the magento cron to update orders if the
	 * invoice has expired
	 */
	public function cleanExpired() {
		\Mage::helper('btcpay') -> debugData('[INFO] Btcpay_Core_Model_Observer::cleanExpired() called.');
		\Mage::helper('btcpay') -> cleanExpired();
	}
        
        /**
        * Event Hook: checkout_onepage_controller_success_action
        * @param $observer Varien_Event_Observer
        */
        public function redirectToCartIfExpired(Varien_Event_Observer $observer)
        {
            if ($observer->getEvent()->getName() == 'checkout_onepage_controller_success_action')
            {
                $lastOrderId = null;
                foreach(\Mage::app()->getRequest()->getParams() as $key=>$value)
                {
                    if($key == 'order_id')
                        $lastOrderId = $value;
                }

               if($lastOrderId != null)
               {                
                    //get order
                    $order = \Mage::getModel('sales/order')->load($lastOrderId);
                    if (false === isset($order) || true === empty($order)) {
                        \Mage::helper('btcpay')->debugData('[ERROR] In Btcpay_Core_Model_Observer::redirectToCartIfExpired(), Invalid Order ID received.');
                        return;
                    }
                    //check if order is pending
                    if($order->getStatus() != 'pending')
                    {
                        return;
                    }
                    
                    //check if invoice for order exist in btcpay_invoices table
                    $btcpayInvoice = \Mage::getModel('btcpay/invoice')->load($order->getIncrementId(), 'increment_id');
                    $btcpayInvoiceData = $btcpayInvoice->getData();
                    //if is empty or not is array abort
                    if(!is_array($btcpayInvoiceData) || is_array($btcpayInvoiceData) && empty($btcpayInvoiceData))
                        return;

                    //check if btcpay invoice id expired
                    $invoiceExpirationTime = $btcpayInvoiceData['expiration_time'];
                    if($invoiceExpirationTime < strtotime('now'))
                    {
                        $failure_url = \Mage::getUrl(\Mage::getStoreConfig('payment/btcpay/failure_url'));
                        \Mage::app()->getResponse()->setRedirect($failure_url)->sendResponse();
                    }
                }           
            }        
        }
}
