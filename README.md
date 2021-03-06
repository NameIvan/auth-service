# auth-service
Repository for register &amp; auth users.
Also track events to external analytic service.
# how to start
- install 
[docker](https://docs.docker.com/install/)( 
[mac](https://docs.docker.com/docker-for-mac/),
[windows](https://docs.docker.com/docker-for-windows/)
) with 
[docker-compose](https://docs.docker.com/compose/install/)
- make sure that **80** port in **127.0.0.1** interface is free
- in the project dir run the next commands:
```bash
docker-compose up -d
open http://localhost
```

### Install vendors
```bash
composer install
```


### Rebuild images & recreate containers
```bash
docker-compose build --no-cache
docker-compose up -d --force-recreate
```

### To enable hot code refreshing in container follow instructions in ./docker-compose.yml


### Run test
```bash
./test.sh
```

### RabbitMQ management
[http://localhost:15672/](http://localhost:15672/) **[guest:guest]**
- for add new producers or consumers describe them in "config/rabbitmq.php"

### API documentation
- open in browser /web/docs/index.html
- for generate documentation:
```bash
    php bin/generate-documentation.php
```
