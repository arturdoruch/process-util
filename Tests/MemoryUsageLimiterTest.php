<?php

namespace ArturDoruch\ProcessUtil\Tests;

use ArturDoruch\ProcessUtil\MemoryUsageLimiter;
use PHPUnit\Framework\TestCase;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class MemoryUsageLimiterTest extends TestCase
{
    public function testLimitNotExceeded()
    {
        $this->expectNotToPerformAssertions();
        $memoryUsageLimiter = new MemoryUsageLimiter(40, 'MB');
        $memoryUsageLimiter->check();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testLimitExceeded()
    {
        $memoryUsageLimiter = new MemoryUsageLimiter(100, 'KB');
        $memoryUsageLimiter->check();
    }
}
