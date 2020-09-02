<?php declare(strict_types=1);

namespace Codeception;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\AssertionFailedError;
use Throwable;

trait AssertThrows
{
    /**
     * @param string|null $message
     * @param Throwable $exception
     */
    private function checkException(?string $message, Throwable $exception)
    {
        $actualMessage = strtolower($exception->getMessage());

        if (!$message || $message === $actualMessage) {
            return;
        }

        throw new AssertionFailedError(
            sprintf(
                "Exception message '%s' was expected, but '%s' was received",
                $message,
                $actualMessage
            )
        );
    }

    /**
     * Asserts that callback throws an exception
     *
     * @param $throws
     * @param callable $fn
     * @throws Throwable
     */
    public function assertThrows($throws, callable $fn)
    {
        $this->assertThrowsWithMessage($throws, null, $fn);
    }

    /**
     * Asserts that callback throws an exception with a message
     *
     * @param string|Throwable $throws
     * @param string|null $message
     * @param callable $fn
     * @throws Throwable
     */
    public function assertThrowsWithMessage($throws, ?string $message, callable $fn)
    {
        if ($throws instanceof Throwable) {
            $message = $throws->getMessage();
            $throws = get_class($throws);
        }

        if ($message) {
            $message = strtolower($message);
        }

        try {
            call_user_func($fn);
        } catch (AssertionFailedError $exception) {

            if ($throws !== get_class($exception)) {
                throw $exception;
            }

            $this->checkException($message, $exception);

        } catch (Throwable $exception) {

            if (!$throws) {
                throw $exception;
            }

            $actualThrows = get_class($exception);

            if ($throws !== $actualThrows) {
                throw new AssertionFailedError(
                    sprintf(
                        "Exception '%s' was expected, but '%s' was thrown with message '%s'",
                        $throws,
                        get_class($exception),
                        $exception->getMessage()
                    )
                );
            }

            $this->checkException($message, $exception);
        }

        if (!$throws) {
            return;
        }

        if (isset($exception)) {
            Assert::assertTrue(true, 'Exception handled');
            return;
        }

        throw new AssertionFailedError(
            sprintf("Exception '%s' was not thrown as expected", $throws)
        );
    }

    /**
     * Asserts that callback does not throws an exception
     *
     * @param null|string|Throwable $throws
     * @param callable $fn
     */
    public function assertDoesNotThrow($throws, callable $fn)
    {
        $this->assertDoesNotThrowWithMessage($throws, null, $fn);
    }

    /**
     * Asserts that callback does not throws an exception with a message
     *
     * @param null|string|Throwable $throws
     * @param string|null $message
     * @param callable $fn
     */
    public function assertDoesNotThrowWithMessage($throws, ?string $message, callable $fn)
    {
        if ($throws instanceof Throwable) {
            $message = $throws->getMessage();
            $throws = get_class($throws);
        }

        try {
            call_user_func($fn);
        } catch (Throwable $exception) {
            if (!$throws) {
                throw new AssertionFailedError('Exception was not expected to be thrown');
            }

            $actualThrows = get_class($exception);

            if ($throws != $actualThrows) {
                Assert::assertNotSame($throws, $actualThrows);
                return;
            }

            if (!$message) {
                throw new AssertionFailedError(
                    sprintf("Exception '%s' was not expected to be thrown", $throws)
                );
            }

            $actualMessage = $exception->getMessage();

            if ($message != $actualMessage) {
                Assert::assertNotSame($message, $actualMessage);
                return;
            }

            throw new AssertionFailedError(
                sprintf("Exception '%s' with message '%s' was not expected to be thrown", $throws, $message)
            );
        }
    }
}