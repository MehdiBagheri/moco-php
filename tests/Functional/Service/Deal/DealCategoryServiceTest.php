<?php

declare(strict_types=1);

namespace Functional\Service\Deal;

use Functional\Service\AbstractServiceTest;
use Moco\Entity\DealCategory;

class DealCategoryServiceTest extends AbstractServiceTest
{
    private array $params = [
        'name' => 'new deal category',
        'probability' => 15
    ];

    public function testCreate(): int
    {
        $dealCategory = $this->mocoClient->dealCategory->create($this->params);
        $this->assertInstanceOf(DealCategory::class, $dealCategory);
        $this->assertEquals('new deal category', $dealCategory->name);
        return $dealCategory->id;
    }

    /**
     * @depends testCreate
     */
    public function testGetDealCategories(): void
    {
        $deals = $this->mocoClient->dealCategory->get();
        $this->assertIsArray($deals);
    }

    /**
     * @depends testCreate
     */
    public function testGet(int $dealId): int
    {
        $deal = $this->mocoClient->dealCategory->get($dealId);
        $this->assertInstanceOf(DealCategory::class, $deal);
        $this->assertEquals($dealId, $deal->id);
        return $deal->id;
    }

    /**
     * @depends testGet
     */
    public function testUpdate(int $dealId): int
    {
        $deal = $this->mocoClient->dealCategory->update($dealId, ['name' => 'updated']);
        $this->assertInstanceOf(DealCategory::class, $deal);
        $this->assertEquals('updated', $deal->name);
        return $deal->id;
    }

    /**
     * @depends testUpdate
     */
    public function testDelete(int $dealId): void
    {
        $this->assertNull($this->mocoClient->dealCategory->delete($dealId));
    }
}
