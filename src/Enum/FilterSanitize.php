<?php
//2023.03.23.00

/**
 * @link https://www.php.net/manual/en/filter.filters.sanitize.php
 */
enum FilterSanitize:int{
  case Email = FILTER_SANITIZE_EMAIL;
  case Encoded = FILTER_SANITIZE_ENCODED;
  case Float = FILTER_SANITIZE_NUMBER_FLOAT;
  case Int = FILTER_SANITIZE_NUMBER_INT;
  case None = FILTER_UNSAFE_RAW;
  case Slash = FILTER_SANITIZE_ADD_SLASHES;
  case SpecialChars = FILTER_SANITIZE_SPECIAL_CHARS;
  case SpecialCharsFull = FILTER_SANITIZE_FULL_SPECIAL_CHARS;
  case Url = FILTER_SANITIZE_URL;
}