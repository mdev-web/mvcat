## MVC@PHP

[![GitHub issues](https://img.shields.io/github/issues/devmboehm/mvcat)](https://github.com/devmboehm/mvcat/issues)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/devmboehm/mvcat)

### Demo 
- see: [DEMO](https://github.com/devmboehm/mvcat/tree/master/demo)
- url: localhost/mvcat/demo

### Composer
```
composer require bomi/mvcat
```

### Start
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

### Configuration file 
#### Manifest.json
```json
{
	"version" : "v.1.0.0",
	"destinations" : {
		"views": "public/views/",
		"controllers": "bomi/mvcat/demo/classes/controllers/"
	},
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
	],
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
	"languages" : {
		"de" : "public/i18n/lang-de.properties",
		"ru" : "public/i18n/lang-ru.properties"
	}
}
```
### Call view in template
- see: [main.phtml](https://github.com/devmboehm/mvcat/blob/master/demo/public/templates/main.phtml)
```
${View::VIEW_RENDER};
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
- your controller must inherit the bomi\mvcat\base\Controller
- [example](https://github.com/devmboehm/mvcat/blob/master/demo/classes/controllers/User.php)

### Languages
1. define your languages in *.properties file. [example](https://github.com/devmboehm/mvcat/tree/master/demo/public/i18n)
2. add paths to manifest.json
3. call method to translate: $i18n->get("your.key.value", $attrs);
