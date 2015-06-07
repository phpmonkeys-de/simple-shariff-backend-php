<?php

/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 PhpMonkeys.de
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

include "./config.php";

$requestUrl = filter_input(INPUT_GET, "url", FILTER_VALIDATE_URL);

include './top-cache.php';

if (!empty($config['hostFilter'])) {
    $pos = strpos($requestUrl, $config['hostFilter']);
    if ($pos != 7 && $pos != 8) {
	echo json_encode(null);
	return;
    }
}

function __autoload($class_name) {
    include './services/' . $class_name . '.php';
}

include './Service.php';
include './ServiceRegistry.php';

$registry = new ServiceRegistry($config);

$registry->registerService(new Facebook($requestUrl, $config));
$registry->registerService(new Flattr($requestUrl, $config));
$registry->registerService(new GooglePlus($requestUrl, $config));
$registry->registerService(new LinkedIn($requestUrl, $config));
$registry->registerService(new Pinterest($requestUrl, $config));
$registry->registerService(new Reddit($requestUrl, $config));
$registry->registerService(new StumbleUpon($requestUrl, $config));
$registry->registerService(new Twitter($requestUrl, $config));
$registry->registerService(new VKontakte($requestUrl, $config));
$registry->registerService(new Xing($requestUrl, $config));

echo json_encode($registry->createOutput());

include('./bottom-cache.php');
