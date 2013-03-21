<?php

namespace SimpleExcel\Enums;

/**
 * Defines SimpleExcel exception enum
 * 
 * @author  Faisalman
 * @package SimpleExcel
 */

/** define exception enum */
abstract class SimpleExcelException
{
    const UNKNOWN_ERROR                 = 0;
    const FILE_NOT_FOUND                = 1;
    const FILE_EXTENSION_MISMATCH       = 2;
    const ERROR_READING_FILE            = 3;
    const INVALID_DOCUMENT_NAMESPACE    = 4;
    const WORKSHEET_NOT_FOUND           = 5;
    const ROW_NOT_FOUND                 = 6;
    const COLUMN_NOT_FOUND              = 7;
    const CELL_NOT_FOUND                = 8;
    const FILETYPE_NOT_SUPPORTED        = 9;
    const MALFORMED_JSON                = 10;
    const UNIMPLEMENTED_METHOD          = 11;
    const DEPRECATED_METHOD             = 12;
}
