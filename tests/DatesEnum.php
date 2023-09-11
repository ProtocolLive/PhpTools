<?php
require(dirname(__DIR__) . '/src/upgrades.php');
require(dirname(__DIR__) . '/src/enum/DateType.php');

echo DatesEnum(
  '/',
  DateType::Day,
  DateType::Month,
  DateType::Year
);