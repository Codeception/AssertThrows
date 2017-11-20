# AssertThrows

[![Build Status](https://travis-ci.org/Codeception/AssertThrows.svg?branch=master)](https://travis-ci.org/Codeception/AssertThrows)

Expect exceptions inside a tests without a stop!

Assertions for exceptions. Works with PHPUnit and Codeception.

## Usage

Catch exception thrown inside a code block.

```php
<?php
$this->assertThrows(NotFoundException::class, function() {
	$this->userController->show(999);
});

// alternatively
$this->assertThrows(new NotFoundException, function() {
	$this->userController->show(999);
});
?>
```

You can optionally test the exception message:

```php
<?php
$this->assertThrowsWithMessage(NotFoundException::class, 'my error message', function() {
	throw new NotFoundException('my error message');
});
?>
```

### Installation

```php
composer require codeception/assert-throws --dev
```

Include `AssertThrows` trait it to a TestCase:

```php
<?php
class MyTest extends PHPUnit\Framework\TestCase
{
    use Codeception\AssertThrows;

} 
```

## License MIT