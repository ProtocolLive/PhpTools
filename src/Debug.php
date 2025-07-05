<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools
//2025.07.05.00

/*
 * Notes:
 * - error_log always dumps the log in screen in Windows terminal
 */

function Handler(
  mixed ...$Args
):never{
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
  if(PHP_SAPI === 'cli'
  and PHP_OS === 'Linux'):
    echo $log;
  endif;
  if(ini_get('display_errors')):
    if(ini_get('html_errors')):
      echo '<pre style="text-align:left;white-space:pre-wrap">' . $log . '</pre>';
    else:
      echo $log;
    endif;
  endif;
  exit(1);
}

/**
 * @return mixed The first parameter
 */
function vd(
  mixed ...$values
):mixed{
  ob_start();
  echo date('Y-m-d H:i:s') . ' ' . microtime(true) . PHP_EOL;
  var_dump(...$values);
  debug_print_backtrace();
  $log = ob_get_contents();
  ob_end_clean();
  error_log($log);
  if(PHP_SAPI === 'cli'
  and PHP_OS === 'Linux'):
    echo $log;
  endif;
  if(ini_get('display_errors')):
    if(ini_get('html_errors')):
      echo '<pre style="text-align:left;white-space:pre-wrap">' . $log . '</pre>';
    else:
      echo $log;
    endif;
  endif;
  return $values[0];
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