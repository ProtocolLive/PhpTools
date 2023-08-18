<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/FuncoesComuns
//2023.08.02.00

function HandlerError(
  int $errno,
  string $errstr,
  string $errfile = null,
  int $errline = null,
  array $errcontext = null
):never{
  DebugTrace();
  ob_start();
  echo date('Y-m-d H:i:s') . ' ' . microtime(true) . PHP_EOL;
  echo 'Error #' . $errno . ' - ' . $errstr . ' in ' . $errfile . ' (' . $errline . ')' . PHP_EOL;
  debug_print_backtrace();
  $log = ob_get_contents();
  ob_end_clean();
  error_log($log);
  if(PHP_SAPI !== 'cli' and ini_get('display_errors')):
    echo '<pre style="text-align:left">' . $log . '</pre>';
  endif;
  die();
}

function HandlerException(
  Throwable $Exception
):void{
  DebugTrace();
  ob_start();
  echo date('Y-m-d H:i:s') . ' ' . microtime(true) . PHP_EOL;
  echo 'Exception: ';
  var_dump($Exception);
  debug_print_backtrace();
  $log = ob_get_contents();
  ob_end_clean();
  error_log($log);
  if(PHP_SAPI !== 'cli' and ini_get('display_errors')):
    echo '<pre style="text-align:left">' . $log . '</pre>';
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