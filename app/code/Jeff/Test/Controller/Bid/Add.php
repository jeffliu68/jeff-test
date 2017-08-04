<?php

namespace Jeff\Test\Controller\Bid;

class Add extends \Magento\Framework\App\Action\Action
{
	protected $_bidFactory;
	protected $_customerSession;
	protected $_urlInterface;
	protected $_helper;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Jeff\Test\Model\BidFactory $bidFactory,
		\Magento\Customer\Model\Session $customerSession,
		\Magento\Framework\urlInterface $urlInterface,
		\Jeff\Test\Helper\Data $helper
	)
	{
		$this->_bidFactory = $bidFactory;
		$this->_helper = $helper;
		$this->_customerSession = $customerSession;
		$this->_urlInterface = $urlInterface;
		parent::__construct($context);
	}

	public function execute()
	{
		$customerSession = $this->_customerSession;
		$urlInterface = $this->_urlInterface;
		if(!$customerSession->isLoggedIn()) {
    		$customerSession->setAfterAuthUrl($urlInterface->getCurrentUrl());
    		$customerSession->authenticate();
		}

		if ($this->isValid()):
			$params = $this->getRequest()->getParams();
			$bid = $this->_bidFactory->create();
			$bid->setData($params);
			$bid->setBidTime($this->_helper->getCurrentDatetime());
			try {
				$bid->save();
			} catch (\Exception $e) {
				echo $e;
			}
		endif;
	}

	protected function isValid()
	{
		$bid_price = $this->getRequest()->getParam('bid_price');
		if (is_numeric($bid_price))
		{

			$product_id = $this->getRequest()->getParam('product_id');
			$bid_time = $this->_helper->getCurrentDatetime();
			if (!$this->_helper->isWinning($product_id) && $this->_helper->isActive($product_id))
			{
				$currentBid = $this->_helper->getCurrentBid($product_id);
				if ($currentBid < 0)
				{
					var_dump('Bid is not active or closed.');
					return false;					
				} else {
					//HARD CODE default bid sell price to 100
					$bidSellPrice = ($this->_helper->getBidSellPrice($product_id) == null ? 100 : $this->_helper->getBidSellPrice($product_id));
					if ($bid_price >= $bidSellPrice)
					{
						var_dump('Success! Bid price is greater than or equal to bid sell price.');
						return true;
					} else {
						if ($currentBid >= $bid_price )
						{
							var_dump('Failed! Bid price ' . $bid_price . ' is lower than or equal to current bid ' . $currentBid);
							return false;
						} else {
							var_dump('Success! New high bid price.');
							return true;
						}
					}
				}
			} else {
				var_dump('Failed! Bid is either closed or inactive.');
				return false;
			}
		} else {
			var_dump('Failed! Bid price must be numeric.');
			return false;
		}
	}
}