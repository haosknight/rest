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
<div>Затем запускаем обновление проекта копозитором по lock файлу, для того что бы создать папку vendor и затянуть в 
нее все модули присутствующие в проекте на момент последнего комита</div>

> composer update --lock

<div>Из папки backend переместить все в папку api, т.к. php init создает 
папку backend</div>
<div>При настройки хоста ссылаться на корневую директорию проекта, 
в которой лежит .htaccess. Он настроен для разделения фронта и бэка</div>

# Коментарии к заданиям

<div>В развернутом приложении yii2 создан модуль v1, который содержит файл модуля, 
модель и контроллер для обработки поступающих запросов. Входящие запросы 
по Url-адресам обрабатываются и перенаправляются на контроллер модуля v1 согласно
правилам Url менеджера заданым в конфиге бэк приложения.</div>
<h2>1 Задание</h2>
<div>Для работы с данными используется модель модуля v1, 
которая в одном методе генерирует все 1000 заданий, 
а в другом методе формирует и возвращает перечень задач, 
из всех имеющихся задач, по входным параметрам.</div>
<div>За прием запросов и ответы отвечает rest контроллер,
который имеет один экшн для обработки всех входящих запросов.
Перечень задач можно получить отправив запрос по адресу:</div>
<code>http://your-domain.ru/api/v1/task</code>
<div>Можно использовать GET параметры:</div>
<code>?title=&page=2&start=10&limit=10</code>,
<div>где</div>
<ul><li>title - поисковая фраза по полю "Заголовок" (если оставить пустым или не указывать, то не будет учитываться)</li>
<li>page - номер страницы (не предумал как его использовать, хотя grid во фронте передает этот параметр при запросе)</li>
<li>start - задача, с которой нужно начинать формировать выборку</li>
<li>limit - количество задач в выборке</li></ul>
<div>Если не указывать не одного параметра, то, по умолчанию, возвращается первые 10 задач</div>
<div>По <b>дополнительному</b> заданию реализовал кэширование списка задач при генерации. Если кэш пустой, 
то генерируем список и записываем в кэш, иначе берем задания из кэша. Используется файловый кэш. 
Время жизни установлено на 59 минут.</div>
<div>Данные возвращаются в JSON формате</div>

<h2>2 Задание</h2>
<div>В модели модуля v1 создан метод для поиска задачи по id 
в сгенерированном списке задач.</div>
<div>За прием и обработку запросов по поиску одной задачи по id отвечает, 
тот же контроллер и тот же экшн, что и в первом задании. Данный экшн 
возвращает подробную информацию о задаче, если был передан id. 
Для получение информации по задаче отправлять запрос по адресу:</div>
<code>http://your-domain.ru/api/v1/task/:id</code>
<div>Данные возвращаются в JSON формате</div>

<h2>3 Задание</h2>
<div>Для фронта используется ExtJs. Перечень задач выводиться элементом 
<code>Ext.grid.Panel</code>. Grid использует хранилище <code>Ext.data.Store</code>,
которое самостоятельно обращается к веб-сервису
по указанному url (через компонент proxy) и обновляет данные на основе
полученного ответа от веб-сервиса в формате JSON.</div>
<div>В Grid интегрирована панель пагинации (с которой возникло 
много сложностей: не мог найти примеров подробно описывающих 
взаимодействие панели пагинации с сервером, а так же были сложности 
при реализации поиска), которая позволяет листать страницы с задачами выводя 
по 10 задач на каждой странице.</div>
<div>Поисковый запрос отправляется при срабатывании события onChange текстового
поля. При возникновенни данного события в Store обновляется эксра-параметр, 
title, в который вкладывается содержимое текстового поля. Затем вызывается 
1 загрузка первой страницы Grid, через Store. Это вызывает запрос к 
веб-серверу содержащий экстра параметр, в качестве обычного GET параметра,
а так же параметры для вывода первой страницы.</div>
<div>Долго разбирался в механизмах совместной работы Grid, Store, Form и 
pagingtoolbar, пока пришел к описаному решению.</div>

<h2>4 Задание</h2>
<div>Вывод подробной информации о задаче осуществляется с помощью формы в 
модальном окне <code>Ext.window.Window</code>. Обращение к веб-сервису 
осуществляется при нажатии на кнопку в гриде (actioncolumn), 
находящейся в одной строке с выбраной задачей. После успешного 
выполненного запроса вызывается модальной окно и обновляются поля формы 
и заголовок окна.</div>
<div>Возникли сложности при обновлении полей формы. Долго не мог найти примеров 
и информации по динамическому обновлению полей формы.</div>