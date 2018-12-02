<?php

use Faisalman\SimpleExcel\Enums\Datatype;
use Faisalman\SimpleExcel\SimpleExcel;
use Faisalman\SimpleExcel\Spreadsheet\Cell;

class XLSXTest extends PHPUnit\Framework\TestCase
{
    public function testParser()
    {
        $excel = new SimpleExcel();
        $excel->loadFile('test/XLSX/test.xlsx');
        $this->assertEquals(array(new Cell('ID'), new Cell('Nama'), new Cell('Kode Wilayah')), $excel->getWorksheet(1)->getRecord(1));
        $this->assertEquals(array(new Cell(1, Datatype::NUMBER), new Cell('Kab. Bogor'), new Cell(1, Datatype::NUMBER)), $excel->getWorksheet(1)->getRecord(2));
    }
}

?>