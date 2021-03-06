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
abstract class Service {

    protected $configuration = array();

    public function __construct($config) {
	$this->configuration = $config;
    }

    protected function getContent($url, $timeout = 5) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	if ($data === false) {
	    $this->log(curl_error($ch));
	}
	curl_close($ch);
	return $data;
    }

    protected function log($variable) {
	if (isset($this->configuration['debug']) && $this->configuration['debug'] === true) {
	    $output = get_class($this) . " - ";
	    $output .= print_r($variable, true);
	    file_put_contents("debug.log", $output, FILE_APPEND | LOCK_EX);
	}
    }

    public abstract function getName();

    public abstract function fetchCount();

    public abstract function getCount();
}
