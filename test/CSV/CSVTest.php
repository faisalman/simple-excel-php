<?php

use SimpleExcel\SimpleExcel;

require_once('src/SimpleExcel/SimpleExcel.php');

class CSVTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $excel = new SimpleExcel('CSV');
        $excel2 = new SimpleExcel();
        $excel2->constructParser('CSV');
        $this->assertEquals($excel->parser, $excel2->parser);
        return $excel;
    }

    /**
     * @depends testConstruct
     */
    public function testParser(SimpleExcel $excel)
    {
        $excel->parser->loadFile('test/CSV/test.csv');
        $this->assertEquals('ID', $excel->parser->getCell(1, 1));
        $this->assertEquals('Kab. Cianjur', $excel->parser->getCell(3, 2));
        $this->assertEquals(array('5', 'Comma, inside, double-quotes', '3'), $excel->parser->getRow(6));
        $this->assertEquals(array('Kode Wilayah', '1', '1', '1', '2', '3'), $excel->parser->getColumn(3));
    }
    
    /**
     * @depends testConstruct
     */
    public function testWriter(SimpleExcel $excel)
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

?>
