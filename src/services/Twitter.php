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

class Twitter extends Service {

    private $url;
    private $count = 0;

    function __construct($url, $config) {
	parent::__construct($config);
	$this->url = $url;
    }

    public function getName() {
	return "twitter";
    }

    public function fetchCount() {
	$serviceCall = 'https://cdn.api.twitter.com/1/urls/count.json?url=' . urlencode($this->url);
	$result = $this->getContent($serviceCall);
	$json = json_decode($result, true);
	
	$this->log($json);
	
	$this->count = $json['count'];
    }

    public function getCount() {
	return $this->count;
    }

}