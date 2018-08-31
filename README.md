# Steps to reproduce
- clone this repository `git clone git@github.com:chubidu/phpunit-withConsecutive-failure.git`
- run `composer install`
- run `phpunit`

## The error output using the `phpunit 7.2.3` would look like this
```
$ phpunit
PHPUnit 7.3.2 by Sebastian Bergmann and contributors.

Testing Project Test Suite
F                                                                   1 / 1 (100%)

Time: 88 ms, Memory: 4.00MB

There was 1 failure:

1) App\Tests\Unit\Example\MyMessageHandlerTest::testInvoke
Expectation failed for method name is equal to "all" when invoked 4 time(s)
Parameter 0 for invocation #0 App\Example\Repository::all(Symfony\Component\HttpFoundation\ParameterBag Object (...)): array does not match expected value.
Failed asserting that two objects are equal.
--- Expected
+++ Actual
@@ @@
 Symfony\Component\HttpFoundation\ParameterBag Object (
     'parameters' => Array (
         'limit' => 10
-        'offset' => 0
+        'offset' => 10
     )
 )

/var/www/html/phpunit-with-consecutive/src/Example/MyMessageHandler.php:36
/var/www/html/phpunit-with-consecutive/tests/Unit/Example/MyMessageHandlerTest.php:20

FAILURES!
Tests: 1, Assertions: 0, Failures: 1.
```