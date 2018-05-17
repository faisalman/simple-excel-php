<?php

use SimpleExcel\SimpleExcel;
use SimpleExcel\Spreadsheet\Cell;
use SimpleExcel\Spreadsheet\Worksheet;

//require_once('src/SimpleExcel/SimpleExcel.php');

class CSVTest extends PHPUnit\Framework\TestCase
{
    public function testParser()
    {
        $excel = new SimpleExcel();
        $excel->loadFile('test/CSV/test.csv', 'CSV');
        
        $this->assertEquals('ID', $excel->getWorksheet(1)->getCell(1, 1)->value);
        $this->assertEquals('Kab. Cianjur', $excel->getWorksheet(1)->getCell(3, 2)->value);
        
        $row6 = array(new Cell('5'), new Cell('Comma, inside, double-quotes'), new Cell('3'));
        $this->assertEquals($row6, $excel->getWorksheet(1)->getRecord(6));
        
        $col3 = array(new Cell('Kode Wilayah'), new Cell('1'), new Cell('1'), new Cell('1'), new Cell('2'), new Cell('3'));
        $this->assertEquals($col3, $excel->getWorksheet(1)->getColumn(3));
        
        $excel = new SimpleExcel();
        $excel->loadFile('test/CSV/test2.csv', 'CSV', array('delimiter' => ';'));
        
        $this->assertEquals('ID', $excel->getWorksheet(1)->getCell(1, 1)->value);
        $this->assertEquals('Kab. Cianjur', $excel->getWorksheet(1)->getCell(3, 2)->value);
    }
    
    public function testWriter()
    {
        $excel = new SimpleExcel();
        
        $sheet = new Worksheet();
        $sheet->insertRecord(array('ID', 'Nama', 'Kode Wilayah'));
        $sheet->insertRecord(array('1', 'Kab. Bogor', '1'));
        $excel->insertWorksheet($sheet);        
        $this->assertEquals("ID,Nama,\"Kode Wilayah\"\n1,\"Kab. Bogor\",1\n", $excel->toString('CSV'));        
        
        $excel->getWorksheet(1)->insertRecord(array('2', 'Kab. Cianjur', '1'));
        $this->assertEquals("ID,Nama,\"Kode Wilayah\"\n1,\"Kab. Bogor\",1\n2,\"Kab. Cianjur\",1\n", $excel->toString('CSV'));        
        $this->assertEquals("ID;Nama;\"Kode Wilayah\"\n1;\"Kab. Bogor\";1\n2;\"Kab. Cianjur\";1\n", $excel->toString('CSV', array('delimiter' => ';')));
    }
}
