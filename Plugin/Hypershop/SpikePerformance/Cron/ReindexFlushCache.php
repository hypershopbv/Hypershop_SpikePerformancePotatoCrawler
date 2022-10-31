<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformancePotatoCrawler\Plugin\Hypershop\SpikePerformance\Cron;

use Exception;
use Hypershop\SpikePerformance\Cron\ReindexFlushCache as SpikePerformanceReindexFlushCache;
use Hypershop\SpikePerformancePotatoCrawler\Helper\Config;
use Potato\Crawler\Model\Cron\Queue;
use Potato\Crawler\Model\Cron\Warmer;

class ReindexFlushCache
{
    /**
     * @var Config
     */
    private $spikePerformanceConfig;
    /**
     * @var Warmer
     */
    private $warmer;
    /**
     * @var Queue
     */
    private $queue;

    /**
     * @param Config $spikePerformanceConfig
     * @param Warmer $warmer
     * @param Queue $queue
     */
    public function __construct(
        Config $spikePerformanceConfig,
        Warmer $warmer,
        Queue $queue
    ) {
        $this->spikePerformanceConfig = $spikePerformanceConfig;
        $this->warmer = $warmer;
        $this->queue = $queue;
    }

    /**
     * @param SpikePerformanceReindexFlushCache $subject
     * @param $result
     * @return mixed
     * @throws Exception
     */
    public function afterExecute(
        SpikePerformanceReindexFlushCache $subject,
        $result
    ) {
        if (!$this->spikePerformanceConfig->getIsPotatoCrawlerAfterCronEnabled()) {
            return $result;
        }

        // Queue pages
        $this->queue();
        // Run warmer
        $this->warm();

        return $result;
    }

    /**
     * Start PO Crawler Queue
     *
     * @throws Exception
     */
    private function queue()
    {
        $this->queue->process();
    }

    /**
     * Start PO Crawler Warmer
     *
     * @throws Exception
     */
    private function warm()
    {
        $this->warmer->process();
    }
}
