<?php

namespace Tests\DAMA\DoctrineTestBundle\Doctrine\DBAL;

use DAMA\DoctrineTestBundle\Doctrine\DBAL\StaticConnection;
use DAMA\DoctrineTestBundle\Doctrine\DBAL\StaticDriver;
use PHPUnit\Framework\TestCase;

class StaticDriverTest extends TestCase
{
    public function testConnect()
    {
        $driver = new StaticDriver();

        $driver::setKeepStaticConnections(true);
        $driver::setUnderlyingDriverClass(MockDriver::class);

        $connection1 = $driver->connect(['database_name' => 1], 'user1', 'pw1');
        $connection2 = $driver->connect(['database_name' => 2], 'user1', 'pw2');

        $this->assertInstanceOf(StaticConnection::class, $connection1);
        $this->assertNotSame($connection1->getWrappedConnection(), $connection2->getWrappedConnection());

        $driver = new StaticDriver();

        $connectionNew1 = $driver->connect(['database_name' => 1], 'user1', 'pw1');
        $connectionNew2 = $driver->connect(['database_name' => 2], 'user1', 'pw2');

        $this->assertSame($connection1->getWrappedConnection(), $connectionNew1->getWrappedConnection());
        $this->assertSame($connection2->getWrappedConnection(), $connectionNew2->getWrappedConnection());
    }
}
