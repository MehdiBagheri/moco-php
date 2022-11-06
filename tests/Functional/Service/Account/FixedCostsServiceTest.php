<?php

namespace Functional\Service\Account;

use Functional\Service\AbstractServiceTest;

class FixedCostsServiceTest extends AbstractServiceTest
{
    public function testGet(): void
    {
        $costs = $this->mocoClient->account->fixedCosts->get();
        $this->assertIsArray($costs);
    }
}
