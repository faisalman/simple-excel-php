<?php

use SimpleExcel\SimpleExcel;
use SimpleExcel\Spreadsheet\Cell;

require_once('src/SimpleExcel/SimpleExcel.php');

class CSVTest extends PHPUnit_Framework_TestCase
{
    public function testParser()
    {
        $excel = new SimpleExcel();
        $excel->loadFile('test/CSV/test.csv', 'CSV');
        
        $this->assertEquals('ID', $excel->getWorksheet(1)->getCell(1, 1)->value);
        $this->assertEquals('Kab. Cianjur', $excel->getWorksheet(1)->getCell(3, 2)->value);
        
        $row6 = array(new Cell('5'), new Cell('Comma, inside, double-quotes'), new Cell('3'));
        $this->assertEquals($row6, $excel->getWorksheet(1)->getRow(6));
        
        $col3 = array(new Cell('Kode Wilayah'), new Cell('1'), new Cell('1'), new Cell('1'), new Cell('2'), new Cell('3'));
        $this->assertEquals($col3, $excel->getWorksheet(1)->getColumn(3));
        
        $excel = new SimpleExcel();
        $excel->loadFile('test/CSV/test2.csv', 'CSV', array('delimiter' => ';'));
        
        $this->assertEquals('ID', $excel->getWorksheet(1)->getCell(1, 1)->value);
        $this->assertEquals('Kab. Cianjur', $excel->getWorksheet(1)->getCell(3, 2)->value);
    }
    
    public function testWriter()
    {
        $excel->writer->setData(
            array(
                array('ID', 'Nama', 'Kode Wilayah'),
                array('1', 'Kab. Bogor', '1')
            )
        );
        $this->assertEquals("ID,Nama,\"Kode Wilayah\"\n1,\"Kab. Bogor\",1\n", $excel->writer->saveString());        
        $excel->writer->addRow(array('2', 'Kab. Cianjur', '1'));
        $this->assertEquals("ID,Nama,\"Kode Wilayah\"\n1,\"Kab. Bogor\",1\n2,\"Kab. Cianjur\",1\n", $excel->writer->saveString());
    }
}
