#!/bin/sh

multitail -Z ,,inverse -m 0 --mark-change -n 36 -ci red -I "apache_error_log.log" -n 36 -ci green -I "apache_access_log.log"