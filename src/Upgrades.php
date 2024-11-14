<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/FuncoesComuns
//2024.11.14.00

/**
 * date and strtotime union
 */
function Dates(
  string $Format,
  string|int $Date = null
):string{
  if(is_string($Date)):
    $Date = strtotime($Date);
  endif;
  return date($Format, $Date);
}

/**
 * Gets a specific external variable by name and optionally filters it
 * @param string $VarName Name of a variable to get.
 * @param FilterSanitize|FilterValidate $Filter The ID of the filter to apply. The Types of filters manual page lists the available filters. If omitted, FILTER_DEFAULT will be used, which is equivalent to FILTER_UNSAFE_RAW. This will result in no filtering taking place by default.
 * @param array|int $Options Associative array of options or bitwise disjunction of flags. If filter accepts options, flags can be provided in "flags" field of array.
 * @return mixed Value of the requested variable on success, false if the filter fails, or null if the VarName variable is not set. If the flag FILTER_NULL_ON_FAILURE is used, it returns false if the variable is not set and null if the filter fails.
 * @link https://www.php.net/filter-input
 */
function FilterInput(
  FilterFrom $Type,
  string $VarName,
  FilterSanitize|FilterValidate $Filter = null,
  array|int $Options = 0,
  bool $Trim = false,
  bool $BlankNull = false
):mixed{
  $filter = $Filter;
  if($filter === FilterValidate::IntPositive
  or $filter === FilterValidate::Id
  or $filter === FilterValidate::Day
  or $filter === FilterValidate::Month):
    $filter = FilterValidate::Int;
  elseif($filter === FilterValidate::FloatPositive):
    $filter = FilterValidate::Float;
  endif;

  $return = filter_input(
    $Type->value,
    $VarName,
    $filter->value ?? FILTER_DEFAULT,
    $Options
  );

  if($Filter === FilterValidate::Id
  and $return <= 0):
    return false;
  endif;
  if((
    $Filter === FilterValidate::IntPositive
    or $Filter === FilterValidate::FloatPositive)
  and $return < 0):
    return false;
  endif;
  if($Filter === FilterValidate::Day
  and $return < 1
  and $return > 31):
    return false;
  endif;
  if($Filter === FilterValidate::Month
  and $return < 1
  and $return > 12):
    return false;
  endif;

  if($Trim):
    $return = trim($return);
  endif;
  if($BlankNull):
    $return = BlankNull($return);
  endif;

  return $return;
}

/**
 * Filters a variable with a specified filter
 * @var mixed $Value Value to filter. Note that scalar values are converted to string internally before they are filtered.
 * @var FilterSanitize|FilterValidate $Filter The ID of the filter to apply. The Types of filters manual page lists the available filters. If omitted, FILTER_DEFAULT will be used, which is equivalent to FILTER_UNSAFE_RAW. This will result in no filtering taking place by default.
 * @var array|int $Options Associative array of options or bitwise disjunction of flags. If filter accepts options, flags can be provided in "flags" field of array. For the "callback" filter, callable type should be passed. The callback must accept one argument, the value to be filtered, and return the value after filtering/sanitizing it.
 * @return mixed Returns the filtered data, or false if the filter fails.
 * @link https://www.php.net/filter-var
 */
function FilterVar(
  mixed $Value,
  FilterSanitize|FilterValidate $Filter = null,
  array|int $Options = 0
):mixed{
  $filter = $Filter;
  if($filter === FilterValidate::IntPositive
  or $filter === FilterValidate::Id
  or $filter === FilterValidate::Day
  or $filter === FilterValidate::Month):
    $filter = FilterValidate::Int;
  elseif($filter === FilterValidate::FloatPositive):
    $filter = FilterValidate::Float;
  endif;

  $return = filter_var(
    $Value,
    $filter->value ?? FILTER_DEFAULT,
    $Options
  );

  if($Filter === FilterValidate::Id
  and $return <= 0):
    return false;
  endif;
  if((
    $Filter === FilterValidate::IntPositive
    or $Filter === FilterValidate::FloatPositive)
  and $return < 0):
    return false;
  endif;
  if($Filter === FilterValidate::Day
  and $return < 1
  and $return > 31):
    return false;
  endif;
  if($Filter === FilterValidate::Month
  and $return < 1
  and $return > 12):
    return false;
  endif;

  return $return;
}

/**
 * Makes directory
 * @param string $Directory The directory path. Tip: A URL can be used as a filename with this function if the fopen wrappers have been enabled. See fopen() for more details on how to specify the filename. See the Supported Protocols and Wrappers for links to information about what abilities the various wrappers have, notes on their usage, and information on any predefined variables they may provide.
 * @param int $Permissions The permissions are 0755 by default. For more information on permissions, read the details on the chmod() page. Note: Permissions is ignored on Windows. Note that you probably want to specify the permissions as an octal number, which means it should have a leading zero. The permissions is also modified by the current umask, which you can change using umask().
 * @param bool $Recursive If true, then any parent directories to the directory specified will also be created, with the same permissions.
 * @return bool Returns true on success or false on failure. Note: If the directory to be created already exists, that is considered an error and false will still be returned.
 * @link https://www.php.net/mkdir
 */
function MkDir2(
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