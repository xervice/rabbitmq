<?php
namespace XerviceTest\RabbitMQ;

use DataProvider\RabbitMqExchangeDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use DataProvider\RabbitMqQueueDataProvider;
use Xervice\Core\Factory\FactoryInterface;
use Xervice\Core\Locator\Dynamic\DynamicLocator;
use Xervice\Core\Locator\Locator;
use Xervice\DataProvider\DataProviderFacade;

require_once __DIR__ . '/TestInjector/RabbitMQDependencyProvider.php';

/**
 * @method \Xervice\RabbitMQ\RabbitMQFacade getFacade()
 * @method \Xervice\RabbitMQ\RabbitMQFactory getFactory()
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
        $this->getFacade()->init();
    }

    protected function _after()
    {
        $this->getFactory()->getConnectionProvider()->getChannel()->queue_delete('TestQueue');
        $this->getFactory()->getConnectionProvider()->getChannel()->exchange_delete('UnitTest');
    }


    /**
     * @group Xervice
     * @group RabbitMQ
     * @group Integration
     */
    public function testRabbitMqWorker()
    {
        $exchange = new RabbitMqExchangeDataProvider();
        $exchange->setName('UnitTest');

        $testMessage = new RabbitMqMessageDataProvider();
        $testMessage
            ->setExchange($exchange)
            ->setMessage('TestMessage');

        $this->getFacade()->sendMessage($testMessage);

        ob_start();
        $this->getFacade()->runWorker();
        $response = ob_get_contents();
        ob_end_clean();

        $this->assertEquals(
            'TestMessage',
            $response
        );
    }

    /**
     * @group Xervice
     * @group RabbitMQ
     * @group Integration
     */
    public function testRabbitMassWorker()
    {
        $exchange = new RabbitMqExchangeDataProvider();
        $exchange->setName('UnitTest');

        for ($i=1; $i<=1000; $i++) {
            $testMessage = new RabbitMqMessageDataProvider();
            $testMessage
                ->setExchange($exchange)
                ->setMessage('TestMessage');
            $this->getFacade()->sendMessage($testMessage);
        }

        $expected = '';
        for ($i=1; $i<=100; $i++) {
            $expected .= 'TestMessage';
        }

        for ($i=0; $i<10; $i++) {
            ob_start();
            $this->getFacade()->runWorker();
            $response = ob_get_contents();
            ob_end_clean();


            $this->assertEquals(
                $expected,
                $response
            );
        }

        ob_start();
        $this->getFacade()->runWorker();
        $response = ob_get_contents();
        ob_end_clean();


        $this->assertEquals(
            '',
            $response
        );
    }

    /**
     * @return \Xervice\DataProvider\DataProviderFacade
     */
    private function getDataProviderFacade(): DataProviderFacade
    {
        return Locator::getInstance()->dataProvider()->facade();
    }
}