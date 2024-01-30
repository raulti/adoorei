## Como iniciar o projeto?

- Na raiz do projeto execute o comando:

```
docker compose up -d --build
```

```
docker compose run --rm php /bin/sh
```

```
php artisan migrate
```

```
php artisan db:seed
```

-- OBS: Caso não instale de forma automática as dependencias vendar entre no container e execute o comando

```
 php composer.phar install
```
