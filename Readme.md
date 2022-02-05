# Suplias PHP UNIT testing challenge

## Requirements

- [Composer](https://getcomposer.org/)
- Powershell CLI or any other alternative (Gitbash)

Run this command to install the PHP UNIT testing package

`$ composer install`

Next, run this command to setup autoloading properly

`$ composer dump-autoload -o`

Afterwards, run this command to execute tests

`$ ./vendor/bin/phpunit .\tests\PseudoCrudTest.php --color`

If you run into an error, try running this command instead

`$  ./vendor/bin/phpunit ./tests/PseudoCrudTest.php --color`

> You should get an output like this
>![success-test](assets/images/success.png)
