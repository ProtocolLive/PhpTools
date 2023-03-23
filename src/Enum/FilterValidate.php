<?php
//2023.03.23.00

/**
 * @link https://www.php.net/manual/en/filter.filters.validate.php
 */
enum FilterValidate:int{
  case Bool = FILTER_VALIDATE_BOOLEAN;
  case Domain = FILTER_VALIDATE_DOMAIN;
  case Email = FILTER_VALIDATE_EMAIL;
  case Float = FILTER_VALIDATE_FLOAT;
  case Int = FILTER_VALIDATE_INT;
  case Ip = FILTER_VALIDATE_IP;
  case Mac = FILTER_VALIDATE_MAC;
  case Regex = FILTER_VALIDATE_REGEXP;
  case Url = FILTER_VALIDATE_URL;
}