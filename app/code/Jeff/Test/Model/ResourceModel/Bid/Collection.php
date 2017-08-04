<?php

namespace Jeff\Test\Model\ResourceModel\Bid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected function _construct()
	{
		$this->_init('Jeff\Test\Model\Bid', 'Jeff\Test\Model\ResourceModel\Bid');
	}
}