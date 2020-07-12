# Instruções para rodar o projeto

## Instalando as dependências

### API
```
docker-compose run --rm composer composer install
``` 

### APP
```
docker-compose run --rm app npm install
``` 

## Configurações

### API 

Copiar o arquivo ```api/env.example``` para ```api/env```

Configurar as credenciais de email em ```api/.env``` 

Gerar a chave da aplicação:
```
docker-compose run --rm api php artisan key:generate --ansi
``` 

Aplicando as *migrations*:
```
docker-compose run --rm api php artisan migrate
``` 

Aplicando os *seeders*:
```
docker-compose run --rm api php artisan db:seed
``` 

### APP

Copiar o arquivo ```app/env.example``` para ```api/env```

## Iniciando o projeto

Subir os serviços docker
```
docker-compose up api app mysql redis queue
``` 

Acessar o endereço http://localhost:8080 :rocket: :rocket: :rocket: