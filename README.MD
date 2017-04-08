# Prossimo backend #

Backend software to handle frontend requests, external API-calls, authentication.

Built on Symfony2 framework (v2.7.9)

## Requirements ##

- PHP5.5 or later
- NGinx
- PostgreSQL9.3 (Or MySQL)

## Installation ##

The following steps are meant to be used on a development server. If you're interested in deploying to our staging or production environment, see [prossimo-deployment](https://github.com/prossimo-ben/prossimo-deployment) repo.

- Create project folder

```bash
$ mkdir /var/www/backend
```

- Clone latest project 

```bash
$ cd /var/www/backend
$ git@github.com:prossimo-ben/prossimo-backend.git .
```

- Set permissions

```bash
$ sudo chown -R www-deployer:www-data /var/www/backend

$ HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
```

- Create database

```bash
$ sudo passwd postgres
$ enter new password

$ sudo -u postgres psql
```

```sql
$ ALTER ROLE postgres WITH password 'your password';
$ CREATE DATABASE prossimo;

$ \q
```

- Setup vendor libraries 

```bash
$ composer install
```

- Create schema, update it to latest version and load fixtures

```bash
$ php app/console doctrine:schema:drop --force && php app/console doctrine:schema:update --force && php app/console doctrine:fixtures:load
```

- Create certificates for SSL transport (required for JWT)

```bash
$ mkdir -p app/var/jwt
$ openssl genrsa -out app/var/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem
```

Write your `jwt_key_pass_phrase` in `parameters.yml`

- Run server

```bash
$ php app/console server:run
```


## Using migrations ##

```
doctrine:migrations
  :diff     Generate a migration by comparing your current database to your mapping information.
  :execute  Execute a single migration version up or down manually.
  :generate Generate a blank migration class.
  :migrate  Execute a migration to a specified version or the latest available version.
  :status   View the status of a set of migrations.
  :version  Manually add and delete migration versions from the version table.
```
