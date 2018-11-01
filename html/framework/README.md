MySQL
=====
* explicit_defaults_for_timestamp: https://dev.mysql.com/doc/refman/5.7/en/server-system-variables.html#sysvar_explicit_defaults_for_timestamp

Common
======
* behaviors, grid, traits, interfaces, validators, widgets - ( "yii2-developer/yii2-extend": "~0.0.1", ) лежат в krok\extend
* Имена полей в таблицах базы данных camelCase
* Имена директорий в camelCase
* Имена переменных в camelCase
* Реляции получают суффикс Relation ( getCreatedByRelation )
* Наименования модулей как и имена таблиц в ***единственном*** числе!

Editor
======
```php
<?= $form->field($model, 'text')->widget(
    Yii::createObject([
        'class' => \krok\editor\interfaces\EditorInterface::class,
        'model' => $model,
        'attribute' => 'text',
    ])
) ?>
```

Model
=====
* id - должно быть!
* hidden - для записи, active - для учетных записей. Вариант выбора в виде select поля. Для пунктов создаются константы ( HIDDEN_NO = 0 / HIDDEN_YES = 1 | ACTIVE_NO = 0 / ACTIVE_YES = 1 ) соответственно!
* createdBy - создатель записи, внешний ключ на таблицу пользователей, ( DELETE - SET NULL , UPDATE - RESTRICT ) поведение - krok\extend\behaviors\CreatedByBehavior::class 
* createdBy не нужно выводить в шаблонах и фильтре
* createdAt - дата и время создания, updatedAt - дата и время последнего обновления. Поведение - krok\extend\behaviors\TimestampBehavior::class 

Форматтер типов, для:
--------------------

**view.php**

```php
'createdAt:datetime',
'updatedAt:datetime',
```

**index.php**

```php
[
    'class' => krok\extend\grid\ActiveColumn::class,
    'attribute' => 'title',
],
[
    'class' => krok\extend\grid\HiddenColumn::class,
],
[
    'class' => krok\extend\grid\DatePickerColumn::class,
    'attribute' => 'createdAt',
],
[
    'class' => krok\extend\grid\DatePickerColumn::class,
    'attribute' => 'updatedAt',
],
```

Для примера можно взять модуль - @vendor/yii2-developer/yii2-example
--------------------------------------------------------------------

Установка
=========

./docker-exec framework/yii migrate/up
./docker-exec framework/yii access/install
