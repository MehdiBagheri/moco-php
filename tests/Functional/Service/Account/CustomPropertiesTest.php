<?php

namespace Functional\Service\Account;

use Functional\Service\AbstractServiceTest;

class CustomPropertiesTest extends AbstractServiceTest
{
    public function testGet(): void
    {
        $customProperties = $this->mocoClient->account->customProperties->get();
        $this->assertIsArray($customProperties);
    }
}
