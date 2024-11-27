<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools

/**
 * @link https://www.php.net/manual/en/filter.filters.sanitize.php
 * @version 2024.02.20.00
 */
enum FilterSanitize:int{
  /**
   * Remove all characters except letters, digits and !#$%&'*+-=?^_`{|}~@.[].
   */
  case Email = FILTER_SANITIZE_EMAIL;
  /**
   * URL-encode string, optionally strip or encode special characters.
   */
  case Encoded = FILTER_SANITIZE_ENCODED;
  /**
   * Remove all characters except digits, +- and optionally .,eE.
   */
  case Float = FILTER_SANITIZE_NUMBER_FLOAT;
  /**
   * Remove all characters except digits, plus and minus sign.
   */
  case Int = FILTER_SANITIZE_NUMBER_INT;
  /**
   * Do nothing, optionally strip or encode special characters. This filter is also aliased to FILTER_DEFAULT.
   */
  case None = FILTER_UNSAFE_RAW;
  /**
   * Apply addslashes(). (Available as of PHP 7.3.0)
   */
  case Slash = FILTER_SANITIZE_ADD_SLASHES;
  /**
   * HTML-encode '"<>& and characters with ASCII value less than 32, optionally strip or encode other special characters.
   */
  case SpecialChars = FILTER_SANITIZE_SPECIAL_CHARS;
  /**
   * Equivalent to calling htmlspecialchars() with ENT_QUOTES set. Encoding quotes can be disabled by setting FILTER_FLAG_NO_ENCODE_QUOTES. Like htmlspecialchars(), this filter is aware of the default_charset and if a sequence of bytes is detected that makes up an invalid character in the current character set then the entire string is rejected resulting in a 0-length string. When using this filter as a default filter, see the warning below about setting the default flags to 0.
   */
  case SpecialCharsFull = FILTER_SANITIZE_FULL_SPECIAL_CHARS;
  /**
   * Remove all characters except letters, digits and $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&=.
   */
  case Url = FILTER_SANITIZE_URL;
}