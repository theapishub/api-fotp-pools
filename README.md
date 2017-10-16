# Starting

http://docs.phinx.org/en/latest/migrations.html

```
composer install
```

# Migrate db

## First steps

```
mkdir -p db/migrations db/seeds
seed:run
```

## Linux

```
php vendor/bin/phinx
```

## Windows

```
vendor/robmorgan/phinx/bin/phinx init
vendor/robmorgan/phinx/bin/phinx status
vendor/robmorgan/phinx/bin/phinx migrate
vendor/robmorgan/phinx/bin/phinx create NewMigrate
seed:run -s 
```

# Running web server

```
Using the virtual host to run the api
```