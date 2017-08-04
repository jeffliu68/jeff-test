<?php

namespace Jeff\Test\Controller\Index;

use \Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_test;
	protected $_storeManager;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Catalog\Model\ProductFactory $test,
		\Magento\Store\Model\StoreManagerInterface $storeManager
	){
		$this->_test = $test;
		$this->_storeManager = $storeManager;
		parent::__construct($context);

	}

	public function execute()
	{
		$product = $this->_test->create();
//		echo $product->load(12)->getName();
//		var_dump($this->getRequest()->getParam("jeff"));
		//$store = $this->_storeManager;
		//var_dump($store->getStore()->getName());
		$page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
		return $page;
	}
}