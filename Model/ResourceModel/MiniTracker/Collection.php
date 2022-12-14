<?php
namespace LoopDeveloper\MiniTracker\Model\ResourceModel\MiniTracker;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'loopdeveloper_minitracker_collection';
    protected $_eventObject = 'minitracker_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('LoopDeveloper\MiniTracker\Model\MiniTracker', 'LoopDeveloper\MiniTracker\Model\ResourceModel\MiniTracker');
    }

}