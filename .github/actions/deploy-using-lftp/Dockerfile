FROM alpine:latest

RUN apk --no-cache add lftp

COPY ./.github/actions/deploy-using-lftp/entrypoint.sh /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
