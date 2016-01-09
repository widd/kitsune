# Kitsune
A PHP implementation of Club Penguin's latest protocol.

## Prerequisites
* PHP version ≥ 5.6
  * PHP 5.6 (as of writing this) is bundled with [XAMPP](https://www.apachefriends.org/).
  * You'll want to install or enable the cURL extension, which may involve installing the ```php5-curl``` package on GNU/Linux distributions.
* MySQL server
  * MariaDB (which works) is also bundled with XAMPP.
* [Composer](https://getcomposer.org/)
  * We use Composer to manage Kitsune's dependencies, such as Propel.

## Configuration
Edit **Database.xml** to conform to your database installation.

## Installation
Install all of the required dependencies by running the ``` composer install ``` command.
