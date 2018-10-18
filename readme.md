# SimpleExcel.php

http://faisalman.github.com/simple-excel-php

Easily parse / convert / write between Microsoft Excel XML / CSV / TSV / HTML / JSON / XLSX / etc formats

## Features

* Available parsers: Microsoft Excel 2003 XML, CSV, TSV, HTML, JSON, XLSX
* Available writers: Microsoft Excel 2003 XML, CSV, TSV, HTML, JSON

## Requirement

- PHP >= 7.0

## Usage

```php
use Faisalman\SimpleExcel\SimpleExcel

$excel = new SimpleExcel();
$excel->loadFile('test.csv', 'CSV');

print_r($excel->getWorksheet(1)->getCell(1, 1));

$excel->getWorksheet(1)->insertRecord(array('add', 'another', 'row')); // insert more record
$excel->exportFile('~/Downloads/saved.json', 'JSON');
```

## Development

[![Build Status](https://travis-ci.org/faisalman/simple-excel-php.png)](https://travis-ci.org/faisalman/simple-excel-php)

Testing

```sh
$ composer install
$ composer test
```

What's still missing:

- Writer support for XLSX format
- Writer & parser support for XLS / ODS formats

## License

Copyright (c) 2011-2018 Faisal Salman <<f@faisalman.com>>

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
