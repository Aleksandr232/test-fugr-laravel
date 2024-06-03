## Сборка Docker образа



1.  используй команду `docker compose up -d`


## Настройка бэка (он настройн, если что-то пойдет не так)

1. php artisan config:cache && php artisan route:cache && php artisan migrate && php artisan l5-swagger:generate
или
2. docker compose exec -it backend php artisan migrate и т.д 

## База данных 

- заходить через http://localhost:6080/
- логин:root
- пфроль:1234

## Swagger 

- заходить  http://localhost:8000/api/documentation
