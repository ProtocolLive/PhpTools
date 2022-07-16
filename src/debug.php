<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/FuncoesComuns
//2022.07.16.01

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
  echo 'Error #' . $errno . ' - ' . $errstr . ' in ' . $errfile . ' (' . $errline . ")\n";
  echo "Backtrace:\n";
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
  echo "Exception:\n";
  var_dump($Exception);
  echo "Backtrace:\n";
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
  echo date('H:i:s') . " Variable debug:\n";
  var_dump($v);
  echo "Backtrace:\n";
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
  static $DebugTraceCount = 0;
  if(DebugTrace === false):
    return;
  endif;
  $trace = debug_backtrace();
  $temp = '#' . $DebugTraceCount++ . ' ';
  $temp .= date('Y-m-d H:i:s ') . microtime(true) . "\n";
  $temp .= 'Memory: ' . number_format(memory_get_usage()) . ' ';
  $temp .= 'Limit: ' . ini_get('memory_limit') . ' ';
  $temp .= 'Peak: ' . number_format(memory_get_peak_usage()) . "\n";
  $temp .= $trace[1]['function'];
  $temp .= ' in ' . ($trace[1]['file'] ?? 'unknown');
  $temp .= ' line ' . ($trace[1]['line'] ?? 'unknown') . "\n";
  if(count($trace[1]['args']) > 0):
    $temp .= json_encode($trace[1]['args'], JSON_PRETTY_PRINT) . "\n";
  endif;
  $temp .= "\n";
  DirCreate(DirSystem . '/system/logs');
  file_put_contents($DebugTraceFolder . '/logs/trace.log', $temp, FILE_APPEND);
}