## How to install ##

```
```
after cloning run in shell
```
composer install
```
Composer will load dependencies and install DEV environment.
Please delete frontend folder.

After that run
```
./yii migrate
```
to adjust database

run
```
./yii migrate-rbac
```
to up rbac tables

And then init rbac rules and create first user admin
format: ```username:email:password-8-chars-min```
```
./yii file_share/init admin:email@email.com:12345678
```

And last...

Have a nice day!