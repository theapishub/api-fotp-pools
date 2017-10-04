# Starting

http://docs.phinx.org/en/latest/migrations.html

```
composer install
```

# Migrate db

## First steps

```
mkdir -p db/migrations db/seeds
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
```

# Running web server

```
php -S localhost:8000 index.php
```