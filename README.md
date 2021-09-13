# Api-remonline
API для crm Ремонлайн (Guzzle)

[**Документация**](https://remonline.ru/docs/api)

### Установка

Необходимо установить Guzzle через composer:

```json
"require": "require": {
    "guzzlehttp/guzzle": "~6.0"
  }
```

### Методы

```
`contact()` - создание клиента
`order()` - создание задачи
`update()` - обновление  клиента
`updateStatus()` - изменение статуса задачи
```

### Пример создания клиента

```php
$params = [
        "name" => "Name",
        "phone[]"=>"Phone",
        "address"=>"Address",
];

$Remonline = new Remonline('api_key'); // api_key пользователя
$newContact = $Remonline->contact($params);
```

### Пример получения всех задач

```php
$Remonline = new Remonline('api_key'); // api_key пользователя
$newOrder = $Remonline->order(); // Обратите внимание, передавать ничего не нужно
```
