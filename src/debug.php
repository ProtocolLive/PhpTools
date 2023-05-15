<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/FuncoesComuns
//2023.05.15.01

function HandlerError(
  int $errno,
  string $errstr,
  string $errfile = null,
  int $errline = null,
  array $errcontext = null
):void{
  DebugTrace();
  ob_start();
  if(ini_get('html_errors')):
    echo '</textarea></option></select><pre>';
  endif;
  echo 'Error #' . $errno . ' - ' . $errstr . ' in ' . $errfile . ' (' . $errline . ')' . PHP_EOL;
  echo 'Backtrace:' . PHP_EOL;
  debug_print_backtrace();
  echo '</pre>';
  if(ini_get('display_errors')):
    error_log(ob_get_contents());
    ob_end_flush();
    die();
  endif;
  error_log(ob_get_contents());
  ob_end_clean();
  die();
}

function HandlerException($Exception):void{
  DebugTrace();
  ob_start();
  if(ini_get('html_errors')):
    echo '</textarea></option></select><pre>';
  endif;
  echo 'Exception:' . PHP_EOL;
  var_dump($Exception);
  echo 'Backtrace:' . PHP_EOL;
  debug_print_backtrace();
  echo '</pre>';
  if(ini_get('display_errors')):
    error_log(ob_get_contents());
    ob_end_flush();
    die();
  endif;
  error_log(ob_get_contents());
  ob_end_clean();
  die();
}

function vd(mixed $v):void{
  ob_start();
  if(ini_get('html_errors')):
    echo '</textarea></option></select><pre>';
  endif;
  echo date('H:i:s') . ' Variable debug:' . PHP_EOL;
  if(is_string($v)):
    $v = str_replace('<', '&lt;', $v);
  endif;
  var_dump($v);
  echo 'Backtrace:' . PHP_EOL;
  debug_print_backtrace();
  echo '</pre>';
  error_log(ob_get_contents());
  ob_end_flush();
}

function vdd(mixed $v):never{
  vd($v);
  die();
}

$DebugTraceFolder = __DIR__;
function DebugTrace():void{
  global $DebugTraceFolder;
  if(defined('DebugTrace') === false
  or DebugTrace === false):
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