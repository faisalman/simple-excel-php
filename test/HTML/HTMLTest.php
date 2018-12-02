<?php

use Faisalman\SimpleExcel\SimpleExcel;
use Faisalman\SimpleExcel\Spreadsheet\Cell;
use Faisalman\SimpleExcel\Spreadsheet\Worksheet;

//require_once('src/SimpleExcel/SimpleExcel.php');

class HTMLTest extends PHPUnit\Framework\TestCase
{
    public function testParser()
    {
        $excel = new SimpleExcel();
        $excel->loadFile('test/HTML/test.html');
        $this->assertEquals(array(new Cell('ID'), new Cell('Nama'), new Cell('Kode Wilayah')), $excel->getWorksheet(1)->getRecord(1));
        $this->assertEquals(array(new Cell('1'), new Cell('Kab. Bogor'), new Cell('1')), $excel->getWorksheet(1)->getRecord(2));
    }
    
    public function testWriter()
    {
        $excel = new SimpleExcel('HTML');
        $excel->insertWorksheet(new Worksheet);
        $excel->getWorksheet(1)->insertRecord(array('ID', 'Nama', 'Kode Wilayah'));
        $this->assertEquals('<table>
 <tr>
  <td>ID</td>
  <td>Nama</td>
  <td>Kode Wilayah</td>
 </tr>
</table>', $excel->toString('HTML'));
    }
}

?>
