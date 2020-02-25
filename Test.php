<?php
include 'api/config/database.php';
use PHPUnit\Framework\TestCase;
use doo\dd;
class Test extends TestCase
{
    public function testEmpty()
    {
        $this->assertFalse(empty(Database::getInstance()));
    }
}
