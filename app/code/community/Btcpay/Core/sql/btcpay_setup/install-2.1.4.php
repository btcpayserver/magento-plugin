<?php
/**
 * @license Copyright 2011-2014 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 */
$this->startSetup();

/**
 * IPN Log Table, used to keep track of incoming IPNs
 */
$this->run(sprintf('DROP TABLE IF EXISTS `%s`;', $this->getTable('btcpay/ipn')));
$ipnTable = new Varien_Db_Ddl_Table();
$ipnTable->setName($this->getTable('btcpay/ipn'));
$ipnTable->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array('auto_increment' => true, 'nullable' => false, 'primary' => true,));
$ipnTable->addColumn('invoice_id', Varien_Db_Ddl_Table::TYPE_TEXT, 200);
$ipnTable->addColumn('url', Varien_Db_Ddl_Table::TYPE_TEXT, 400);
$ipnTable->addColumn('status', Varien_Db_Ddl_Table::TYPE_TEXT, 20);
$ipnTable->addColumn('btc_price', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(16, 8));
$ipnTable->addColumn('price', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(16, 8));
$ipnTable->addColumn('currency', Varien_Db_Ddl_Table::TYPE_TEXT, 10);
$ipnTable->addColumn('invoice_time', Varien_Db_Ddl_Table::TYPE_INTEGER, 11);
$ipnTable->addColumn('expiration_time', Varien_Db_Ddl_Table::TYPE_INTEGER, 11);
$ipnTable->addColumn('current_time', Varien_Db_Ddl_Table::TYPE_INTEGER, 11);
$ipnTable->addColumn('pos_data', Varien_Db_Ddl_Table::TYPE_TEXT, 255);
$ipnTable->addColumn('btc_paid', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(16, 8));
$ipnTable->addColumn('rate', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(16, 8));
$ipnTable->addColumn('exception_status', Varien_Db_Ddl_Table::TYPE_TEXT, 255);

$ipnTable->setOption('type', 'InnoDB');
$ipnTable->setOption('charset', 'utf8');
$this->getConnection()->createTable($ipnTable);

/**
 * Table used to keep track of invoices that have been created. The
 * IPNs that are received are used to update this table.
 */
$this->run(sprintf('DROP TABLE IF EXISTS `%s`;', $this->getTable('btcpay/invoice')));
$invoiceTable = new Varien_Db_Ddl_Table();
$invoiceTable->setName($this->getTable('btcpay/invoice'));
$invoiceTable->addColumn('id', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array('nullable' => false, 'primary' => true));
$invoiceTable->addColumn('quote_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11);
$invoiceTable->addColumn('increment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11);
$invoiceTable->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP);
$invoiceTable->addColumn('url', Varien_Db_Ddl_Table::TYPE_TEXT, 200);
$invoiceTable->addColumn('pos_data', Varien_Db_Ddl_Table::TYPE_TEXT, 255);
$invoiceTable->addColumn('status', Varien_Db_Ddl_Table::TYPE_TEXT, 20);
$invoiceTable->addColumn('btc_price', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(16, 8));
$invoiceTable->addColumn('btc_due', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(16, 8));
$invoiceTable->addColumn('price', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(16, 8));
$invoiceTable->addColumn('currency', Varien_Db_Ddl_Table::TYPE_TEXT, 10);
$invoiceTable->addColumn('ex_rates', Varien_Db_Ddl_Table::TYPE_TEXT, 255);
$invoiceTable->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_TEXT, 64);
$invoiceTable->addColumn('invoice_time', Varien_Db_Ddl_Table::TYPE_INTEGER, 11);
$invoiceTable->addColumn('expiration_time', Varien_Db_Ddl_Table::TYPE_INTEGER, 11);
$invoiceTable->addColumn('current_time', Varien_Db_Ddl_Table::TYPE_INTEGER, 11);
$invoiceTable->addColumn('btc_paid', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(16, 8));
$invoiceTable->addColumn('rate', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(16, 8));
$invoiceTable->addColumn('exception_status', Varien_Db_Ddl_Table::TYPE_TEXT, 255);
$invoiceTable->addColumn('token', Varien_Db_Ddl_Table::TYPE_TEXT, 164);
$invoiceTable->setOption('type', 'InnoDB');
$invoiceTable->setOption('charset', 'utf8');
$this->getConnection()->createTable($invoiceTable);

$this->endSetup();
