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
header('Content-type: application/json');

/** add caching header * */
if ($config['cacheHeaderEnabled']) {
    header("Expires: Sat, 24 Jan 1970 04:10:00 GMT"); // date from the past 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always changed 
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false); // just for MSIE 5 
    header("Pragma: no-cache");
}

if (empty($requestUrl) || $requestUrl === false) {
    echo json_encode(null);
    exit();
}

$cachefile = 'cache/cached-' . md5($requestUrl) . '.json';
$cachetime = $config['cacheTimeInSeconds'];

// Serve from the cache if it is younger than $cachetime
if ($config['cacheEnabled'] && file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    include($cachefile);
    exit;
}
ob_start(); // Start the output buffer