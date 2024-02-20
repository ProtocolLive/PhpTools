<?php

/**
 * @link https://www.php.net/manual/en/filter.filters.validate.php
 * @version 2024.02.20.00
 */
enum FilterValidate:int{
  case Bool = FILTER_VALIDATE_BOOLEAN;
  case Day = -4;
  case Domain = FILTER_VALIDATE_DOMAIN;
  case Email = FILTER_VALIDATE_EMAIL;
  case Float = FILTER_VALIDATE_FLOAT;
  case FloatPositive = -3;
  case Id = -2;
  case Int = FILTER_VALIDATE_INT;
  case IntPositive = -1;
  case Ip = FILTER_VALIDATE_IP;
  case Mac = FILTER_VALIDATE_MAC;
  case Month = -5;
  case Regex = FILTER_VALIDATE_REGEXP;
  case Url = FILTER_VALIDATE_URL;
}