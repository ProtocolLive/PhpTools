<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools
//2026.05.04.00

function Pkcs1ToX509(
  string $Key
):string|false{
  $lines = explode(PHP_EOL, $Key);
  if($lines[0] !== '-----BEGIN RSA PUBLIC KEY-----'):
    return false;
  endif;
  unset($lines[0]);
  array_pop($lines);
  $Key = implode('', $lines);
  $Key = base64_decode($Key);
  $Key = bin2hex($Key);
  $mod = substr($Key, 18, -10);
  $exp = substr($Key, -6);
  $Key = '30820122';//SEQUENCE (0x122 bytes = 290 bytes)
  $Key .= '300D';//SEQUENCE (0x0d bytes = 13 bytes)
  $Key .= '0609';//OBJECT IDENTIFIER (0x09 = 9 bytes)
  $Key .= '2A864886';
  $Key .= 'F70D010101';//hex encoding of 1.2.840.113549.1.1
  $Key .= '0500';//NULL (0 bytes)
  $Key .= '0382010F00';//BIT STRING (0x10f = 271 bytes)
  $Key .= '3082010A';//SEQUENCE (0x10a = 266 bytes)
  $Key .= '02820101';//INTEGER (0x101 = 257 bytes)
  $Key .= '00';//leading zero of INTEGER
  $Key .= $mod;
  $Key .= '0203';//INTEGER (03 = 3 bytes)
  $Key .= $exp;
  $Key = hex2bin($Key);
  $Key = base64_encode($Key);
  $return = '-----BEGIN PUBLIC KEY-----' . PHP_EOL;
  $return .= chunk_split($Key, 64, PHP_EOL);
  $return .= '-----END PUBLIC KEY-----';
  return $return;
}