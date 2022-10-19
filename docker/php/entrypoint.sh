#!/bin/bash

DIR=/usr/local/bin/entrypoint.d

chmod +x $DIR/*.sh

if [[ -d "$DIR" ]]; then
  /bin/run-parts --verbose --regex '.sh' "$DIR"
fi

exec "$@"
