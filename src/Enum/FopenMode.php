<?php
//2023.03.16.00

enum FopenMode:string{
  /**
   * Set close-on-exec flag on the opened file descriptor. Only available in PHP compiled on POSIX.1-2008 conform systems.
   */
  case CloseOnExec = 'e';
  /**
   * Open for reading only; place the file pointer at the beginning of the file.
   */
  case ReadBegin = 'r';
  /**
   * Open for reading and writing; place the file pointer at the beginning of the file.
   */
  case ReadWriteBegin = 'r+';
  /**
   * Open for reading and writing; otherwise it has the same behavior as 'w'.
   */
  case ReadWriteBeginTruncateCreate = 'w';
  /**
   * Open for reading and writing; place the file pointer at the end of the file. If the file does not exist, attempt to create it. In this mode, fseek() only affects the reading position, writes are always appended.
   */
  case ReadWriteEndCreate = 'a';
  /**
   * Create and open for reading and writing; otherwise it has the same behavior as 'x'.
   */
  case ReadWriteCreateOnly = 'x+';
  /**
   * Open the file for reading and writing; otherwise it has the same behavior as 'c'.
   */
  case ReadWriteCreate = 'c+';
  /**
   * Open the file for writing only. If the file does not exist, it is created. If it exists, it is neither truncated (as opposed to ), nor the call to this function fails (as is the case with ). The file pointer is positioned on the beginning of the file. This may be useful if it's desired to get an advisory lock (see flock()) before attempting to modify the file, as using could truncate the file before the lock was obtained (if truncation is desired, ftruncate() can be used after the lock is requested).'w''x''w'
   */
  case WriteBeginCreate = 'c';
  /**
   * Create and open for writing only; place the file pointer at the beginning of the file. If the file already exists, the fopen() call will fail by returning false and generating an error of level E_WARNING. If the file does not exist, attempt to create it. This is equivalent to specifying O_EXCL|O_CREAT flags for the underlying open(2) system call.
   */
  case WriteBeginCreateOnly = 'x';
  /**
   * Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.
   */
  case WriteBeginTruncateCreate = 'w';
  /**
   * Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it. In this mode, fseek() has no effect, writes are always appended.
   */
  case WriteEndCreate = 'a';
}