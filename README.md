# ITK Feedback

```sh
docker-compose up -d
docker-compose exec phpfpm composer install
docker-compose exec phpfpm bin/console doctrine:migrations:migrate --no-interaction
# @TODO: There must be a better way to do this …
docker-compose exec phpfpm chown -R daemon /app/var
```


https://mercure.rocks/docs/hub/install#docker-image
```sh
docker run \
    -e JWT_KEY='!ChangeMe!' \
    -e MERCURE_SUBSCRIBER_JWT_KEY='!ChangeMe!' \
    -e MERCURE_EXTRA_DIRECTIVES='cors_origins *' \
    -p 8873:80 \
    -p 1337:443 \
    dunglas/mercure:v0.10.4 caddy run -config /etc/caddy/Caddyfile.dev
```

Go to <http://0.0.0.0:8880/>.
