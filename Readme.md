# AssertThrows

Basic assertions for exceptions without stopping the test.
Works with PHPUnit and Codeception.

## Usage

Wait for exception thrown inside a code block.

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