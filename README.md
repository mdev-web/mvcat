
[![GitHub issues](https://img.shields.io/github/issues/devmboehm/mvcat)](https://github.com/devmboehm/mvcat/issues)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/devmboehm/mvcat)

--------------
## MVC@PHP
library 

### Demo 
- see: [DEMO](https://github.com/devmboehm/mvcat/tree/master/demo)
- url: localhost/mvcat/demo

### Composer
```
composer require bomi/mvcat
```

### Using
```php
use bomi\mvcat\service\Mvcat;
require_once '../libs/vendor/autoload.php';

$language = "de"; // or your implementation to find a language

Mvcat::build("manifest.json") 
	->language($language)
	->execute(function(int $code, Exception $exception = null){
		if ($code !== 200) {
			echo $exception->getMessage();
		}
	});
```

#### .htaccess
- [see](https://github.com/devmboehm/mvcat/blob/master/demo/.htaccess)
- change line to your base url 
```
RewriteBase /mvcat/demo/
```

### Configuration file 
#### Manifest.json
```json
{
	"version" : "v.1.0.0",
	"routing" : {
		"views": "public/views/",
		"controllers": "bomi/mvcat/demo/classes/controllers/",
		"routes" : [
		{
			"path": "/",
			"parameters": {
				"controller" : "home",
				"action": "index"
			}
		},{
			"path": "users/{id:\\d+}",
			"methods" : ["GET"],
			"parameters": {
				"controller" : "User",
				"action": "user"
			}
		}
		]
	},
	"templates" : [
		{
			"name" : "main",
			"path" : "public/templates/main.phtml"
		}
	],
	"data" : {
		"connection" : {
			"host" : "",
			"dbname" : "",
			"username" : "",
			"password" : "",
			"additional" : 
				{
					"key" : "value"
				}
		},
		"repositories" : {
			"user" : "bomi/mvcat/demo/classes/repositories/UserRepository"
		}		
	},
	"i18n" : {
		"folder" : "public/i18n/",
		"default" : "lang-de.properties",
		"languages" : {
			"ru" : "lang-ru.properties"	
		}
	}
}
```
### Call view in template
- see: [main.phtml](https://github.com/devmboehm/mvcat/blob/master/demo/public/templates/main.phtml)
```php
echo ${View::VIEW_RENDER};
```
- use template 
```php
echo $this->view("users/form.inc", $params, "main");
``` 
- render view without tepmplate 
```php
echo $this->view("users/form.inc", $params);
``` 

### Controller
- your controller should inherit the bomi\mvcat\base\Controller
- [example](https://github.com/devmboehm/mvcat/blob/master/demo/classes/controllers/User.php)
- fetch request information
```php
$this->getRequestContext()->getMethod(); // POST, GET, PUT, DELETE, OPTIONS
$this->getRequestContext()->getPostData; // post data
$this->getRequestContext()->getGetData;  // get data
``` 

### Languages
1. define your languages in *.properties file. [example](https://github.com/devmboehm/mvcat/tree/master/demo/public/i18n)
2. add paths to manifest.json
3. use in template or view: 
* Without arguments ${key}
* With arguments ${key>>arg1,arg2,arg3}
4. use in constructor
* $this->_i18n->get("key", ["arg1, arg2"]);
