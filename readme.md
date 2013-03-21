# Simple Excel

http://faisalman.github.com/simple-excel-php

Easily parse / convert / write between Microsoft Excel XML / CSV / TSV / HTML / JSON / etc formats

## Features

* Available parsers: Microsoft Excel 2003 XML, CSV, TSV, HTML, JSON
* Available writers: Microsoft Excel 2003 XML, CSV, TSV, HTML, JSON

## Usage

```php
use SimpleExcel\SimpleExcel

$excel = new SimpleExcel('CSV');
$excel->parser->loadFile('test.csv');

echo $excel->parser->getCell(1, 1);

$excel->convertTo('JSON');
$excel->writer->addRow(array('add', 'another', 'row'));
$excel->writer->saveFile('example');
```

## Development

[![Build Status](https://travis-ci.org/faisalman/simple-excel-php.png?branch=master)](https://travis-ci.org/faisalman/simple-excel-php)

Testing

```sh
$ phpunit --configuration test/phpunit.xml
```

Next version 0.4.0-alpha is now available under [develop](https://github.com/faisalman/simple-excel-php/tree/develop) branch

## License

Copyright (c) 2011-2012 Faisalman <<fyzlman@gmail.com>>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
