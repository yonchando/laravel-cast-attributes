# Laravel Cast Attribute

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

Laravel cast attribute is model custom cast json column to Class entity 

## Installation

Via Composer

```bash
composer require yonchando/laravel-cast-attirbutes
```

## Usage

**Model**

```php

class User extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['json'];

    protected $casts = [
        'json' => UserJson::class
    ];
}
```

**UserJson**
> **private property must have setter with camelCase start with `set`**

```php
class UserJson extends \Yonchando\CastAttributes\CastAttributes
{
    private string $firstName;
    
    protected string $lastName;
    
    public string $gender;
    
    public Image $image;
    
    public  function getFirstName(): string
    {
        return $this->firstName;
    }
    
    public  function setFirstName(string $firstName):void 
    {
        $this->firstName = $firstName;
    }
    
    public function getLastName(){
        return $this->lastName;
    }
}
```

**Image**
> For sub property class use trait  `CastProperty`

```php
class Image
{
    use \Yonchando\CastAttributes\Traits\CastProperty;
    
    public string $filename;
    public int $size;
    public string $path;
    
    public function url()
    {
        return Storage::url($this->path);
    }
}
```

**Controller**

```php
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        
        $user->json->getFirstName();
        $user->json->getLastName();
        $user->json->gender;
        
        // access function in image class
        $user->json->image->url();
        
        // to array
        $user->json->toArray();
        $user->json->image->toArray();
        
    }
    
    public function store(Request $request)
    {
        // use class
        $user = new User([
            'json' => UserJson::create($request->all()),
        ]);
        
        // use an array
        $user = User::create([
            'json' => [
                'first_name' => $request->get('first_name'),        
                'last_name' => $request->get('last_name'),
                'gender' => $request->get('gender'),
                'image' => $request->get('image'),
            ]
        ])
    }
}
```

## Methods available for CastProperty trait

| Name    | modifier      | parameters          | Description                          |
|---------|---------------|---------------------|--------------------------------------|
| toArray | public        |                     | class property to array              |
| toJson  | public        | int $options        | class property to json_encode string |
| create  | public static | array\|object $data | initialize class                     |

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email von.chando@gmail.com instead of using the issue tracker.

## Credits

- [Author Name][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/yonchando/laravel-cast-attirbutes.svg?style=flat-square

[ico-downloads]: https://img.shields.io/packagist/dt/yonchando/laravel-cast-attirbutes.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/yonchando/laravel-cast-attirbutes

[link-downloads]: https://packagist.org/packages/yonchando/laravel-cast-attirbutes

[link-author]: https://github.com/yonchando

[link-contributors]: ../../contributors
