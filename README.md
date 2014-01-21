php-bigmonster
==============

Another PHP framework

This is a collection of libraries built over the last 10 years and updated for current PHP.

Each library has a unit test, for example:

lib/FileDevice.php is a very low level wrapper for PHP file handling has a unit test:

ut/fileDevice.php

The ut directory is used in a web server document root and the lib directory can be anywhere accessible by
the ut scripts.

Define the LIBDIR constant as a full path to the lib directory for testing.

Added ShellCommandHandler for running shell commands on web server and returning output.

-C
