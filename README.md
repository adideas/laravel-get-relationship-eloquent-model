# Laravel get relationship eloquent models

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
