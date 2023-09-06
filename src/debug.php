<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/FuncoesComuns
//2023.09.06.00

function Handler(
  mixed ...$Args
):void{
  DebugTrace();
  ob_start();
  echo date('Y-m-d H:i:s') . ' ' . microtime(true) . PHP_EOL;
  $type = func_get_arg(0);
  if(is_int($type)):
    echo 'Error #' . $type . ' - ' . func_get_arg(1) . PHP_EOL .
      func_get_arg(2) . ' (' . func_get_arg(3) . ')' . PHP_EOL;
    debug_print_backtrace();
  else:
    echo 'Exception: ' . $type->getMessage() . PHP_EOL .
      $type->getFile() . ' (' . $type->getLine() . ')' . PHP_EOL;
    var_dump($type);
  endif;
  $log = ob_get_contents();
  ob_end_clean();
  error_log($log);
  if(ini_get('display_errors')):
    if(PHP_SAPI === 'cli' or ini_get('html_errors') == false):
      echo $log;
    else:
      echo '<pre style="text-align:left">' . $log . '</pre>';
    endif;
  endif;
  die();
}

function vd(
  mixed ...$values
):void{
  foreach($values as &$v):
    if(is_string($v)):
      $v = htmlentities($v);
    endif;
  endforeach;
  ob_start();
  echo date('Y-m-d H:i:s') . ' ' . microtime(true) . PHP_EOL;
  var_dump(...$values);
  debug_print_backtrace();
  $log = ob_get_contents();
  ob_end_clean();
  error_log($log);
  if(PHP_SAPI !== 'cli' and ini_get('display_errors')):
    echo '<pre style="text-align:left">' . $log . '</pre>';
  endif;
}

function vdd(
  mixed ...$values
):never{
  vd(...$values);
  die();
}

$DebugTraceFolder = __DIR__;
function DebugTrace():void{
  global $DebugTraceFolder;
  if(defined('DebugTrace') === false
  or DebugTrace == false):
    return;
  endif;
  static $DebugTraceCount = 0;
  $trace = debug_backtrace();
  $temp = '#' . $DebugTraceCount++ . ' ';
  $temp .= date('Y-m-d H:i:s ') . microtime(true) . PHP_EOL;
  $temp .= 'Memory: ' . number_format(memory_get_usage()) . ' ';
  $temp .= 'Limit: ' . ini_get('memory_limit') . ' ';
  $temp .= 'Peak: ' . number_format(memory_get_peak_usage()) . PHP_EOL;
  $temp .= $trace[1]['function'];
  $temp .= ' in ' . ($trace[1]['file'] ?? 'unknown');
  $temp .= ' line ' . ($trace[1]['line'] ?? 'unknown') . PHP_EOL;
  if(count($trace[1]['args']) > 0):
    $temp .= json_encode($trace[1]['args'], JSON_PRETTY_PRINT) . PHP_EOL;
  endif;
  $temp .= PHP_EOL;
  MkDir2($DebugTraceFolder);
  file_put_contents($DebugTraceFolder . '/trace.log', $temp, FILE_APPEND);
}