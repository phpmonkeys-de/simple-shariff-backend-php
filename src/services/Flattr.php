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

class Flattr extends Service {

    private $url;
    private $count = 0;

    function __construct($url, $config) {
	parent::__construct($config);
	$this->url = $url;
    }

    public function getName() {
	return "flattr";
    }

    public function fetchCount() {
	$serviceCall = 'https://api.flattr.com/rest/v2/things/lookup/?url=' . urlencode($this->url);
	$result = $this->getContent($serviceCall);
	$json = json_decode($result, true);

	if (isset($json['flattrs'])) {
	    $this->count = $json['flattrs'];
	}

	// we found a location and have to fetch it now
	if (isset($json['message']) && $json['message'] === 'found') {
	    $count = $this->fetchLocation($json['location']);
	    if ($count !== NULL) {
		$this->count = $count;
	    }
	}
    }

    protected function fetchLocation($locationUrl) {
	$result = $this->getContent($locationUrl);
	$json = json_decode($result, true);
	if (isset($json['flattrs'])) {
	    return $json['flattrs'];
	}
	return NULL;
    }

    public function getCount() {
	return $this->count;
    }

}
