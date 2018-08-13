<?php

namespace TS\DataManagerBundle\ImportData;

class ImportData
{
    private $spreadsheet;

    public function __construct($spreadsheet)
    {
        $this->spreadsheet = $spreadsheet;
    }
    
    /**
    * Vérifie si le texte est un spam ou non
    *
    * @param string $path
    * @return arrayCollection
    */
    public function importData($path)
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
            $irradiation = $worksheet->getCellByColumnAndRow(10, $row)->getCalculatedValue();
            $importRaw = array('id' => $row, 'date' => $date, 'energy' => $energyInjected, 'irradiation' => $irradiation);
            $tableau[] = $importRaw;
        }

        return $tableau;
    }
}