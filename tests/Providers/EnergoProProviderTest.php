<?php

namespace Smetka\Tests\Providers;

use Mockery as m;
use Smetka\Providers\EnergoProProvider;
use Symfony\Component\DomCrawler\Crawler;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class EnergoProProviderTest extends MockeryTestCase
{
    public function testGetMiltipleBills()
    {
        $crawler = new Crawler();
        $crawler->addContent(file_get_contents(__DIR__ . '/responses/energo-pro.html'));

        $provider = m::mock(EnergoProProvider::class, [['client_number' => '1234567890']]);
        $provider->makePartial();
        $provider->shouldAllowMockingProtectedMethods();
        $provider->shouldReceive('doRequest')->once()->andReturn($crawler);

        $expectedBills = [
            ['amount' => 44.84, 'subscriber_number' => '3213213213', 'invoice_date' => '09.01.2018', 'invoice_due_date' => '17.01.2018'],
            ['amount' => 50.48, 'subscriber_number' => '1231231231', 'invoice_date' => '09.02.2018', 'invoice_due_date' => '17.02.2018'],
        ];

        $this->assertEquals($expectedBills, $provider->getBills());
    }

    public function testGetBillsForASubscriberNumber()
    {
        $crawler = new Crawler();
        $crawler->addContent(file_get_contents(__DIR__ . '/responses/energo-pro.html'));

        $provider = m::mock(EnergoProProvider::class, [['client_number' => '1234567890', 'subscriber_number' => '3213213213']]);
        $provider->makePartial();
        $provider->shouldAllowMockingProtectedMethods();
        $provider->shouldReceive('doRequest')->once()->andReturn($crawler);

        $expectedBills = [
            ['amount' => 44.84, 'subscriber_number' => '3213213213', 'invoice_date' => '09.01.2018', 'invoice_due_date' => '17.01.2018'],
        ];

        $this->assertEquals($expectedBills, $provider->getBills());
    }
}
