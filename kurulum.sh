docker-compose up -d
docker-compose exec app composer require "ext-gd:*" --ignore-platform-reqs
docker compose --profile tools run migrate

