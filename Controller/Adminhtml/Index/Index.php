<?php
namespace LoopDeveloper\MiniTracker\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
            \Magento\Backend\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
            parent::__construct($context);
            $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * 
     * @return type
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Minitracker Listing')));
        return $resultPage;
    }
}