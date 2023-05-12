<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/FuncoesComuns
//2023.05.11.01

function FilterInput(
  FilterFrom $Type,
  string $VarName,
  FilterSanitize|FilterValidate $Filter = FILTER_DEFAULT,
  array|int $Options = 0
):mixed{
  return filter_input(
    $Type->value,
    $VarName,
    $Filter->value,
    $Options
  );
}

function MkDir(
  string $Directory,
  int $Permissions = 0755,
  bool $Recursive = true
):bool{
  if(is_dir($Directory)):
    return false;
  else:
    return mkdir($Directory, $Permissions, $Recursive);
  endif;
}