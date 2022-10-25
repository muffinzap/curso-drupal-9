## Testing

Descargar módulo example:
```shell
composer require 'drupal/examples:^3.0'
```
Instalar módulo testing_example

```shell
drush en testing_example
```
Instalar las dependencias necesarias
```shell
composer require behat/mink
composer require behat/behat -W
composer require behat/mink-browserkit-driver
composer require phpunit/phpunit
composer requiresymfony/browser-kit
composer require symfony/phpunit-bridge
```
Crear web/core/phpunit.xml


Ejecutar los tests:
```shell
 phpunit --testsuite unit ./web/modules/contrib/examples/modules/testing_example/tests/src/Unit/Controller/ContrivedControllerTest.php --configuration /app/web/core/phpunit.xml --verbose --debug


phpunit --list-suites ./web/modules/contrib/examples/modules/testing_example/ --configuration /app/web/core/phpunit.xml


```
