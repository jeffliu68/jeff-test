<?php

namespace Jeff\Test\Helper;

use Magento\Catalog\Model\Product;
use DateTime;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $_product = null;
	protected $_date;
	protected $_bidFactory;
	protected $_productFactory;
	protected $_request;

	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\Stdlib\DateTime\DateTime $date,
		\Jeff\Test\Model\BidFactory $bidFactory,
		\Magento\Framework\App\Request\Http $request,
		\Magento\Catalog\Model\ProductFactory $productFactory
	)
	{
		$this->_date = $date;
		$this->_bidFactory = $bidFactory;
		$this->_request = $request;
		$this->_productFactory = $productFactory;
		parent::__construct($context);
	}

	public function getCurrentDatetime()
	{
		return $this->_date->gmtDate();
	}

	public function getProduct($product_id)
	{
//		$productId = (int) $this->_request->getParam("id");var_dump($productId);
		$this->_product = $this->_productFactory->create()->load($product_id);
		return $this->_product;
	}

	public function getBidSellPrice($product_id)
	{
		return $this->getProduct($product_id)->getBidSellPrice();
	}

	public function getBidCollection()
	{
		$bidCollection = $this->_bidFactory->create()->getCollection();
		return $bidCollection;
	}

	public function getCurrentBid($product_id)
	{
		if ($this->isWinning($product_id)) return -1 ; //'The bid has closed.';
		if (!$this->isActive($product_id)) return -2 ; //'The bid is not active';
		$bids = $this->getBidCollection()
				->addFieldToFilter('product_id', ['eq' => $product_id])
				->setOrder('bid_time', 'DESC')
				->setPageSize(1);

		$currentBid = ($bids->getFirstItem()->getBidPrice() == null ? 0 : $bids->getFirstItem()->getBidPrice());
		return $currentBid;
	}

	public function isWinning($product_id)
	{
//		$product_id = $this->getProduct()->getId();
		$bid_collection = $this->getBidCollection()
						->addFieldToFilter('product_id', ['eq' => $product_id])
						->addFieldToFilter('winning', ['eq' => true]);

		if ($bid_collection->count() > 0)
		{
			return true;
		} else {
			return false;
		}
	}

	public function isActive($product_id)
	{
		$current = date("Y-m-d h:i:s");
		$start = ($this->getProduct($product_id)->getBidFromDate() == null ? '0000-00-00 00:00:00' : $this->getProduct($product_id)->getBidFromDate());
		$end = ($this->getProduct($product_id)->getBidToDate() == null ? '9999-12-31 23:59:59' : $this->getProduct($product_id)->getBidToDate());

		$dt_current = new DateTime($current);
		$dt_start 	= new DateTime($start);
		$dt_end		= new DateTime($end);

		return ($dt_current > $dt_start) && ($dt_current < $dt_end);
	}

}