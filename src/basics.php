<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/FuncoesComuns
//2022.10.21.00

enum DiaSemana:int{
  case Domingo = 0;
  case Segunda = 1;
  case Terca = 2;
  case Quarta = 4;
  case Quinta = 5;
  case Sexta = 6;
  case Sabado = 7;
}

function AccentInsensitive(string $Text):string{
  return iconv('utf-8', 'ascii//TRANSLIT', $Text);
}

function ArgV():void{
  if($_SERVER['argc'] > 0):
    unset($_SERVER['argv'][0]);
    $temp = '';
    foreach($_SERVER['argv'] as $param):
      $temp .= $param . '&';
    endforeach;
    parse_str($temp, $_temp);
    $_SERVER = array_merge($_SERVER, $_temp);
  endif;
}

function ArrayDefrag(array &$Array):void{
  $Array = array_values($Array);
}

/**
 * date and strtotime union
 */
function Dates(string $Format, string|int $Date = null):string{
  if(is_string($Date)):
    $Date = strtotime($Date);
  endif;
  return date($Format, $Date);
}

function DirCreate(
  string $Dir,
  int $Perm = 0755,
  bool $Recursive = true
):bool{
  if(is_dir($Dir)):
    return false;
  else:
    return mkdir($Dir, $Perm, $Recursive);
  endif;
}

function Equals(string $Text1, string $Text2):bool{
  $Text1 = AccentInsensitive($Text1);
  $Text2 = AccentInsensitive($Text2);
  return strcasecmp($Text1, $Text2) === 0;
}

function FloatInt(string $Val):int{
  $Val = str_replace(',', '.', $Val);
  $Val = number_format($Val, 2, '.', '');
  return str_replace('.', '', $Val);
}

function GlobRecursive(string $Dir, int $Flags = 0){
  $files = [];
  foreach(glob($Dir . '/*', $Flags) as $file):
    if(is_dir($file)):
      $files = array_merge($files, GlobRecursive($file, $Flags));
    else:
      $files[] = $file;
    endif;
  endforeach;
  return $files;
}

function HashDir(string $Algo, string $Dir):array{
  $hash = [];
  foreach(glob($Dir . '/*') as $file):
    if(is_dir($file)):
      $hash += HashDir($Algo, $file);
    else:
      $hash[$file] = hash_file($Algo, $file);
    endif;
  endforeach;
  return $hash;
}

function Money(int $Val = 0):string{
  $Val /= 100;
  $obj = numfmt_create('pt-br', NumberFormatter::CURRENCY);
  return numfmt_format_currency($obj, $Val, 'BRL');
}

function Number(int $N, int $Precision):string{
  $temp = new NumberFormatter('pt-br', NumberFormatter::DECIMAL);
  $temp->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $Precision);
  return $temp->format($N);
}

function PrintIfSet(mixed &$Var, string $Content = null, string $Else = null):void{
  if(isset($Var) and $Var !== null):
    if($Content === null):
      print $Var;
    else:
      print $Content;
    endif;
  else:
    print $Else;
  endif;
}

function Pkcs1ToX509(string $Key):string|false{
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
  $Key = str_split($Key, 64);
  $return = '-----BEGIN PUBLIC KEY-----' . PHP_EOL;
  $return .= implode(PHP_EOL, $Key) . PHP_EOL;
  $return .= '-----END PUBLIC KEY-----';
  return $return;
}