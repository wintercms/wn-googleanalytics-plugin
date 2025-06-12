<?php namespace Winter\GoogleAnalytics\Tests;

use Illuminate\Support\Facades\App;
use Winter\GoogleAnalytics\Classes\MeasurementProtocolService;

if (class_exists('System\Tests\Bootstrap\PluginTestCase')) {
    class BaseTestCase extends \System\Tests\Bootstrap\PluginTestCase
    {
    }
} else {
    class BaseTestCase extends \PluginTestCase
    {
    }
}

/**
 * Test the MeasurementProtocolService
 * 
 * This test verifies that the service correctly communicates with the GA4 layer
 * for sending events to Google Analytics 4.
 */
class MeasurementProtocolServiceTest extends BaseTestCase
{
    /**
     * @var array Plugins to refresh between tests.
     */
    protected $refreshPlugins = [
        'Winter.GoogleAnalytics',
    ];

    /**
     * Set up the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $mockGA4 = \Mockery::mock('GA4');
        App::instance('ga4', $mockGA4);

        $mockGA4->shouldReceive('sendEvent')
            ->andReturn(['status' => true])
            ->byDefault();
    }

    /**
     * Test that the service correctly passes event data to GA4.
     */
    public function testSendEventPassesDataToGA4(): void
    {
        $mockGA4 = App::make('ga4');

        $mockGA4->shouldReceive('sendEvent')
            ->once()
            ->with(\Mockery::on(function ($data) {
                return $data['name'] === 'test_event' 
                    && $data['test_param'] === 'test_value'
                    && !empty($data['client_id']);
            }))
            ->andReturn(['status' => true]);

        $service = new MeasurementProtocolService();

        $result = $service->sendEvent('test_event', [
            'test_param' => 'test_value'
        ]);

        $this->assertEquals(['status' => true], $result);
    }

    /**
     * Test that the service generates a client ID when none is provided.
     */
    public function testGeneratesClientIdWhenNotProvided(): void
    {
        $capturedClientIds = [];

        $mockGA4 = App::make('ga4');

        $mockGA4->shouldReceive('sendEvent')
            ->twice()
            ->with(\Mockery::on(function ($data) use (&$capturedClientIds) {
                $capturedClientIds[] = $data['client_id'];

                return true;
            }))
            ->andReturn(['status' => true]);

        $service = new MeasurementProtocolService();
        $service->sendEvent('test1');
        $service->sendEvent('test2');

        $this->assertCount(2, $capturedClientIds);
        $this->assertNotEquals($capturedClientIds[0], $capturedClientIds[1]);
    }

    /**
     * Clean up the test environment.
     *
     * @return void
     */
    public function tearDown(): void
    {
        \Mockery::close();

        parent::tearDown();
    }
}
