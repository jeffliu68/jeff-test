<?php
namespace Jeff\Test\Controller\Adminhtml\Bid;

class Index extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;
	protected $_resultPage = null;
	protected $_resultPageFactory;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	) {
		parent::__construct($context);
		$this->_resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		//Call page factory to render layout and page content
		$this->_setPageData();
        return $this->getResultPage();
	}

	/*
	 * Check permission via ACL resource
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Jeff_Test::bid_manage');
	}

    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->_resultPageFactory->create();
        }
        return $this->_resultPage;
    }

    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->setActiveMenu('Jeff_Test::bid');
        $resultPage->getConfig()->getTitle()->prepend((__('Bids')));

        //Add bread crumb
        $resultPage->addBreadcrumb(__('Jeff'), __('Jeff'));
        $resultPage->addBreadcrumb(__('Test'), __('Test'));

        return $this;
    }


}