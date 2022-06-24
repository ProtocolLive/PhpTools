<?php
//2022.06.24.00

function TelegramSignCheck(
  string $Token,
  array $Data,
  int $TimeoutMinutes = 5
):bool{
  $Data['username'] ??= 'undefined';
  $Data['last_name'] ??= 'undefined';
  if($Data['username'] === 'undefined'):
    unset($Data['username']);
  endif;
  if($Data['last_name'] === 'undefined'):
    unset($Data['last_name']);
  endif;
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

function TelegramWebappCheck(string $Token, array $Data):bool{
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
  or time() > strtotime('+5 minutes', $Data['auth_date'])):
    return false;
  else:
    return true;
  endif;
}