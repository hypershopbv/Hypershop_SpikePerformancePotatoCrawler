<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformancePotatoCrawler\Helper;

use Hypershop\SpikePerformance\Helper\Config as SpikePerformanceConfig;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class Config extends AbstractHelper
{
    /**
     * @var SpikePerformanceConfig
     */
    private $spikePerformanceHelper;

    /**
     * @param Context $context
     * @param SpikePerformanceConfig $spikePerformanceHelper
     */
    public function __construct(
        Context $context,
        SpikePerformanceConfig $spikePerformanceHelper
    ) {
        parent::__construct($context);
        $this->spikePerformanceHelper = $spikePerformanceHelper;
    }

    /**
     * Checks if Potato Crawler setting is enabled
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function getIsPotatoCrawlerAfterCronEnabled(): bool
    {
        return $this->spikePerformanceHelper->getConfigValueByKey('potato_crawler_after_cron');
    }
}
