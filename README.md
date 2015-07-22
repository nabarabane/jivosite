# jivosite
**Простейшая PHP-обертка для приема webhook-уведомлений от Jivosite**

## Установка
### Простая
Скачайте и распакуйте архив с библиотекой в удобное вам место  
Затем просто включите файл "Webook.php", там где вы планируете его использовать
```php
require('{Путь до файла}Webhook.php');
```

### Composer
Добавьте в блок "require" в composer.json вашего проекта:
```json
"nabarabane/jivosite": "~1.0"
```
или в командной строке:
```sh
composer require nabarabane/jivosite:~1.0
```
Не забудьте включить автолоадер
```php
require('autoload.php');
```

## Использование
Ознакомьтесь с [официальной документацией](https://www.jivosite.ru/support/knowledge-base/article/jivosite-api#webhooks), чтобы получить подробную информацию о параметрах событий, передаваемых вам на сайт.  
Библиотека предоставляет собой простую обертку с минимумом абстракции, внимательно читайте доки перед передачей ответов на уведомления.
```php
<?php

require('Webhook.php');

$listener = new Webhook();

/*
Задайте обработчики для тех событий, которые вы хотите слушать
Вторым параметром в метод "on" передается callback-функция,
которая будет вызвана при получении
соответсвующего событию уведомления от Jivosite
*/
$listener->on('chat_accepted', function($data, $webhook) {
	// В $data - массив с параметрами уведомления

	// Тут ваш код

	// Вызовите метод "respond", если хотите послать ответ
	$webhook->respond(array(
		'result' => 'ok',
		'custom_data' => array(/* ... */)
		// И т.д. Сверяйтесь с документацией
	));
});
$listener->on('chat_finished', function($data, $webhook) {/* ... */});
$listener->on('offline_message', function($data, $webhook) {/* ... */});

// Запускаем слушателя
$listener->listen();
```