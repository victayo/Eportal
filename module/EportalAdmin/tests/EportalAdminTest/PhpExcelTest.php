<?php

namespace EportalAdminTest;
//use PHPExcel;
/**
 *
 * @author imaleo
 */
class PhpExcelTest extends \PHPUnit_Framework_TestCase{
    protected $reader;
    protected $worksheet;
    protected $excel;
    public function setUp(){
        parent::setUp();
//        $ex = new \PHPExcel();
//        $this->reader = \PHPExcel_IOFactory::createReader('Excel2007');
//        $this->reader->setReadDataOnly(true);
        
    }

    public function testCanReadFile(){
//        $this->excel = $this->reader->load('C:\xampp\htdocs\Eportal\module\EportalAdmin\tests\data\book1.xlsx');
        $this->excel = \PHPExcel_IOFactory::load('C:\xampp\htdocs\Eportal\module\EportalAdmin\tests\data\book1.xlsx');
        $this->worksheet = $this->excel->getActiveSheet();
        $highestRow = $this->worksheet->getHighestRow();
        $highestCol = $this->worksheet->getHighestColumn();
        $highestColIndex = \PHPExcel_Cell::columnIndexFromString($highestCol);
        $data = [];
        for($row = 1; $row <= $highestRow; $row++){
            $str = "";
            for($col = 0; $col <= $highestColIndex; $col++){
                $val = $this->worksheet->getCellByColumnAndRow($col, $row)->getFormattedValue()."\t";
                $str.= $val;
            }
            $str.=PHP_EOL;
            $data[] = $str;
        }
        foreach($data as $dat){
            echo $dat.PHP_EOL;
        }
    }
}
