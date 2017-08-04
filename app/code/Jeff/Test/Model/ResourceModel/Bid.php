<?php

namespace Jeff\Test\Model\ResourceModel;

class Bid extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected function _construct()
	{
		$this->_init('jefftest_bidprice', 'bidprice_id');
	}
}