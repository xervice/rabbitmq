<?php


namespace Xervice\RabbitMQ\Kernel;


use Xervice\Core\Locator\AbstractWithLocator;
use Xervice\Kernel\Business\Service\BootInterface;
use Xervice\Kernel\Business\Service\ServiceProviderInterface;

/**
 * @method \Xervice\RabbitMQ\RabbitMQFacade getFacade()
 */
class RabbitMqService extends AbstractWithLocator implements BootInterface
{
    /**
     * @param \Xervice\Kernel\Business\Service\ServiceProviderInterface $serviceProvider
     *
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
     */
    public function boot(ServiceProviderInterface $serviceProvider): void
    {
        $this->getFacade()->init();
    }
}