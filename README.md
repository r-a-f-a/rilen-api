## BTG PANEL API (Laravel-based)

This application will serve as the companion app to another project called BTG-PANEL.
It is meant to be a Laravel API, using Dingo and JWT for authentication.

[BTG Panel Frontend App](https://github.com/giep-br/BTG-Panel)

## Requirements for build container project
> docker version 1.12.1 +

> docker-compose version 1.8.0 +

Enter on docker folder of the project
``` sh
$ cd docker
```
Enter on environment folder (development,production)
``` sh
$ cd development
```
Run the docker-compose build command to generate the configured image project
``` sh
$ docker-compose build
```
Run the docker-compose up command with the -d parameter to start the container in background
``` sh
$ docker-compose up -d
```
( -d: Run containers in the background )


## Accessing the container
To access the container just run the following command

> docker exec -it $container bash

$container: can be both the name or id
> docker ps ( list all running containers )


### Copyright

![allin](http://allin.com.br/wp-content/uploads/2016/02/logo_rodape_vermelho.png)

![locaweb](http://www.locaweb.com.br/templates/site-novo-2015/images/locaweb-header.png)