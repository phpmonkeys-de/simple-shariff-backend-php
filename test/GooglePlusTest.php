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
require_once '../src/Service.php';
require_once '../src/ServiceRegistry.php';
require_once '../src/services/GooglePlus.php';

class GooglePlusTest extends PHPUnit_Framework_TestCase {

    public function testIntegration() {
	$url = 'http://www.heise.de/newsticker/meldung/Das-Scheitern-der-netzpolitischen-Jedi-Ritter-der-SPD-2651479.html';
	$config = array(
	    "services" => array(
		"googleplus" => true
	    ),
	    "googlePlusApiKey" => "", // optional
	    "debug" => true
	);
	$registry = new ServiceRegistry($config);
	$registry->registerService(new GooglePlus($url, $config));

	$res = $registry->createOutput();
	$this->assertArrayHasKey('googleplus', $res);
	$this->assertTrue(is_int($res['googleplus']));
    }

}
