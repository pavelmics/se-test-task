#Приложение Skyeng
[ТЗ](https://docs.google.com/document/d/1yr4Fm7Ul_EoJK2o75HGISm8RirQ9IOz9drIyKvKn8sA/edit?usp=sharing)

##Развертываение проекта
Для развертывания проекта достаточно склонировать этот репозиторий и выполнить bash-скрипт `create_env.sh`. При выполнение скрипта необходимо указать root пароль к серверу mysql. 
```
$ sh create_env.sh <instrt-mysql-root-password-hire>
```
Подразумевается, что в системе установленны:
- PHP;
- Клиент mysql;
- Сервер mysql;
- [composer](https://getcomposer.org/) - должен быть установлен глобально;
- nodejs и npm;
- [Gulpjs](http://gulpjs.com/)(глобально) - если нет, то `# npm install -g gulp`;
- [Bower](http://bower.io/)(глобально) - если нет, то `# npm install -g bower`

После успешного выполнения скрипта приложение стартует на 0.0.0.0:3000.

##Описание проекта

Серверная часть проекта выполнена на Silex, в качестве ORM использованна [Eloquent](http://laravel.com/docs/5.0/eloquent). По сути это RESTFull сервис (за исключением странички самого приложения).

Фронтенд проекта выполнен как SPA в связке Angular.js + Bootstrap + Less + jquery + underscore.js. В качестве системы сборки использован Gulp.

