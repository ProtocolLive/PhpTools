<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools

/**
 * @link https://www.php.net/manual/en/function.filter-input.php
 * @version 2023.03.23.00
 */
enum FilterFrom:int{
  case Cookie = INPUT_COOKIE;
  case Env = INPUT_ENV;
  case Get = INPUT_GET;
  case Post = INPUT_POST;
  case Server = INPUT_SERVER;
}