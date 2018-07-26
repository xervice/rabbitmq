<?php
namespace XerviceTest\RabbitMQ;

use Xervice\Core\Locator\Dynamic\DynamicLocator;
use Xervice\Core\Locator\Locator;
use Xervice\DataProvider\DataProviderFacade;

require_once __DIR__ . '/TestInjector/RabbitMQDependencyProvider.php';

/**
 * @method \Xervice\RabbitMQ\RabbitMQFacade getFacade()
 */
class IntegrationTest extends \Codeception\Test\Unit
{
    use DynamicLocator;

    /**
     * @var \XerviceTest\XerviceTester
     */
    protected $tester;
    
    protected function _before()
    {
        $this->getDataProviderFacade()->generateDataProvider();
    }

    // tests
    public function testRabbitMqConnection()
    {
        $this->getFacade()->init();
    }

    /**
     * @return \Xervice\DataProvider\DataProviderFacade
     */
    private function getDataProviderFacade(): DataProviderFacade
    {
        return Locator::getInstance()->dataProvider()->facade();
    }
}