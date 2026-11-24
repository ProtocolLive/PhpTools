<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools

/**
 * @version 2026.10.29.00
 */
enum SessionStatusEnum:int{
  case Disabled = PHP_SESSION_DISABLED;
  case None = PHP_SESSION_NONE;
  case Active = PHP_SESSION_ACTIVE;
}