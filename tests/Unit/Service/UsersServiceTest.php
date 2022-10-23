<?php

namespace Unit\Service;

use Moco\Exception\InvalidRequestException;
use Moco\Exception\InvalidResponseException;

class UsersServiceTest extends AbstractServiceTest
{
    private array $createParams = [
        'firstname'    => 'ft_firstname',
        'lastname'     => 'ft_lastname',
        'email'        => 'bagherii.mahdii@gmail.com',
        'password'     => 'ft_password',
        'unit_id'      => 909177709,
        'active'       => true,
        'language'     => 'de',
        'mobile_phone' => '+41 79 123 45 67',
        'work_phone'   => '+41 44 123 45 67',
        'home_address' => "Peter Müller\nBeispielstrasse 123\nBeispielstadt",
        'bday'         => '1975-01-17',
        'tags'         => ["Deutschland"],
        'info'         => 'info',
    ];

    public function testCreate()
    {
        $this->mockResponse(200, json_encode($this->createParams));
        $user = $this->mocoClient->users->create($this->createParams);
        $this->assertEquals('ft_firstname', $user->firstname);
    }

    /**
     * @depends testCreate
     */
    public function testCreateInvalidRequestException()
    {
        $params = $this->createParams;
        unset($params['firstname']);
        $this->expectException(InvalidRequestException::class);
        $this->mocoClient->users->create($params);
    }

    public function testCreateInvalidResponseException()
    {
        $this->mockResponse(500);
        $this->expectException(InvalidResponseException::class);
        $this->mocoClient->users->create($this->createParams);
    }

    public function testGet()
    {
        $this->mockResponse(200, json_encode($this->createParams));
        $user = $this->mocoClient->users->get(123);
        $this->assertEquals('ft_firstname', $user->firstname);

        $this->mockResponse(200, json_encode([$this->createParams]));
        $users = $this->mocoClient->users->get();
        $this->assertEquals('ft_firstname', $users[0]->firstname);

        $this->mockResponse(404);
        $this->expectException(InvalidRequestException::class);
        $this->mocoClient->users->get(1234);
    }

    public function testUpdate()
    {
        $params = $this->createParams;
        $params['firstname'] = 'changed';
        $this->mockResponse(200, json_encode($params));
        $user = $this->mocoClient->users->update(123, $params);
        $this->assertEquals('changed', $user->firstname);

        $this->mockResponse(404);
        $this->expectException(InvalidRequestException::class);
        $this->mocoClient->users->update(1234, $params);
    }

    public function testDelete()
    {
        $this->mockResponse(204);
        $this->assertNull($this->mocoClient->users->delete(123));
    }

    public function testGetPerformanceReport()
    {
        $this->mockResponse(200, json_encode(['annually' => ['year' => 2022]]));
        $response = $this->mocoClient->users->getPerformanceReport(123);
        $this->assertEquals(2022, $response->annually->year);
    }
}
