<?php
//2023.03.23.00

/**
 * @link https://www.php.net/manual/en/function.filter-input.php
 */
enum FilterFrom:int{
  case Cookie = INPUT_COOKIE;
  case Env = INPUT_ENV;
  case Get = INPUT_GET;
  case Post = INPUT_POST;
  case Server = INPUT_SERVER;
}