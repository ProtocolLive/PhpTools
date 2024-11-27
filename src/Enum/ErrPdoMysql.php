<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools

/**
 * @version 2024.11.26.00
 */
enum ErrPdoMysql:string{
  case NotFoud = '42S02';
  case Permissions = '42000';
}