<?php
namespace LoopDeveloper\MiniTracker\Observer;
use Magento\Framework\Event\ObserverInterface;

class Tracker implements ObserverInterface
{
    protected $tracterFactory;
    protected $logger;
    protected $scopeConfig;
    protected $curl;
    protected $storeManager;
    const MINITRACKER_POST_URL = 'minitracker/tracker/service_url';
    const IS_ENABLE = 'minitracker/tracker/enable';
    public function __construct(
        \LoopDeveloper\MiniTracker\Model\MiniTrackerFactory $minitracter,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\HTTP\Client\Curl $curl)
    {
        $this->tracterFactory = $minitracter;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->curl = $curl;
    }
    
    /**
     * function to get system configuration value of service post url
     * @return type
     */
    public function getTrackerUrl(){
        $storeId = $this->storeManager->getStore()->getId();
        return $this->scopeConfig->getValue(self::MINITRACKER_POST_URL,\Magento\Store\Model\ScopeInterface::SCOPE_STORE,$storeId);
    }
    
    /**
     * function to check if module is enable
     * @return type
     */
    public function isEnable(){
        $storeId = $this->storeManager->getStore()->getId();
        return $this->scopeConfig->getValue(self::IS_ENABLE,\Magento\Store\Model\ScopeInterface::SCOPE_STORE,$storeId);
    }
    
    /**
     * 
     * @param string $url
     * @param string $params
     * @return string
     */
    public function curl($url,$params){
        $this->curl->setOption(CURLOPT_TIMEOUT,0);
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->curl->setOption(CURLOPT_ENCODING,'');
        $this->curl->setOption(CURLOPT_MAXREDIRS,10);
        $this->curl->setOption(CURLOPT_FOLLOWLOCATION, true);
        $this->curl->setOption(CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $this->curl->post($url,$params);
        $response = $this->curl->getBody();
        return $response;
    }
    
    /**
     * 
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $itemData = $observer->getEvent()->getData('quote_item');            
        $item = ( $itemData->getParentItem() ? $itemData->getParentItem() : $itemData );
        if($this->isEnable()){
            $price = $item->getPrice();
            $sku = $item->getSku();
            try{
                $url = $this->getTrackerUrl();
                $params = json_encode(['sku'=>$sku,'price'=>$price]);
                $response = $this->curl($url,$params);
                $result = json_decode($response,true);
                $this->logger->info('MiniTracker Result '.$response);
                $tracker = $this->tracterFactory->create();
                $tracker->setSku($sku);
                $tracker->setTrackingCode($result['code']);
                $tracker->setTrackingMessage($result['message']);
                $tracker->save();
            } catch(\Exception $e){
                $this->logger->info('MiniTracker Error '.$e->getMessage());
            }
        }
    }
}