<?php
/**
 * @author Protocol Corporation Ltda.
 * @link https://github.com/ProtocolLive/PhpTools
 * @version 2026.11.24.01
 * @php-min-ver 8.1
 */

require(__DIR__ . '/../src/upgrades.php');
require(__DIR__ . '/../src/enum/DateType.php');

echo DatesEnum(
  '/',
  DateType::Day,
  DateType::Month,
  DateType::Year
);