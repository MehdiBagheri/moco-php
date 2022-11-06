<?php

namespace Functional\Service\Account;

use Functional\Service\AbstractServiceTest;
use Moco\Entity\HourlyRate;
use Moco\Exception\NotFoundException;

class HourlyRatesServiceTest extends AbstractServiceTest
{
    public function testGet(): void
    {
        $hourlyRates = $this->mocoClient->account->hourlyRates->get();
        $this->assertInstanceOf(HourlyRate::class, $hourlyRates);

        $this->expectException(NotFoundException::class);
        $this->mocoClient->account->hourlyRates->get(['company_id' => 123]);
    }
}
