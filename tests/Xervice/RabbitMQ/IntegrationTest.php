<?php
namespace XerviceTest\RabbitMQ;

use Xervice\Core\Facade\FacadeInterface;
use Xervice\Core\Locator\Dynamic\DynamicLocator;
use Xervice\Core\Locator\Locator;
use Xervice\DataProvider\DataProviderFacade;

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
//        $this->getDataProviderFacade()->generateDataProvider();
        $this->getFacade()->init();
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {

    }

    /**
     * @return \Xervice\DataProvider\DataProviderFacade
     */
    private function getDataProviderFacade(): DataProviderFacade
    {
        return Locator::getInstance()->dataProvider()->facade();
    }
}