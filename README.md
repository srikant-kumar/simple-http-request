
# Simple HTTP Request : PHP

This is a simple HTTP Request Class that help with many convenience methods for making any type of server to server request without knowing CURL.

## How to Use It ?

**Method 1 : Direct Usage**

 1. Take Pull From : [https://github.com/srikant-kumar/simple-http-request ](https://github.com/srikant-kumar/simple-http-request)
 2. Create Folder in your project with **[FOLDER_NAME_YOU_WANT]** copy all files into that.
 3. Follow the below code for refrence

```php
<?php
require './FOLDER_NAME_YOU_WANT/src/Httprequest.php';

use Httprequest\Httprequest;
//---This Sample Code For POST Request
$request = new Httprequest('https://example.com');
$post_data = [
	'key1' => $value1,
	'key2' => $value2,
	'key3' => $value3,
];
$request_header = [
	'Authorization' => 'Bearer e5e87a27-3a33-4e03-b3c5-e31d82fdc2f3',
	'x-api-key' => 'mf2yEb92mzcXArFNh2QP7rfpyTS4hgT'
];
//----Options of Http Request
$request->set_content_type('multipart/form-data');
$request->set_request_method('POST');
$request->set_post_data($post_data);
//----Request Header If Needed
$request->set_request_headers($request_header);
$request->run();
$response = $request->get_response();
```
**Method 2 : [Using Composer](https://packagist.org/packages/srikant-kumar/simple-http-request)**

 1. Run composer command  in your project Directory: `composer require srikant-kumar/simple-http-request`
 2. Include  : `vendor/autoload.php`
 3. Follow the below code for refrence
```php
<?php
require '.vendor/autoload.php';

use Httprequest\Httprequest;
//---This Sample Code For POST Request
$request = new Httprequest('https://example.com');
$post_data = [
	'key1' => $value1,
	'key2' => $value2,
	'key3' => $value3,
];
$request_header = [
	'Authorization' => 'Bearer e5e87a27-3a33-4e03-b3c5-e31d82fdc2f3',
	'x-api-key' => 'mf2yEb92mzcXArFNh2QP7rfpyTS4hgT'
];
//----Options of Http Request
$request->set_content_type('multipart/form-data');
$request->set_request_method('POST');
$request->set_post_data($post_data);
//----Request Header If Needed
$request->set_request_headers($request_header);
$request->run();
$response = $request->get_response();
```
## Set Request Method & Usages
Other method you can use in your request :

| Request Methods                                          | Value                                                                                                                                                                                                  | Option       |
|----------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------|
| ```$request->set_content_type('multipart/form-data');``` | application/json  <br> application/x-www-form-urlencoded <br> text/plain <br> multipart/form-data <br> <br> Default : multipart/form-data                                                              | **Required** |
| ```$request->set_request_method('POST');```              | GET <br> POST <br> PUT <br> PATCH <br> DELETE <br> <br> Default : GET                                                                                                                                  | **Required** |
| ```$request->set_post_data($post_data);```               | If Request Method is Post Make an Array of post data shown as below <br> ``` $post_data = [ 	'key1' => $value1, 	'key2' => $value2, 	'key3' => $value3, ]; ```                                            | Optional     |
| ```$request->set_query_parameter($query_params);```      | Make an Array Of Query Pramter <br> ```  $query_params = [ 	'key1' => 'value1', 	'key2' => 'value2' ]; ``` <br> It will produce url with parametrs  <br> ``` REQUEST_URL?key1=value1&key2=value2 ```     | Optional     |
| ```$request->set_request_headers($request_header);```    | Make an Array of Request Headers shown as below <br> ``` $request_header = [ 	'Authorization' => 'Bearer e5e87a27-3a33-4e03-b3c5-e31d82fdc2f3', 	'x-api-key' => 'mf2yEb92mzcXArFNh2QP7rfpyTS4hgT' ]; ``` | Optional     |
| ```$request->set_basic_auth($username,$password);```     | Basic Auth : (String) $username  & (String) $password                                                                                                                                                  | Optional     |
| ```$request->set_user_agent($user_agent);```             | $user_agent : (String) Example : ```Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion```                                                                                 | Optional     |
| ```$request->enable_cookies($cookie_file_path);```       | $cookie_file_path : Absolute path to a txt file where cookie information will be stored.                                                                                                               | Optional     |
| ```$request->disable_cookies();```                       | Disable Cookies : No Parameter Required                                                                                                                                                                | Optional     |
| ```$request->enable_ssl();```                            | For Enabling SSL Check                                                                                                                                                                                 | Optional     |
| ```$request->disable_ssl();```                           | For Disabling SSL Check                                                                                                                                                                                | Optional     |
| ```$request->set_timeout($time);```                      | $time : (Int) 10 (in second)                                                                                                                                                                           | Optonal      |
| ```$request->run();```                                   | Final Method For Running the HTTP Request                                                                                                                                                              | **Required** |

## Get Response Method & Usages
Other method you can use after completion of a  request :
**Note :  Call this method after   $request->run();**
| Methods                                          | Value                                                                                                                                                                                                  | Option       |
|----------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------|
| ```$request->set_content_type('multipart/form-data');``` | application/json  <br> application/x-www-form-urlencoded <br> text/plain <br> multipart/form-data <br> <br> Default : multipart/form-data                                                              | **Required** |
| ```$request->set_request_method('POST');```              | GET <br> POST <br> PUT <br> PATCH <br> DELETE <br> <br> Default : GET                                                                                                                                  | **Required** |
| ```$request->set_post_data($post_data);```               | If Request Method is Post Make an Array of post data shown as below <br> ``` $post_data = [ 	'key1' => $value1, 	'key2' => $value2, 	'key3' => $value3, ]; ```                                            | Optional     |
| ```$request->set_query_parameter($query_params);```      | Make an Array Of Query Pramter <br> ```  $query_params = [ 	'key1' => 'value1', 	'key2' => 'value2' ]; ``` <br> It will produce url with parametrs  <br> ``` REQUEST_URL?key1=value1&key2=value2 ```     | Optional     |
| ```$request->set_request_headers($request_header);```    | Make an Array of Request Headers shown as below <br> ``` $request_header = [ 	'Authorization' => 'Bearer e5e87a27-3a33-4e03-b3c5-e31d82fdc2f3', 	'x-api-key' => 'mf2yEb92mzcXArFNh2QP7rfpyTS4hgT' ]; ``` | Optional     |
| ```$request->set_basic_auth($username,$password);```     | Basic Auth : (String) $username  & (String) $password                                                                                                                                                  | Optional     |
| ```$request->set_user_agent($user_agent);```             | $user_agent : (String) Example : ```Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion```                                                                                 | Optional     |
| ```$request->enable_cookies($cookie_file_path);```       | $cookie_file_path : Absolute path to a txt file where cookie information will be stored.                                                                                                               | Optional     |
| ```$request->disable_cookies();```                       | Disable Cookies : No Parameter Required                                                                                                                                                                | Optional     |
| ```$request->enable_ssl();```                            | For Enabling SSL Check                                                                                                                                                                                 | Optional     |
| ```$request->disable_ssl();```                           | For Disabling SSL Check                                                                                                                                                                                | Optional     |
| ```$request->set_timeout($time);```                      | $time : (Int) 10 (in second)                                                                                                                                                                           | Optonal      |
| ```$request->run();```                                   | Final Method For Running the HTTP Request                                                                                                                                                              | **Required** |



## Why Simple Http Request?
In daily development life we need to call third parties api for the projects. So every time we have to write cURL code that is hard to remember ( I don't know about others but i have problem to remeber the things 😀😀😀 ) that's why i made this package.

**It is simple and easy to use.**

## License

Request is licensed under the MIT