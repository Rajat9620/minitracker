<?php
namespace LoopDeveloper\MiniTracker\Model;
class MiniTracker extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface{
    const CACHE_TAG = 'loopdeveloper_minitracker';
    protected $_cacheTag = 'loopdeveloper_minitracker';
    protected $_eventPrefix = 'loopdeveloper_minitracker';

    protected function _construct(){
        $this->_init('LoopDeveloper\MiniTracker\Model\ResourceModel\MiniTracker');
    }

    public function getIdentities(){
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}