<?php

/*
 +------------------------------------------------------------------------+
 | The SimpleExcel Component                                              |
 +------------------------------------------------------------------------+
 | Copyright © 2011-2013 Faisalman <fyzlman@gmail.com>                    |
 | Copyright © 2015 (c) Serghei Iakovlev <me@klay.me>                     |
 +------------------------------------------------------------------------+
 | This source file is subject to the MIT License that is bundled         |
 | with this package in the file LICENSE.md.                              |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to me@klay.me so I can send you a copy immediately.                    |
 +------------------------------------------------------------------------+
*/

namespace SimpleExcel\Exception;

/**
 * Defines SimpleExcel exception enum
 *
 * @package SimpleExcel\Exception
 */
abstract class SimpleExcelException
{
    const UNKNOWN                    = 0;
    const FILE_NOT_FOUND             = 1;
    const FILE_EXTENSION_MISMATCH    = 2;
    const ERROR_READING_FILE         = 3;
    const INVALID_DOCUMENT_NAMESPACE = 4;
    const FIELD_NOT_FOUND            = 5;
    const ROW_NOT_FOUND              = 6;
    const COLUMN_NOT_FOUND           = 7;
    const CELL_NOT_FOUND             = 8;
    const FILETYPE_NOT_SUPPORTED     = 9;
    const MALFORMED_JSON             = 10;
}
