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

# Reset db
```
note: Remove db on production
php vendor/robmorgan/phinx/bin/phinx status -e production
php vendor/robmorgan/phinx/bin/phinx rollback -e production -t 0
```

# Running web server

```
Using the virtual host to run the api
```

# Heroku

https://api-fotp-pools.herokuapp.com/

```
heroku login
heroku git:remote -a api-fotp-pools
git push heroku master
heroku run php vendor/bin/phinx status
heroku run php vendor/bin/phinx migrate
```

# API Doc

http://apidocjs.com/

```
npm install apidoc -g

apidoc -i application/ -o apidoc/
```