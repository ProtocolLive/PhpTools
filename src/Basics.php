<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/FuncoesComuns
//2024.04.10.00

function AccentInsensitive(
  string $Text
):string{
  $Text = Normalizer::normalize($Text, Normalizer::NFD);
  return preg_replace('/[\x{0300}-\x{036F}]/u', '', $Text);;
}

function ArgV():void{
  if($_SERVER['argc'] === 0):
    return;
  endif;
  $temp = array_slice($_SERVER['argv'], 1);
  $temp = implode('&', $temp);
  parse_str($temp, $temp);
  $_SERVER = array_merge($_SERVER, $temp);
}

function ArrayDefrag(
  array &$Array
):array{
  return $Array = array_values($Array);
}

function BlankNull(
  string|null $Var
):string|null{
  return empty($Var) ? null : $Var;
}

/**
 * Cross-site request forgery token generation
 * @param bool $Check If for check the token sended
 * @param bool $Form Create the form element
 * @return string|bool If $Check is true, return bool for token check. If $Form is true, return the form element. False otherwise
 */
function Csrf(
  bool $Check = false,
  bool $Form = false
):string|bool{
  if($Form):
    $_SESSION['Csrf'] = sha1(uniqid());
    return '<input type="hidden" name="csrf" value="' . $_SESSION['Csrf'] . '">';
  endif;
  if($Check):
    if(isset($_SESSION['Csrf']) === false):
      error_log('CSRF token not created');
      return false;
    endif;
    if(empty(FilterInput(FilterFrom::Post, 'csrf', FilterValidate::Regex, [
      'options' => [ 'regexp' => '/\b[0-9a-fA-F]{40,40}\b/']
    ]))):
      error_log('CSRF token not valid');
      return false;
    endif;
    $temp = $_SESSION['Csrf'];
    unset($_SESSION['Csrf']);
    return $_POST['csrf'] === $temp;
  endif;
  return false;
}

function DetectEol(
  string $Text
):Eol{
  if(str_contains($Text, Eol::Crlf->value)):
    return Eol::Crlf;
  else:
    return Eol::Lf;
  endif;
}

function Equals(
  string $Text1,
  string $Text2
):bool{
  $Text1 = AccentInsensitive($Text1);
  $Text2 = AccentInsensitive($Text2);
  return strcasecmp($Text1, $Text2) === 0;
}

function ExplodeLines(
  string $Text
):array{
  if(DetectEol($Text) === Eol::Lf):
    return explode(Eol::Lf->value, $Text);
  else:
    return explode(Eol::Crlf->value, $Text);
  endif;
}

/**
 * Convert function to string
 */
function F2s(
  \Closure $Function
):string{
  $Function = new \ReflectionFunction($Function);
  $return = '';
  $temp = $Function->getNamespaceName();
  if($temp !== ''):
    $return = $temp . '\\';
  endif;
  $temp = $Function->getClosureScopeClass();
  if($temp !== null):
    $temp = $temp->getName();
    if($temp !== ''):
      $return .= $temp . '::';
    endif;
  endif;
  $return .= $Function->getName();
  return $return;
}

function FloatInt(
  string $Val
):int{
  $Val = str_replace(',', '.', $Val);
  $Val = floatval($Val);
  $Val = number_format($Val, 2, '.', '');
  return str_replace('.', '', $Val);
}

function GlobRecursive(
  string $Dir,
  int $Flags = 0
):array{
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

function HashDir(
  string $Algo,
  string $Dir
):array{
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

function Money(
  int|float|null $Val = 0,
  string $Localization = 'pt-br',
  string $Currency = 'BRL'
):string{
  return numfmt_format_currency(
    numfmt_create($Localization, NumberFormatter::CURRENCY),
    str_contains($Val, '.') ? $Val : $Val / 100,
    $Currency
  );
}

function Number(
  int $N,
  int $Precision,
  string $Localization = 'pt-br'
):string{
  $temp = new NumberFormatter($Localization, NumberFormatter::DECIMAL);
  $temp->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $Precision);
  return $temp->format($N);
}

function PrintIfSet(
  mixed &$Var,
  string $Content = null,
  string $Else = null
):void{
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

function Std2Class(
  stdClass $From,
  object $To
):void{
  foreach($From as $Key => $Value):
    $To->{$Key} = $Value;
  endforeach;
}

function Uuid(
  string $Data
):string{
  assert(strlen($Data) == 16);
  $Data[6] = chr(ord($Data[6]) & 0x0f | 0x40); // set version to 0100
  $Data[8] = chr(ord($Data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($Data), 4));
}