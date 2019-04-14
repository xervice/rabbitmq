<?php
declare(strict_types=1);

namespace XerviceTest\RabbitMQ;

use DataProvider\RabbitMqExchangeDataProvider;
use DataProvider\RabbitMqMessageCollectionDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use DataProvider\SimpleMessageDataProvider;
use Xervice\Core\Business\Model\Locator\Dynamic\Business\DynamicBusinessLocator;
use Xervice\Core\Business\Model\Locator\Locator;
use Xervice\DataProvider\Business\DataProviderFacade;

require_once __DIR__ . '/TestInjector/RabbitMQDependencyProvider.php';

/**
 * @method \Xervice\RabbitMQ\Business\RabbitMQFacade getFacade()
 * @method \Xervice\RabbitMQ\Business\RabbitMQBusinessFactory getFactory()
 */
class IntegrationTest extends \Codeception\Test\Unit
{
    use DynamicBusinessLocator;

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
        $this->getFacade()->reconnect();

        $exchange = new RabbitMqExchangeDataProvider();
        $exchange->setName('UnitTest');

        $simpleMessage = new SimpleMessageDataProvider();
        $simpleMessage->setMessage('TestMessage');

        $testMessage = new RabbitMqMessageDataProvider();
        $testMessage
            ->setExchange($exchange)
            ->setMessage($simpleMessage);

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

        $simpleMessage = new SimpleMessageDataProvider();
        $simpleMessage->setMessage('TestMessage');

        $messageCollection = new RabbitMqMessageCollectionDataProvider();
        for ($i=1; $i<=450; $i++) {
            $testMessage = new RabbitMqMessageDataProvider();
            $testMessage
                ->setExchange($exchange)
                ->setMessage($simpleMessage);

            $messageCollection->addMessage($testMessage);
        }

        $this->getFacade()->sendMessages($messageCollection);

        ob_start();
        $this->getFacade()->runWorker();
        $response = ob_get_contents();
        ob_end_clean();

        $this->assertEquals(
            $this->getExpectedTestMessage(450),
            $response
        );

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
     * @return \Xervice\DataProvider\Business\DataProviderFacade
     */
    private function getDataProviderFacade(): DataProviderFacade
    {
        return Locator::getInstance()->dataProvider()->facade();
    }

    /**
     * @return string
     */
    private function getExpectedTestMessage(int $count): string
    {
        $expected = '';
        for ($i = 1; $i <= $count; $i++) {
            $expected .= 'TestMessage';
        }

        return $expected;
    }
}