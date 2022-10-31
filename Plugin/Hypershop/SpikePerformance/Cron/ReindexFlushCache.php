<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformancePotatoCrawler\Plugin\Hypershop\SpikePerformance\Cron;

use Exception;
use Hypershop\SpikePerformance\Cron\ReindexFlushCache as SpikePerformanceReindexFlushCache;
use Hypershop\SpikePerformancePotatoCrawler\Helper\Config;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class ReindexFlushCache
{
    /**
     * @var Config
     */
    private $spikePerformanceConfig;

    public function __construct(
        Config $spikePerformanceConfig
    ) {
        $this->spikePerformanceConfig = $spikePerformanceConfig;
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

        die('hier');

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
        $application = new Cli('Magento CLI');
        $input = new ArrayInput(['command' => 'po_crawler:queue']);
        $output = new NullOutput();

        try {
            $application->run($input, $output);
        } catch (Exception $e) {}
    }

    /**
     * Start PO Crawler Wamer
     *
     * @throws Exception
     */
    private function warm()
    {
        $application = new Cli('Magento CLI');
        $input = new ArrayInput(['command' => 'po_crawler:warmer']);
        $output = new NullOutput();

        try {
            $application->run($input, $output);
        } catch (Exception $e) {}
    }
}
