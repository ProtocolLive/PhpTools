<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/FuncoesComuns
//2023.05.11.00

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