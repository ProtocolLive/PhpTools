<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools

namespace ProtocolLive\PhpTools;
use FilterFrom;
use ProtocolLive\PhpLiveDb\Enums\Types;
use ProtocolLive\PhpLiveDb\PhpLiveDb;

/**
 * @version 2024.11.27.00
 */
abstract class Crud{
  private static function Edit(
    PhpLiveDb $Db,
    string $Table
  ):void{
    DebugTrace();
    $id = FilterInput(FilterFrom::Get, 'id');
    $result = $Db->Select($Table)
    ->Run();
    if(empty($id) === false):
      $result = $Db->Select($Table)
      ->WhereAdd(array_key_first($result[0]), $id, Types::Str)
      ->Run();
    endif;
    echo '<form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '?a=save&id=' . $id . '">';
    foreach(array_keys($result[0]) as $col):
      echo $col . '<br>';
      if(strlen($result[0][$col]) > 20
      and empty($id) === false):
        echo '<textarea name="' . $col . '" cols="50" rows="10">' . (empty($id) ? '' : $result[0][$col]) . '</textarea><br>';
      else:
        echo '<input type="text" name="' . $col . '" value="' . (empty($id) ? '' : $result[0][$col]) . '"><br>';
      endif;
    endforeach;
    echo '<br><input type="submit" value="Save"><form>';
  }

  public static function Del(
    PhpLiveDb $Db,
    string $Table,
    string|null $Order,
    string|null $Limit
  ):void{
    DebugTrace();
    //Implementação
  }

  public static function Run(
    PhpLiveDb $Db,
    string $Table,
    string|null $Order = null,
    int|null $Limit = null
  ):void{
    DebugTrace();
    $a = FilterInput(FilterFrom::Get, 'a');
    if($a === 'edit'):
      self::Edit($Db, $Table);
    elseif($a === 'del'):
    elseif($a === 'save'):
      self::Save($Db, $Table, $Order, $Limit);
    else:
      self::Select($Db, $Table, $Order, $Limit);
    endif;
  }

  public static function Save(
    PhpLiveDb $Db,
    string $Table,
    string|null $Order,
    string|null $Limit
  ):void{
    DebugTrace();
    $db = $Db->InsertUpdate($Table);
    foreach($_POST as $col => $value):
      $db->FieldAdd($col, $value, Types::Str, Update: true);
    endforeach;
    $db->Run();
   echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '">Updated</a>';
  }

  private static function Select(
    PhpLiveDb $Db,
    string $Table,
    string|null $Order,
    string|null $Limit
  ):void{
    DebugTrace();
    $result = $Db->Select($Table)
    ->Order($Order)
    ->Limit($Limit)
    ->Run();
    if($result === []):
      echo '<table><tr><td>Table empty</td></tr></table>';
    endif;
    echo '<table><tr><th><a href="' . $_SERVER['SCRIPT_NAME'] . '?a=edit&id=">➕</a></th>';
    foreach(array_keys($result[0]) as $col):
      echo '<th>' . $col . '</th>';
    endforeach;
    echo '</tr>';
    foreach($result as $row):

      echo '<tr><td><a href="' . $_SERVER['SCRIPT_NAME'] . '?a=edit&id=' . $row[array_key_first($row)] . '">✏️</a><a href="' . $_SERVER['SCRIPT_NAME'] . '?a=del&id=' . $row[array_key_first($row)] . '" onclick="return confirm(\'Are you sure?\');">🗑️</a></td>';
      foreach($row as $col):
        echo '<td>' . $col . '</td>';
      endforeach;
      echo '</tr>';
    endforeach;
    echo '</table>';
  }
}