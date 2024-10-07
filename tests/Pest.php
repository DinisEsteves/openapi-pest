<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use League\OpenAPIValidation\PSR7\OperationAddress;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use PHPUnit\Framework\Assert;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

expect()->extend('toMatchOpenApiSpecResponse', function (string $path, string $method) {
    $operation = new OperationAddress($path, $method);

    $validator = (new ValidatorBuilder)
        ->fromYamlFile('spec.yml')
        ->getResponseValidator();

    try {
        $validator->validate($operation, $this->value);
    } catch (\Exception $e) {
        test()->fail($e->getMessage());
    }

    Assert::assertTrue(true);
});

expect()->extend('toMatchOpenApiSpecRequest', function () {
    $validator = (new ValidatorBuilder)
        ->fromYamlFile('spec.yml')
        ->getRequestValidator();

    try {
        $validator->validate($this->value);
    } catch (Exception $e) {
        test()->fail($e->getMessage());
    }

    Assert::assertTrue(true);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}
