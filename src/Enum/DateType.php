<?php

/**
 * @version 2023.09.11.00
 * @link https://www.php.net/manual/en/datetime.format.php
 */
enum DateType:string{
  /**
   * Lowercase Ante meridiem and Post meridiem: am or pm
   */
  case AmPm = 'a';
  /**
   * Uppercase Ante meridiem and Post meridiem: AM or PM
   */
  case AmPmUp = 'A';
  /**
   * ISO 8601 date: 2004-02-12T15:19:21+00:00
   */
  case Date8601 = 'c';
  /**
   * RFC 2822/RFC 5322 formatted date	Example: Thu, 21 Dec 2000 16:01:07 +0200
   */
  case Date2822 = 'r';
  /**
   * Day of the month, 2 digits with leading zeros: 01 to 31
   */
  case Day = 'd';
  /**
   * A textual representation of a day, three letters: Mon through Sun
   */
  case DayLetter = 'D';
  /**
   * Whether or not the date is in daylight saving time	1 if Daylight Saving Time, 0 otherwise.
   */
  case DayLightSaving = 'I';
  /**
   * Day of the month without leading zeros: 1 to 31
   */
  case DayNoZero = 'j';
  /**
   * 	The day of the year (starting from 0): 0 through 365
   */
  case DayYear = 'z';
  /**
   * 	Difference to Greenwich time (GMT) without colon between hours and minutes	Example: +0200
   */
  case GmtDiff = 'O';
  /**
   * Difference to Greenwich time (GMT) with colon between hours and minutes
   */
  case GmtDiffColon = 'P';
  /**
   * Timezone abbreviation, if known; otherwise the GMT offset. Examples: EST, MDT, +05
   */
  case GmtDiffShort = 'T';
  /**
   * The same as P, but returns Z instead of +00:00 (available as of PHP 8.0.0). Examples: Z or +02:00
   */
  case GmtDiffZ = 'p';
  /**
   * 24-hour format of an hour with leading zeros: 00 through 23
   */
  case Hour = 'H';
  /**
   * 12-hour format of an hour with leading zeros: 01 through 12
   */
  case Hour12 = 'h';
  /**
   * 12-hour format of an hour without leading zeros: 1 through 12
   */
  case Hour12NoZero = 'g';
  /**
   * 24-hour format of an hour without leading zeros: 0 through 23
   */
  case HourNoZero = 'G';
  /**
   * Minutes with leading zeros	00 to 59
   */
  case Minutes = 'i';
  /**
   * Numeric representation of a month, with leading zeros: 01 through 12
   */
  case Month = 'm';
  /**
   * 	Number of days in the given month: 28 through 31
   */
  case MonthDays = 't';
  /**
   * 	A short textual representation of a month, three letters: Jan through Dec
   */
  case MonthLetter = 'M';
  /**
   * 	A short textual representation of a month, three letters	Jan through Dec
   */
  case MonthNoZero = 'n';
  /**
   * A full textual representation of a month, such as January or March: January through December
   */
  case MonthStr = 'F';
  /**
   * Seconds with leading zeros: 00 through 59
   */
  case Seconds = 's';
  /**
   * Seconds with leading zeros: 00 through 59
   */
  case SecondsMicro = 'u';
  /**
   * Milliseconds. Same note applies as for u. Example: 654
   */
  case SecondsMilli = 'v';
  /**
   * Swatch Internet time	000 through 999
   */
  case Swatch = 'B';
  /**
   * 	Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)	See also time()
   */
  case Time = 'U';
  /**
   * Timezone identifier. Examples: UTC, GMT, Atlantic/Azores
   */
  case Timezone = 'e';
  /**
   * Timezone offset in seconds. The offset for timezones west of UTC is always negative, and for those east of UTC is always positive. -43200 through 50400
   */
  case TimezoneSeconds = 'Z';
  /**
   * Numeric representation of the day of the week: 0 (for Sunday) through 6 (for Saturday)
   */
  case Week = 'w';
  /**
   * ISO 8601 numeric representation of the day of the week: 1 (for Monday) through 7 (for Sunday)
   */
  case Week8601 = 'N';
  /**
   * ISO 8601 week-numbering year. This has the same value as Y, except that if the ISO week number (W) belongs to the previous or next year, that year is used instead. Examples: 1999 or 2003
   */
  case WeekCount8601 = 'o';
  /**
   * 	ISO 8601 week number of year, weeks starting on Monday: Example: 42 (the 42nd week in the year)
   */
  case WeekCount = 'W';
  /**
   * A full textual representation of the day of the week: Sunday through Saturday
   */
  case WeekStr = 'l';
  /**
   * English ordinal suffix for the day of the month, 2 characters: st, nd, rd or th. Works well with j
   */
  case WeekSuffix = 'S';
  /**
   * A full numeric representation of a year, at least 4 digits, with - for years BCE. Examples: -0055, 0787, 1999, 2003, 10191
   */
  case Year = 'Y';
  /**
   * A two digit representation of a year. Examples: 99 or 03
   */
  case Year2Digits = 'y';
  /**
   * An expanded full numeric representation of a year, at least 4 digits, with - for years BCE, and + for years CE. Examples: -0055, +0787, +1999, +10191
   */
  case YearAcnAc = 'X';
  /**
   * An expanded full numeric representation if required, or a standard full numeral representation if possible (like Y). At least four digits. Years BCE are prefixed with a -. Years beyond (and including) 10000 are prefixed by a +. Examples: -0055, 0787, 1999, +10191
   */
  case YearExpanded = 'x';
  /**
   * Whether it's a leap year: 1 if it is a leap year, 0 otherwise.
   */
  case YearLeap = 'L';
}