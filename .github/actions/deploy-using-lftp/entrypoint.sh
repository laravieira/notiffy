for excluded in $INPUT_LFTP_EXCLUDE
do
  EXCLUDE="$EXCLUDE --exclude $excluded"
done

for included in $INPUT_LFTP_INCLUDE
do
  INCLUDE="$INCLUDE --include $included"
done

for flag in $INPUT_LFTP_FLAGS
do
  FLAGS="$FLAGS set $flag;"
done

LFTP_COMMAND="$FLAGS mirror $INPUT_LFTP_ARGS $EXCLUDE $INCLUDE $INPUT_LFTP_LOCAL_DIR $INPUT_LFTP_SERVER_DIR; exit 0"

lftp $INPUT_LFTP_HOST -u $INPUT_LFTP_USER,$INPUT_LFTP_PASS -e "$LFTP_COMMAND"