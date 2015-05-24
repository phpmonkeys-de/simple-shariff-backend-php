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

class GooglePlus extends Service {

    private $url;
    private $count = 0;

    function __construct($url, $config) {
	parent::__construct($config);
	$this->url = $url;
    }

    public function getName() {
	return "googleplus";
    }

    public function fetchCount() {
	$gplusApiKey = $this->configuration['googlePlusApiKey'];
	
	$serviceCall = 'https://clients6.google.com/rpc'; //?key=' . $this->apiKey;
	
	if (isset($gplusApiKey)) {
	    $serviceCall .= "?key=" . $gplusApiKey;
	}
	
	$result = $this->getContent($serviceCall);
	$json = json_decode($result, true);

	if (isset($json[0]) && isset($json[0]['result'])) {
	    if (isset($json[0]['result']['metadata']['globalCounts']['count'])) {
		$this->count = $json[0]['result']['metadata']['globalCounts']['count'];
	    }
	}
    }

    public function getCount() {
	return $this->count;
    }

    protected function getContent($url, $timeout = 5) {
	$json = '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $this->url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($json))
	);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
    }
}