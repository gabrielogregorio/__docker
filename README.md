# Docker
Estudos envolvendo a criação de três containers usando docker. A idéia é a criação de um container mysql que armazenará um banco de dados, um container conectado que armazenará uma API nodejs que conecta ao banco de dados e retorna uma lista de itens e por fim um container PHP que conterá um website que busca os dados da API

Imagem do site em PHP rodando em um container, realizando consultas na API NODE em outro container que busca dados outro container com uma imagem do mysql.
![Imagem do site em PHP rodando](imagem.png)

O processo todo foi feito pelo Terminal do Windows, mas também tem opções para trabalhar com a interface conforme você pode ver no docker Desktop:
![Imagem do docker Desktop](processo.png)

Instale o Doker: https://www.docker.com/products/docker-desktop
Imagens para usar: https://hub.docker.com/_/node


------

# Configurando o Mysql
## Docker file para uma imagem Mysql
```docker
FROM mysql
ENV MYSQL_ROOT_PASSWORD senha_db
```

## Contruindo a imagem  
```shell
docker build -t mysql-image -f .\db\Dockerfile .
```
| flag    |   Descrição                            |
|---------|----------------------------------------|
|  t      |   Nome para a imagem (Nome aleatório)  |
|  f      |   Espcifica o docker file              |
|  .      |   pasta atual para construiri o docker |

## Ver imagens disponível para uso:    
```shell
docker image ls
```

## Criando/executando um container com pasta compartilada     
```shell
docker run -d -v ${PWD}/db/data:/var/lib/mysql --rm --name mysql-container mysql-image
```   
| flag    |   Descrição                            |
|---------|----------------------------------------|
| -d      |   detect => Libera o terminal          |
| -v      |   Pasta Compartilhar:Pasta Container   |
| --rm    |   Remover se já existir                |
| --name  |   Nome do container                    |
|         |   Nome da imagem                       |


## Ver os containers em execução
```shell
docker ps 
```

## Acessar o container      
```shell
docker exec -it mysql-container //bin//bash
```       
| flag    |   Descrição                            |
|---------|----------------------------------------|
| -it     | Acessar o terminal                     |
|         | Container                              |
|         | Local do bash                          |

## Acessar o mysql e ver dados
```shell
mysql -uroot -psenha_db
create database database_db;
ALTER USER 'root' IDENTIFIED WITH mysql_native_password BY 'senha_db';
flush privileges;
exit;
exit
```

# Configurando a API nodejs
## Acesse a pasta api
```shell
npm init
```

```shell
npm install --save-dev nodemon
npm install --save express
npm install --save mysql
```

## Edit o package.json para
```json
"scripts": {
   "start": "nodemon ./src/index"
}
```

## Crie o dockerfile na pasta api/
```dockerfile
FROM node:14-slim
WORKDIR /home/node/app
CMD npm start
```

## Crie a imagem para o node    
```shell
docker build -t node-image -f Dockerfile .
```

## Crie/Execute o container    
```shell
docker run -d -v $pwd/:/home/node/app -p 9001:9001 --link mysql-container --rm --name node-container node-image
```    
| flag    |   Descrição                            |
|---------|----------------------------------------|
| -p      | Porta do local: Porta do container     |
| --link  | Link com o mysql-container             |


## Acesse o localhost para ver a API Node rodando conectado com o container mysql
```text
http://localhost:9001/obter_itens
```


-------------------------------------

# Configurando o PHP
## Contruindo a imagem do php, dockerfile na pasta site:
```dockerfile
FROM php:7.2-apache
WORKDIR /var/www/html
```

## Criando a imagem, va na pasta raiz
```shell
docker build -t php-image -f .\site\Dockerfile .
```

## Criando/executando o container linkado com o node container
```shell
docker run -d -v $pwd/site:/var/www/html -p 8888:80 --link node-container --rm --name php-container php-image
```

## Acessando o site
http://localhost:8888


--------

# outros recursos
## Parar o container
```shell
docker stop nome-container
```

## Faz o container mysql executar o arquivo especificado (No Windows)   
```shell
Get-Content db/script.sql | docker exec -i mysql-container mysql -uroot -psenha_db
```    
| flag    |   Descrição                            |
|---------|----------------------------------------|
| Get..nt |   Código para o docker executar        |
| exec    |   Rodar comandos no container          |
| -i      |   Modo interativo, esperar resposta    |
| --name  | Nome do container                      |
| -p      | Senha do mysql do dockerfile           |
