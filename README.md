# SMARTAPPS API Client PHP

This library can help developers create webpages integrated with S.M.A.R.T platform (www.smartapps.com.br)

## Requirements

	- Composer
	- cUrl Library
	- PHP >= 5.3

## Source

You can found the source of library in the **src** folder.

## Install examples with composer

1. First step, Install composer :)
To do it, you need run <b>composer install</b> or <b>php compose.phar install</b>.

2. Run example :D
On the main folder, run the example with CLI: <b>php examples/basic_data.php</b>

> You can install this library using **Composer**. So, add package name **smartapps/php-api** on the **dev-master** version. If you want do it using CLI, run the command: **composer require "smartapps/php-api:dev-master"**.

## Examples

### Basic data (basic_data.php)
This example show how to get data from a application

### Exec method (exec_method.php)
This example show how to execute a method on a application

### Post simple (exec_method_post_simple.php)
This example show to send a simple block of data.

### Post massive data (exec_method_post_massive.php)
This example show how to send a array of data to any method on a application

### View forms
This example show how you can see forms avaiables on a application.

### View schemas
This example show how you can see data schemas to a application.

Note: if you liked the examples and you want more, feel free and help us. let's go change the world using the web.

## Library methods

## Methods
Below you can see methods on this library.

### connect($app, $api_user=false, $api_key=false)
You need use this method to connect on S.M.A.R.T

	- Params
	$app 		: Application that you want connect.
	$api_user	: API USER :P, You can found your, on API Tool in the option **registered keys** on your environment.
	$api_key 	: API KEY :P, You can found it on API Service in your environment.

### connectionClose()
You need use this method to disconnect of S.M.A.R.T

### method($conn, $schema, $method, $args=false, $return="json", $app=false)
You can use this method to do a GET request directly using a method as reference.

	- Params
	$conn 		: Connection object reference, found it on return of method **connect**
	$schema 	: Schema of data
	$method 	: Method name
	$args		: Array of arguments that method need.
	$return 	: Type of request return
	$app 		: Subscribe application when execute this method.

### methodPost($conn, $schema, $method, $postVars, $args=false, $return="json", $app=false)
You can use this method to do a POST request directly using a method as reference.

	- Params
	$conn 		: Connection object reference, found it on return of method **connect**
	$schema 	: Schema of data
	$method 	: Method name
	$args		: Array of arguments that method need.
	$return 	: Type of request return
	$app 		: A way to subscribe application after connected.

### getSchemas($conn)
You can use this method to see which schemas avaiable on a app.

	- Params
	$conn 		: Connection object reference, found it on return of method **connect**

### getForms($conn, $schema)
You can use this method to see forms.

	- Params
	$conn 		: Connection object reference, found it on return of method **connect**
	$schema 	: Schema of data

### getData($conn, $schema, $form)
You can use this method to get data.

	- Params
	$conn 		: Connection object reference, found it on return of method **connect**
	$schema 	: Schema of data
	$form 		: Form name

### getFile($conn, $file, $mime, $date)
You can use this method to get a filepath.

	- Params
	$conn 		: Connection object reference, found it on return of method **connect**
	$file 		: File name
	$mime 		: Mimetype of the file
	$date 		: Date file registry

### sendExec($conn, $app, $schema, $form, $postVars, $return="json")
You can use this method to send data to a form.

	- Params
	$conn 		: Connection object reference, found it on return of method **connect**
	$app 		: Application
	$schema 	: Schema of data
	$form 		: Form name
	$postVars 	: Array data for send
	$return 	: Return of request

### sendTo($conn, $schema, $form, $postVars=false, $app=false)
You can use this method to send data to a form directly.

	- Params
	$conn 		: Connection object reference, found it on return of method **connect**
	$app 		: Application
	$schema 	: Schema of data
	$form 		: Form name
	$postVars 	: Array data for send
	$app 		: A way to subscribe application after connected.


If you want more details about API Tool of S.M.A.R.T Platform, see API Docs on Smartapps web site (www.smartapps.com.br).

@author José Wilker <jose.wilker@smartapps.com.br>