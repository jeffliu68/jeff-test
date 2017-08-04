<?php

namespace Jeff\Test\Model;

class Bid extends \Magento\Framework\Model\AbstractModel
{
	protected function _construct()
	{
		$this->_init('Jeff\Test\Model\ResourceModel\Bid');
	}
}