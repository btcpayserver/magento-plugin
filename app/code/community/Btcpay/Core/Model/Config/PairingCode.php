<?php
/**
 * @license Copyright 2011-2015 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */

/**
 * This class will take the pairing code the merchant entered and pair it with
 * BTCPay's API.
 */
class Btcpay_Core_Model_Config_PairingCode extends Mage_Core_Model_Config_Data
{
    /**
     * @inheritdoc
     */
    public function save()
    {
        /**
         * If the user has put a paring code into the text field, we want to
         * pair the magento store to the stores keys. If the merchant is just
         * updating a configuration setting, we could care less about the
         * pairing code.
         */
        $pairingCode = trim($this->getValue());

        if (true === empty($pairingCode)) {
            return;
        }

        \Mage::helper('btcpay')->debugData('[INFO] In Btcpay_Core_Model_Config_PairingCode::save(): attempting to pair with BTCPay with pairing code ' . $pairingCode);

        try {
            \Mage::helper('btcpay')->sendPairingRequest($pairingCode);
        } catch (\Exception $e) {
            \Mage::helper('btcpay')->debugData(sprintf('[ERROR] Exception thrown while calling the sendPairingRequest() function. The specific error message is: "%s"', $e->getMessage()));
            \Mage::getSingleton('core/session')->addError('There was an error while trying to pair with BTCPay using the pairing code '.$pairingCode.'. Please make sure you select the correct Network (Livenet vs Testnet) and try again with a new 7 character pairing code or enable debug mode and send the "payment_btcpay.log" file to support@btcpay.com for more help.');

            return;
        }

        \Mage::getSingleton('core/session')->addSuccess('Pairing with BTCPay was successful.');
    }
}
