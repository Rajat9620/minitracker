<?php 
namespace LoopDeveloper\MiniTracker\Model\Api; 
use Psr\Log\LoggerInterface;
class MiniTracker
{
    protected $logger;
    protected $tracterFactory;
    public function __construct(
        LoggerInterface $logger,
        \LoopDeveloper\MiniTracker\Model\MiniTrackerFactory $minitracter
    )
    {
        $this->logger = $logger;
        $this->tracterFactory = $minitracter;
    }
 
    /**
     * @inheritdoc
     */
    public function getData()
    {
        $response = [];
        try {
            $collections = $this->tracterFactory->create()->getCollection();
            foreach($collections as $collection){
                $items[] = $collection->getData();
                $response['items'][] = $items;
                unset($items);
            }
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            $this->logger->info($e->getMessage());
        }
        $returnArray = json_encode($response);
        return $returnArray; 
    }
}