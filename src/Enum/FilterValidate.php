<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/PhpTools

/**
 * @link https://www.php.net/manual/en/filter.filters.validate.php
 * @version 2024.02.20.01
 */
enum FilterValidate:int{
  /**
   * Returns true for "1", "true", "on" and "yes". Returns false otherwise.
   * If FILTER_NULL_ON_FAILURE is set, false is returned only for "0", "false", "off", "no", and "", and null is returned for all non-boolean values.
   * String values are trimmed using trim() before comparison.
   */
  case Bool = FILTER_VALIDATE_BOOLEAN;
  /**
   * Validates value as date.
   */
  case Day = -4;
  /**
   * Validates whether the domain name label lengths are valid.
   * Validates domain names against RFC 1034, RFC 1035, RFC 952, RFC 1123, RFC 2732, RFC 2181, and RFC 1123. Optional flag FILTER_FLAG_HOSTNAME adds ability to specifically validate hostnames (they must start with an alphanumeric character and contain only alphanumerics or hyphens).
   */
  case Domain = FILTER_VALIDATE_DOMAIN;
  /**
   * Validates whether the value is a valid e-mail address.
   * In general, this validates e-mail addresses against the addr-specsyntax in » RFC 822, with the exceptions that comments and whitespace folding and dotless domain names are not supported.
   */
  case Email = FILTER_VALIDATE_EMAIL;
  /**
   * Validates value as float, optionally from the specified range, and converts to float on success.
   * String values are trimmed using trim() before comparison.
   */
  case Float = FILTER_VALIDATE_FLOAT;
  /**
   * Validates value as positive float
   */
  case FloatPositive = -3;
  /**
   * Validates value as ID. Similar to IntPositive but excludes 0.
   */
  case Id = -2;
  /**
   * Validates value as integer, optionally from the specified range, and converts to int on success.
   * String values are trimmed using trim() before comparison.
   */
  case Int = FILTER_VALIDATE_INT;
  /**
   * Validates value as positive integer
   */
  case IntPositive = -1;
  /**
   * Validates value as IP address, optionally only IPv4 or IPv6 or not from private or reserved ranges.
   */
  case Ip = FILTER_VALIDATE_IP;
  /**
   * Validates value as MAC address.
   */
  case Mac = FILTER_VALIDATE_MAC;
  /**
   * Validates value as month
   */
  case Month = -5;
  /**
   * Validates value against regexp, a Perl-compatible regular expression.
   */
  case Regex = FILTER_VALIDATE_REGEXP;
  /**
   * Validates value as URL (according to » http://www.faqs.org/rfcs/rfc2396), optionally with required components. Beware a valid URL may not specify the HTTP protocol http:// so further validation may be required to determine the URL uses an expected protocol, e.g. ssh:// or mailto:. Note that the function will only find ASCII URLs to be valid; internationalized domain names (containing non-ASCII characters) will fail.
   */
  case Url = FILTER_VALIDATE_URL;
}