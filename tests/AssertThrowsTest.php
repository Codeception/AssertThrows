<?php
use PHPUnit\Framework\AssertionFailedError;

class AssertThrowsTest extends PHPUnit\Framework\TestCase
{
    use \Codeception\AssertThrows;

    public function testBasicException()
    {
        $count = \PHPUnit\Framework\Assert::getCount();
        $this->assertThrows(MyException::class, function() {
            throw new MyException();
        });
        $this->assertTrue(true);
        $this->assertEquals($count + 2, \PHPUnit\Framework\Assert::getCount());
    }

    public function testExceptionWithMessage()
    {
        $this->assertThrowsWithMessage(MyException::class, "hello", function() {
            throw new MyException("hello");
        });
    }

    public function testExceptionMessageFails()
    {
        try {
            $this->assertThrowsWithMessage(MyException::class, "hello", function() {
                throw new MyException("hallo");
            });
        } catch (AssertionFailedError $e) {
            $this->assertEquals("exception message 'hello' was expected, but 'hallo' was received", $e->getMessage());
            return;
        }
        $this->fail("Ups :(");
    }

    public function testExceptionMessageCaseInsensitive()
    {
        $this->assertThrowsWithMessage(MyException::class, "Message and Expected Message CAN have different case", function() {
            throw new MyException("Message and expected message can have different case");
        });
    }

}

class MyException extends Exception {



}