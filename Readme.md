Тестовое задание (на русском) Back-end Developer

Необходимо создать модуль для хранения и конвертации валют.
Модуль должен иметь предопределенный список валют (на усмотрение разработчика - захардкожен в модуле или добавляется через админку). Курсы валют должны быть загружены с https://freecurrencyapi.com/ (документация по API по ссылке https://freecurrencyapi.com/docs) для всех доступных валют и сохранены в БД. Обновление курсов должно происходить раз в сутки. Модуль должен предоставить сервис для конвертации цены из одной валюты в другую (использование примерно такое $converter->convert(123, ‘USD’, ‘RUB’);). Также должна быть создана страница в админке, где должны быть выведены все сохраненные курсы валют.
Для интеграции с https://freecurrencyapi.com/ нельзя использовать готовые библиотеки именно для этого сайта (например, https://github.com/everapihq/freecurrencyapi-php). Интеграция должна быть реализована с помощью Guzzle, curl, file_get_content или другого инструмента для выполнения http запросов или сетевых запросов.
Для написания конвертера валют можно использовать любой удобный фреймворк.

Test (in English) Back-end Developer 

Create a module for storing and converting currencies.
The module must have a predefined list of currencies (at the discretion of the developer - hardcoded in the module or added via the admin panel). Exchange rates should be downloaded from https://freecurrencyapi.com/ (API documentation at https://freecurrencyapi.com/docs) for all available currencies and stored in the database. Rates should be updated once a day. The module should provide a service for converting prices from one currency to another (using something like this $converter->convert(123, 'USD', 'RUB');). Also, a page in the admin panel should be created, where all saved exchange rates should be displayed.
Libraries implementing integration with https://freecurrencyapi.com/ (e.g. https://github.com/everapihq/freecurrencyapi-php) shouldn’t be used. Integration should be implemented with Guzzle, curl, file_get_content or any other tool aimed to make http requests or network requests.
Any suitable framework can be used to implement the currency converter module.

![Image alt](https://github.com/Vavavenya/freecurrencyapiClient/blob/main/Converter.png)
![Image alt](https://github.com/Vavavenya/freecurrencyapiClient/blob/main/currencies.png)


# CRON

`php bin/console cron:create` - Create a new job

`php bin/console cron:run` - Run cron daemon

### Example
![Image alt](https://github.com/Vavavenya/freecurrencyapiClient/blob/main/CreateCronJob.png)





