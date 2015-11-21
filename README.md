# SimpleExcel

[![Build Status](https://img.shields.io/travis/sergeyklay/simple-excel-php/master.svg?style=flat-square)](https://travis-ci.org/sergeyklay/simple-excel-php)
[![Latest Version](https://img.shields.io/packagist/v/sergeyklay/simple-excel-php.svg?style=flat-square)](https://github.com/phalcon/sergeyklay/simple-excel-php)
[![Software License](https://img.shields.io/packagist/l/sergeyklay/simple-excel-php.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/sergeyklay/simple-excel-php.svg?style=flat-square)](https://packagist.org/packages/sergeyklay/simple-excel-php)

Easily parse, convert and write between Microsoft Excel formats.

This is a fork from https://github.com/faisalman/simple-excel-php.

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

Testing

```sh
$ phpunit --configuration test/phpunit.xml.dist
```

## License

SimpleExcel is open-sourced software licensed under the [MIT License](LICENSE.md).

Copyright © 2011-2012 Faisalman <fyzlman@gmail.com><br>Copyright © 2015 Serghei Iakovlev <me@klay.me>
