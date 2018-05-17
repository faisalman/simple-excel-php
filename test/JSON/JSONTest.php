<?php

use Faisalman\SimpleExcel\SimpleExcel;
use Faisalman\SimpleExcel\Spreadsheet\Cell;

//require_once('src/SimpleExcel/SimpleExcel.php');

class JSONTest extends PHPUnit\Framework\TestCase
{
    public function testParser()
    {
        $excel = new SimpleExcel();
        $excel->loadFile('test/JSON/test.json', 'JSON');
        $this->assertEquals(array(new Cell('ID'), new Cell('Nama'), new Cell('Kode Wilayah')), $excel->getWorksheet(1)->getRecord(1));
    }
    
    public function testWriter()
    {
        $excel = new SimpleExcel();
        $excel->insertWorksheet();
        $excel->getWorksheet(1)->insertRecord(array('ID', 'Nama', 'Kode Wilayah'));
        $this->assertEquals('[[{"0":"ID","1":"Nama","2":"Kode Wilayah"}]]', $excel->toString('JSON'));
    }
}

?>
