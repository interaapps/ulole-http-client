# Ulole HTTP Client `1.0`
## Installation
Module
#### UPPM
```
uppm i interaapps/ulole-http-client
```
#### Composer
```
composer require interaapps/ulole-http-client
```

## Getting started
```php
$client = new HttpClient("https://ping.intera.dev");

$authors = $client->get("/authors")
    ->send()
    ->json();

foreach ($authors as $author) {
    echo $author->name . "\n";
}

$success = $client->post("/authors", [
    "name" => "Author"
])
    ->bearer("HelloWorld")
    ->send()
    ->ok();
    
if ($success) {
    echo "Done!";
}
    


```


## Request-Settings
On a HttpRequest or for all HttpRequests on the HttpClient you can use some methods which will change some request options.
```php

$request = $client->get("https://google.com");

$request->header("X-Header", "Value");
$request->bearer("ABCDE");

// Set Query Parameter
$request->query("key", "value");

// Set Body
$request->body("this-is-the-body=yey");

// Set Json Body
$request->json(["hello" => "world"]);


$request->timeout(150);

$request->followRedirects();
$request->notFollowRedirects();


$request->formData([
    "file" => new CURLFile("file.txt")
]);

$response = $request->send();

var_dump($response->json());
// From json model
var_dump($response->json(User::class));

var_dump($response->header("content-type"));
var_dump($response->body());
var_dump($response->status());
var_dump($response->ok());
```