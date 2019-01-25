<p align="center">
    <h1 align="center">Информация по тестовому заданию. Разработка веб-сервиса.</h1>
    <br>
</p>

Структура проекта
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes  
    widgets/
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    modules/
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
# Установка
Затягиваем проект с github <br>
Затем переходим в корень проекта (в данном случае папка rest) и инициализируем проект
> git clone git@github.com:haosknight/rest.git rest <br>
> php init <br>
<div>Выбираем</div>
<ul><li>[0] Development</li>
<li>[1] Production</li></ul>
<div>Вводим "yes"</div>
<div>Затем запускаем обновление проекта копозитором по lock файлу, для того что бы создать папку vendor и затянуть в нее все модули присутствующие в проекте на момент последнего комита</div>

> composer update --lock

<div>Из папки backend переместить все в папку api, т.к. php init создает папку backend</div>

# Коментарии к заданиям
<h2>1 Задание</h2>

<h2>2 Задание</h2>

<h2>3 Задание</h2>

<h2>4 Задание</h2>
