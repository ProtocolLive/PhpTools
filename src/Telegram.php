<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools
//2024.11.05.00

function TelegramSignCheck(
  string $Token,
  array $Data,
  int $TimeoutMinutes = 5
):bool{
  $HashSended = $Data['hash'];
  unset($Data['hash']);
  $array = [];
  foreach($Data as $key => $value):
    $array[] = $key . '=' . $value;
  endforeach;
  sort($array);
  $array = implode("\n", $array);
  $Token = hash('sha256', $Token, true);
  $HashRight = hash_hmac('sha256', $array, $Token);
  if(strcmp($HashSended, $HashRight) !== 0
  or time() > strtotime('+' . $TimeoutMinutes . ' minutes', $Data['auth_date'])):
    return false;
  else:
    return true;
  endif;
}

function TelegramWebappCheck(
  string $Token,
  array $Data,
  int $TimeoutMinutes = 5
):bool{
  $HashSended = $Data['hash'];
  unset($Data['hash']);
  $array = [];
  foreach($Data as $key => $value):
    $array[] = $key . '=' . $value;
  endforeach;
  sort($array);
  $array = implode("\n", $array);
  $Token = hash_hmac('sha256', $Token, 'WebAppData', true);
  $HashRight = hash_hmac('sha256', $array, $Token);
  if($HashSended !== $HashRight
  or time() > strtotime('+' . $TimeoutMinutes . ' minutes', $Data['auth_date'])):
    return false;
  else:
    return true;
  endif;
}