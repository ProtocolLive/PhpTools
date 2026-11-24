<?php
require(dirname(__DIR__) . '/src/upgrades.php');
require(dirname(__DIR__) . '/src/enum/DateType.php');
/**
 * @author Protocol Corporation Ltda.
 * @link https://github.com/ProtocolLive/PhpTools
 * @version 2026.11.24.00
 * @php-min-ver 8.1
 */


echo DatesEnum(
  '/',
  DateType::Day,
  DateType::Month,
  DateType::Year
);