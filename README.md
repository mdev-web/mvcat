## MVC@

A simple MVC framework created in PHP. This framework use configuration file to find requested urls. For more understanding you can start demo project. 

![](https://img.shields.io/github/release/devmboehm/bomi/mvcat.svg) ![](https://img.shields.io/github/languages/top/devmboehm/bomi/mvcat.svg)

### Prerequisites
- PHP version 7.4 or higher installed on your machine
- A web server to serve the files

### Installing
You can install **bomi\mvcat** into your project using composer.

`$ composer require bomi/bomi\mvcat`

### Usage

##### Start
```php
MvcFactory::build()
	->template("main", setMainTemlate())	// add template "main" to array
	->template("error", setMainTemlate())	// add template "error" to array 
	->errorController(new Error())		// add controller for error handling 
	->configure("routes.json")	        // add configuration file 
	->execute();	   		        // execute MVC
```

##### Configuration file routes.json
```json
{
	"version" : "v.1.0.0",
	"destinations" : {
		"views": "pathToViews/",
		"controllers": "pathToControllers/"
	},
	"routes" : [
		{
			"path": "url/path",
			"methods" : ["GET", "POST"],
			"parameters": {
				"controller" : "controllerName",
				"action": "actionName",
				"other": "additional"
			}
		}
	]
}
```
