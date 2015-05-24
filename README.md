# simple-shariff-backend-php

A simple backend for [https://github.com/heiseonline/shariff](https://github.com/heiseonline/shariff) written in PHP without using any 3rd party PHP library. 

This library is compatible to PHP 5.3+

## Who should use this
There's already a shariff backend implementation in PHP, but this is different because it don't depends on PHP 5.4. Some older server systems (for example Ubuntu 10.04 LTS) come with PHP 5.3 and the original backend is not working on these machines. So you can only upgrade your server (have fun :smiley:) or use an alternative implementation like this one.

## Something special?
Yes, PHP should be compiled with json and curl support, because the simple backend depends on these two "system" libraries.

Something else? 
Yes, all services the original backend provides are supported, but some implementations are different. For example the Facebook and the Flattr implementation. And because it is fun, VKontakte is supported as well. If you miss some service, send a pull request or open an issue.

### Facebook implementation
This implementation uses the Graph API 2.3 to fetch the share count. But you have to provide app id and app secret so the backend may send a server call to facebook. Graph API 2.3 is used, because it is the newest API at the moment and every new Facebook app only supports this version.
If you don't use an Facebook app and the configuration is missing, a default Graph request is used. The count is a bit different and may be not that accurate. But, this is better than nothing. The original FQL implementation is not used, because only old Facebook apps that support Graph API 2.0 can access the FQL API. This dependency is not fair :smiley:

### Flattr implementation
Flattr returns a JSON with a url to the real "thing". This implementation searchs the url and fetches the "thing" information to provide the right count.

## Testing
There's a integration test for every service.

## How to use
The usage is really easy. Just copy the content of the `src` folder to your server (don't forget the subfolders).

Copy `config.sample.php` to `config.php` and change the content. You can activate/deactivate the services (default: all possible services are on), change the time to live for the caching and add the Google API key and the Facebbok App information.

You may disable caching for debugging purpose, but should use it in productive enviroments, because the services calls are not that fast.

You should add a `hostFilter`, so no one can use your service to fetch information from facebook, twitter and so on. The `hostFilter` simply checks, if the url you request the sharing information for starts with the filter information. The protocol is not needed.  

The webserver should be able to write to the cache directory. Its name is `cache`. 

Now, you can call the url you installed the skript and add the request parameter `url` with a url.

```bash
http://example.org/shariff-backend/index.php?url=http://example.org/myReallyGreatArticle.html
```

You will get the JSON as in the original implementation.

## TODO
* Error handling is missing atm
* Better caching