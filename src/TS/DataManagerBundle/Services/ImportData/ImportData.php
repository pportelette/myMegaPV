<?php

namespace TS\DataManagerBundle\Services\ImportData;

class ImportData
{
    private $spreadsheet;

    public function __construct($spreadsheet)
    {
        $this->spreadsheet = $spreadsheet;
    }
    
    public function importDataHW($path)
    {
        $readerXls  = $this->spreadsheet->createReader('Xls');
        $readerXls->setReadDataOnly(true);
        $spreadsheet = $readerXls->load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $tableau = [];
        for ($row = 3; $row <= $highestRow; ++$row) {
            $datestr = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $date = mktime(0,0,0,1,$datestr-1,1900);
            $energyInjected = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            $irradiation = $worksheet->getCellByColumnAndRow(10, $row)->getValue() * 277.77778;
            $importRow = array('id' => $row, 'date' => $date, 'energy' => $energyInjected, 'irradiation' => $irradiation);
            $tableau[] = $importRow;
        }

        return $tableau;
    }

    public function importDataMC($path)
    {
        $readerXls  = $this->spreadsheet->createReader('Xls');
        $readerXls->setReadDataOnly(true);
        $spreadsheet = $readerXls->load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $tableau = [];
        for ($row = 2; $row <= $highestRow; ++$row) {
            $datestr = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
            //$date = mktime(0,0,0,1,$datestr-1,1900);
            $energyInjected = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $irradiation = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            $importRow = array('id' => $row, 'date' => $datestr, 'energy' => $energyInjected, 'irradiation' => $irradiation);
            $tableau[] = $importRow;
        }

        return $tableau;
    }
}