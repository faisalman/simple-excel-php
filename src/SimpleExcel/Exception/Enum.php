<?php
/**
 * Defines SimpleExcel exception enum
 * 
 * @author  Faisalman
 * @package SimpleExcel
 */

/** define exception enum */
abstract class SimpleExcel_Exception_Enum
{
    const Unknown                   = 0;
    const FileNotFound              = 1;
    const FileExtensionNotMatch     = 2;
    const ErrorReadingFile          = 3;
    const InvalidDocumentNamespace  = 4;
    const FieldNotFound             = 5;
    const RowNotFound               = 6;
    const ColumnNotFound            = 7;
    const CellNotFound              = 8;
    const FileTypeNotSupported      = 9;
}
?>