<?php

namespace SimpleExcel\Enums;

/**
 * Defines SimpleExcel datatype enum
 * 
 * @author  Faisalman
 * @package SimpleExcel
 */

/** define datatype enum */
abstract class Datatype
{
    const TEXT      = 0;
    const NUMBER    = 1;
    const LOGICAL   = 2;
    const DATETIME  = 3;
    const CURRENCY  = 4;
    const FORMULA   = 5;
    const ERROR     = 6;
}
