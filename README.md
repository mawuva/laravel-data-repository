# Repository Pattern implementation for Laravel and Easily build Eloquent queries from API requests

This is a Simple Repository Pattern implementation for Laravel Projects and 
an easily way to build Eloquent queries from API requests

## Installation

You can install the package via composer:

```bash
composer require mawuekom/laravel-data-repository
```

### Laravel <br/>

After register the service provider to the **`providers`** array in **`config/app.php`**

```php
'providers' =>
    ...
    Mawuekom\DataRepository\DataRepositoryServiceProvider::class
    ...
];
```
<br/>

Publish package config

```bash
php artisan vendor:publish --provider="Mawuekom\DataRepository\DataRepositoryServiceProvider"
```

### Lumen <br/>

Go to **`bootstrap/app.php`**, and add this in the specified key

```php
$app->register(Mawuekom\DataRepository\DataRepositoryServiceProvider::class);

```

Then, create **`config`** folder in your root directory <br/>
Once done, create **`query-builder.php`** in the config folder and add this config in it

```php
<?php

return [

    /*
     * By default the package will use the `include`, `filter`, `sort`
     * and `fields` query parameters as described in the readme.
     *
     * You can customize these query string parameters here.
     */
    'parameters' => [
        'include' => 'include',

        'filter' => 'filter',

        'sort' => 'sort',

        'fields' => 'fields',

        'append' => 'append',
    ],

    /*
     * Related model counts are included using the relationship name suffixed with this string.
     * For example: GET /users?include=postsCount
     */
    'count_suffix' => 'Count',

    /*
     * By default the package will throw an `InvalidFilterQuery` exception when a filter in the
     * URL is not allowed in the `allowedFilters()` method.
     */
    'disable_invalid_filter_query_exception' => false,

    /*
     * By default the package inspects query string of request using $request->query().
     * You can change this behavior to inspect the request body using $request->input()
     * by setting this value to `body`.
     *
     * Possible values: `query_string`, `body`
     */
    'request_data_source' => 'query_string',
];

```

Create also **`json-api-paginate.php`** in the config folder and add this config in it 

```php
<?php

return [

    /*
     * The maximum number of results that will be returned
     * when using the JSON API paginator.
     */
    'max_results' => 30,

    /*
     * The default number of results that will be returned
     * when using the JSON API paginator.
     */
    'default_size' => 30,

    /*
     * The key of the page[x] query string parameter for page number.
     */
    'number_parameter' => 'number',

    /*
     * The key of the page[x] query string parameter for page size.
     */
    'size_parameter' => 'size',

    /*
     * The name of the macro that is added to the Eloquent query builder.
     */
    'method_name' => 'jsonPaginate',

    /*
     * If you only need to display Next and Previous links, you may use
     * simple pagination to perform a more efficient query.
     */
    'use_simple_pagination' => false,

    /*
     * Here you can override the base url to be used in the link items.
     */
    'base_url' => null,

    /*
     * The name of the query parameter used for pagination
     */
    'pagination_parameter' => 'page',
];

```

Once done all of this, go back to **`bootstrap/app.php`**, and add the config files you created

```php
$app->configure('query-builder');
$app->configure('json-api-paginate');
```

This config allows you to filter, sort and include eloquent relations based on API requests.
<br/>
It also allows to paginate and display data with the JSON API spec.

It using : 

 - [Laravel-query-builder](https://spatie.be/docs/laravel-query-builder/v3/introduction) to build queries

 - [laravel-json-api-paginate](https://github.com/spatie/laravel-json-api-paginate) that plays nice with the JSON API spec

 <br/>
 Check on this links for more informations
 <br/> <br/>

## Usage

This package has two repositories classes : 
 - **`BaseRepository`** which implements common methods for eloquent model
 - **`BaseApiRepository`** that extends from `BaseRepository` and implements additional methods to build Eloquent queries from API requests

### Using **`BaseRepository`**

Your repository will look like this

```php
<?php

namespace App\Repositories;

use Mawuekom\DataRepository\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return Model::class;
    }

    /**
     * Determine the columns on which the search will be done
     */
    public function searchFields(): array
    {
        return [];
    }
}
```

Your repository class should extends from `Mawuekom\DataRepository\Repositories\BaseRepository` class which implements the interface `Mawuekom\DataRepository\Repositories\Contracts\BaseRepositoryContract` that has the following methods : 

```php
<?php

namespace Mawuekom\DataRepository\Repositories\Contracts;

interface BaseRepositoryContract
{
    /**
     * Get all model's data 
     * 
     * @param array $columns
     * 
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Retrieve the list of data and can add some adjustments to it
     * Like model's relations...
     * 
     * @param string $orderByColumn
     * @param string $orderBy
     * @param array $with
     * @param array $columns
     * 
     * @return mixed
     */
    public function list($orderByColumn, $orderBy = 'desc', $with = [], $columns = ['*']);

    /**
     * Create new data
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update data by one attribute
     * 
     * @param string $attribute
     * @param string|int $id
     * @param array $data
     * 
     * @return mixed
     */
    public function update(string $attribute, $id, array $data);

    /**
     * Update data by some params
     * 
     * @param array $params
     * @param array $data
     * 
     * @return mixed
     */
    public function updateBy(array $params, array $data);

    /**
     * Delete data by ID
     * 
     * @param int $id
     * 
     * @return mixed
     */
    public function delete($id);

    /**
     * Delete data by some params
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function deleteBy(array $params);

    /**
     * Search data
     * 
     * @param string|int $searchTerm
     * 
     * @return mixed
     */
    public function search($searchTerm);

    /**
     * Find data by ID
     * 
     * @param int $id
     * @param array $columns
     * 
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * Find data by some params
     * 
     * @param array $params
     * @param array $columns
     * 
     * @return mixed
     */
    public function findBy(array $params, $columns = ['*']);

    /**
     * Find all data by some params
     * 
     * @param array $params
     * @param array $columns
     * 
     * @return mixed
     */
    public function findAllBy(array $params, $columns = ['*']);

    /**
     * Get data paginated
     * 
     * @param int $perPages
     * 
     * @return mixed
     */
    public function paginate($perPages = 15);
}
```

### Using **`BaseApiRepository`**

Your repository will look like this

```php
<?php

namespace App\Repositories;

use Mawuekom\DataRepository\Repositories\BaseApiRepository;

class UserRepository extends BaseApiRepository
{
    public function model()
    {
        return Model::class;
    }

    /**
     * Determine the columns on which the search will be done
     */
    public function searchFields(): array
    {
        return [];
    }
    
    /**
     * Columns on which filterig will be done
     */
    public function filters(): array
    {
        return ['name', 'first_name', 'sex'];
    }

    /**
     * Determine by which property the results collection will be ordered
     */
    public function sorts(): array
    {
        return [];
    }

    /**
     * Determine the relation that will be load on the resulting model   collection
     */
    public function collectionRelation(): array
    {
        return [];
    }

    /**
     * Determine the relation that will be load on the resulting model resource
     */
    public function resourceRelation(): array
    {
        return [];
    }

    /**
     * Define a couple fields that will be fetch to reduce the overall size of your SQL query
     */
    public function fields(): array
    {
        return [];
    }
}
```

Your repository class should extends from `Mawuekom\DataRepository\Repositories\BaseApiRepository` class which extends `Mawuekom\DataRepository\Repositories\BaseRepository` and implements the interface `Mawuekom\DataRepository\Repositories\Contracts\BaseApiRepositoryContract` that has the following methods : 

```php
<?php

namespace Mawuekom\DataRepository\Repositories\Contracts;

interface BaseApiRepositoryContract
{
    /**
     * Get all resources
     * 
     * @return mixed
     */
    public function getAllResources();

    /**
     * Get all resources paginated
     * 
     * @return mixed
     */
    public function paginateAllResources();

    /**
     * Get all resources by
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function getAllResourcesBy(array $params);

    /**
     * Paginate all resources get by
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function paginateAllResourcesBy(array $params);

    /**
     * Get resource
     * 
     * @param string $attribute
     * @param string|int $id
     * 
     * @return mixed
     */
    public function getResource(string $attribute, $id);

    /**
     * Get resource by
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function getResourceBy(array $params);

    /**
     * Search resource
     * 
     * @param string $searchTerm
     * 
     * @return mixed
     */
    public function searchResources($searchTerm);

    /**
     * Paginate searched resources
     * 
     * @param string $searchTerm
     * 
     * @return mixed
     */
    public function paginateSearchResources($searchTerm);
}
```

### **Hope this package will help you build awesome things** <br><br>

## Report bug
Contact me on Twitter [@ephraimseddor](https://twitter.com/ephraimseddor)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

