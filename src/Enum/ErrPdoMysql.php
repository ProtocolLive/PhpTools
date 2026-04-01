<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools

/**
 * @version 2026.03.29.00
 */
enum ErrPdoMysql:string{
  case ColumnNotFound = '42S22';
  case IndexNotFound = 'HY000';
  case Permissions = '42000';
  case TableNotFoud = '42S02';
  case IntegrityViolation = '23000';
  case LockTime = '1205';
}