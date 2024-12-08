<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools
//2024.12.08.00

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