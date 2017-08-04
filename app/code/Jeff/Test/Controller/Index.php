<?php

namespace Jeff\Test\Controller;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_test;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Jeff\Test\Model\Basic $test
	){
		$this->_test = $test;
		parent::__construct($context);

	}

	public function execute()
	{
		echo 'Hello World';
	}
}