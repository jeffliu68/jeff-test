<?php

namespace Jeff\Test\Block\Product\View;

use Magento\Catalog\Model\Product;
use DateTime;

class Bid extends \Magento\Framework\View\Element\Template
{
	protected $_productFactory;
	protected $_customerSession;
	protected $_bidFactory;
	protected $_helper;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Catalog\Model\ProductFactory $productFactory,
		\Magento\Customer\Model\Session $customerSession,
		\Jeff\Test\Model\BidFactory $bidFactory,
		\Jeff\Test\Helper\Data $helper,
		array $data = []
		)
	{
		$this->_productFactory = $productFactory;
		$this->_customerSession = $customerSession;
		$this->_bidFactory = $bidFactory;
		$this->_helper = $helper;
		parent::__construct($context, $data);
	}

	public function getProduct()
	{
		$productId = (int) $this->getRequest()->getParam('id');
		return $this->_productFactory->create()->load($productId);
	}

	public function getCustomerId()
	{
		$customerId = $this->_customerSession->getCustomer()->getId();
		return $customerId;
	}

	public function getHelper()
	{
		return $this->_helper;
	}

	public function _prepareLayout()
	{
		//var_dump($this->_customerSession->getCustomer()->getId());
	}
}