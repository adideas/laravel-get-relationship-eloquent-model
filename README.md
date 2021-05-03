# Laravel get relationship eloquent models

## Имея одну или множество моделей Eloquent, благодоря этому пакету можно получить все ее отношения и их тип во время выполнения! 
### Иногда это действительно необходимо например для системы удалений где есть связи с другими сущностями. Например нужно удалить модель и динамически узнать что нужно еще удалить. Для этого вам не нужно знать названия методов в модели. И уж тем более подстраивать их названия не под архитектуру а под что то другое. 

### Этот пакет создан для других разработчиков, которым необходимо знать об отношениях. 

### Laravel как получить все отношения
### как получить названия всех связей
### getRelations()

--

## Having one or many Eloquent models, thanks to this package, you can get all of its relationships and their type at runtime

### Sometimes this is really necessary, for example, for a deletion system where there are connections with other entities. For example, you need to delete a model and dynamically find out what else needs to be deleted. You don't need to know the names of the methods in the model to do this. And even more so to adjust their names not for architecture, but for something else.

### This package is for other developers who need to know about relationships.

----

**View (get) all links (links) of any eloquent Laravel models**

- [Installation](#installation)
- [Usage](#usage)
- [Config](#config)

## Installation

Require this package with composer using the following command:  

```bash
composer require adideas/laravel-get-relationship-eloquent-model
```

Put star :) please

## Usage

```php

use App\Http\Controllers\Controller;
use Adideas\RelationFinder\Relations;

class MyController extends Controller
{



    public function show(MyModel $myModel, Relations $relations)
    {
        $relations->where('name', 'myRelationFunction'); // return collect

        dd($relations); // return collect

        Relations::relations($myModel)->where('name', 'myRelationFunction'); // return collect

    }



}

  ```

OR

```php

use Adideas\RelationFinder\RelationsFinder;

class MyModel extends Model
{
    use RelationsFinder;

}
  ```
```php
use App\Http\Controllers\Controller;

class MyController extends Controller
{



    public function show(MyModel $myModel)
    {
        MyModel::relations()->where('name', 'myRelationFunction'); // return collect
        
        // or

        $myModel->relations()->where('name', 'myRelationFunction'); // return collect
    }



}

  ```

## Config

If you want to see all models! Install the key.

```php

class MyModel extends Model
{
    const WITH_VENDOR_RELATION = true;
    
    // or

    public $withVendorRelation = true;
}
  ```
