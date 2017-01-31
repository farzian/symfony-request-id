# symfony-request-id

A simple Symfony bundle to add a unique request ID to the request headers.



## Installation

```
$ composer require snowflake/request-id
```

```json
{
    "require": {
        "snowflake/request-id": "~1.0"
    }
}
```



## Enable the bundle

```php
// in app/AppKernel.php
public function registerBundles() {
	$bundles = array(
		// ...
		new SnowFlake\RequestIdBundle\SnowFlakeRequestIdBundle(),
	);
	// ...
}
```



# Usage

After installing and enabling the bundle, a new header will be added to the request headers bag which can simply be accessed by the header name. The default header name is **X-Request-ID** :

```php
$request->headers->get("X-Request-ID")
```



# Configurations



**header_name** 

The header name by which the request ID would be accessible. Default is **X-Request-ID**.



**prefix** 

A custom string which will be added to the beginning of the generated request ID. An example use case could be having different prefixes to distinguish the request IDs easier in cases like using them in logging and so on. Default is empty.



**override_existing**

To force to override the possible existing header with the same name as configured for this request ID header. For example by enabling a special module on Apache web server, you might already have a request ID header with the same configured name. Default is **false**.


So the default configs look like:

    snow_flake_request_id:

        header_name: 'X-Request-ID'
        prefix: ''
        override_existing: false


# Available parameters

You will have these parameters available to access the configured values for the configurations:

**snow_flake_request_id.header_name**


**snow_flake_request_id.prefix**


**snow_flake_request_id.override_existing**