<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/FuncoesComuns
//2024.11.21.00

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
  ConsoleColorText $Color = ConsoleColorText::Yellow
):void{
  readline(ConsoleColor($Text, $Color));
}