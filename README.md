# MVC@PHP

[![GitHub issues](https://img.shields.io/github/issues/devmboehm/mvcat)](https://github.com/devmboehm/mvcat/issues)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/devmboehm/mvcat)

### Demo 
- see: [DEMO](https://github.com/devmboehm/mvcat/tree/master/demo)
- url: localhost/mvcat/demo

### Composer
```composer require bomi/mvcat```

### Start
```php
use bomi\mvcat\service\Mvcat;
require_once '../libs/vendor/autoload.php';

Mvcat::build("manifest.json") 
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
			"path": "users",
			"methods" : ["GET"],
			"parameters": {
				"controller" : "User",
				"action": "index"
			}
		},{
			"path": "users/api",
			"parameters": {
				"controller" : "user",
				"action": "api"
			}
		},{
			"path": "users/{active:true|false}",
			"methods" : ["GET"],
			"parameters": {
				"controller" : "User",
				"action": "active"
			}
		},{
			"path": "users/{id:\\d+}",
			"methods" : ["GET"],
			"parameters": {
				"controller" : "User",
				"action": "user"
			}
		},{
			"path": "users/form/{form:create|update}",
			"methods" : ["GET"],
			"parameters": {
				"controller" : "User",
				"action": "form",
				"active" : true
			}
		},{
			"path": "users",
			"methods" : ["POST"],
			"parameters" : {
				"controller" : "User",
				"action" : "create"
			}
		}
	],
	"templates" : [
		{
			"name" : "main",
			"path" : "public/templates/main.phtml",
			"variables" :  {
				"title" : "DEMO",
				"header" : "Demo header"
			}
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
	}
}
```
