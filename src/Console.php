<?php
/**
 * @author Protocol Corporation Ltda.
 * @link https://github.com/ProtocolLive/PhpTools
 * @version 2026.11.24.00
 * @php-min-ver 8.1
 */

function ConsoleColor(
  string $Text,
  ConsoleColorText|ConsoleColorBg $Color1,
  ConsoleColorBg|null $Color2 = null
):string{
  $return = "\e[" . $Color1->value;
  if($Color2 !== null):
    $return .= ';' . $Color2->value;
  endif;
  $return .= 'm' . $Text . "\e[0m";
  return $return;
}

function ConsolePause(
  string $Text = 'Press any key to continue...',
  ConsoleColorText $Color = ConsoleColorText::Green
):void{
  echo ConsoleColor($Text, $Color);
  readline();
}