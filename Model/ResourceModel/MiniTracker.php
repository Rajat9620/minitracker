<?php
namespace LoopDeveloper\MiniTracker\Model\ResourceModel;


class MiniTracker extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ){
        parent::__construct($context);
    }

    protected function _construct(){
        $this->_init('loopdeveloper_minitracker', 'entity_id');
    }
}