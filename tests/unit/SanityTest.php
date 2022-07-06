<?php declare (strict_types = 1);

use PHPUnit\Framework\TestCase;

class SanityTest extends TestCase
{
    protected function setUp(): void
    {
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_Phpunit_Is_Working(): void
    {
        $this->assertTrue(true);
    }
}

