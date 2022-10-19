#!/bin/bash
set -e

## change www-data user UID
ORIG_UID=$(cat /etc/passwd | grep www-data | cut -f3 -d:)
DEV_UID=${DEV_UID:-$ORIG_UID}
usermod -u $DEV_UID www-data