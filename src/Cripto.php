<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools
//2026.05.04.01

function Jwt2Pem(
  string $n,
  string $e
){
  $n = base64url_decode($n);
  $e = base64url_decode($e);
  $EncodeLength = function ($length){
    if($length <= 0x7F):
      return chr($length);
    endif;
    $temp = ltrim(pack('N', $length), "\0");
    return chr(0x80 | strlen($temp)) . $temp;
  };
  $nBin = "\x02" . $EncodeLength(strlen($n)) . $n;
  $eBin = "\x02" . $EncodeLength(strlen($e)) . $e;
  $sequence = "\x30" . $EncodeLength(strlen($nBin . $eBin)) . $nBin . $eBin;
  $publicKeyInfo = "\x30" . $EncodeLength(strlen("\x30\x0d\x06\x09\x2a\x86\x48\x86\xf7\x0d\x01\x01\x01\x05\x00\x03" . $EncodeLength(strlen($sequence) + 1) . "\x00" . $sequence)) . "\x30\x0d\x06\x09\x2a\x86\x48\x86\xf7\x0d\x01\x01\x01\x05\x00\x03" . $EncodeLength(strlen($sequence) + 1) . "\x00" . $sequence;
  return "-----BEGIN PUBLIC KEY-----\n" . chunk_split(base64_encode($publicKeyInfo), 64) . "-----END PUBLIC KEY-----";
}

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