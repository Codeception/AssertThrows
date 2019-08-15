<?php

namespace Codeception;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

trait AssertThrows
{

    /**
     * Asserts that callback throws an exception
     *
     * @param $throws
     * @param callable $fn
     * @throws \Exception
     */
    public function assertThrows($throws, callable $fn)
    {
        $this->assertThrowsWithMessage($throws, false, $fn);
    }

    /**
     * Asserts that callback throws an exception with a message
     *
     * @param $throws
     * @param $message
     * @param callable $fn
     */
    public function assertThrowsWithMessage($throws, $message, callable $fn)
    {
        /** @var $this TestCase  * */
        $result = $this->getTestResultObject();

        if (is_array($throws)) {
            $message = ($throws[1]) ? $throws[1] : false;
            $throws = $throws[0];
        }

        if (is_string($message)) {
            $message = strtolower($message);
        }

        try {
            call_user_func($fn);
        } catch (AssertionFailedError $e) {

            if ($throws !== get_class($e)) {
                throw $e;
            }

            if ($message !== false && $message !== strtolower($e->getMessage())) {
                throw new AssertionFailedError("exception message '$message' was expected, but '" . $e->getMessage() . "' was received");
            }

        } catch (\Exception $e) {
            if ($throws) {
                if ($throws !== get_class($e)) {
                    throw new AssertionFailedError("exception '$throws' was expected, but " . get_class($e) . ' was thrown');
                }

                if ($message !== false && $message !== strtolower($e->getMessage())) {
                    throw new AssertionFailedError("exception message '$message' was expected, but '" . $e->getMessage() . "' was received");
                }
            } else {
                throw $e;
            }
        }

        if ($throws) {
            if (isset($e)) {
                $this->assertTrue(true, 'exception handled');
            } else {
                throw new AssertionFailedError("exception '$throws' was not thrown as expected");
            }
        }

    }
}