<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Communication\Plugin;

use Xervice\Core\Plugin\AbstractCommunicationPlugin;
use Xervice\Kernel\Business\Model\Service\ServiceProviderInterface;
use Xervice\Kernel\Business\Plugin\BootInterface;


/**
 * @method \Xervice\RabbitMQ\Business\RabbitMQFacade getFacade()
 */
class RabbitMqService extends AbstractCommunicationPlugin implements BootInterface
{
    /**
     * @param \Xervice\Kernel\Business\Model\Service\ServiceProviderInterface $serviceProvider
     *
     */
    public function boot(ServiceProviderInterface $serviceProvider): void
    {
        $this->getFacade()->init();
    }
}