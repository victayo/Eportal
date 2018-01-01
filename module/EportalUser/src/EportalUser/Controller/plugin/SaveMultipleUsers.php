<?php

namespace EportalUser\Controller\Plugin;

/**
 *
 * @author imaleo
 */
class SaveMultipleUsers extends SaveUserPlugin {

    protected $columnHeadings;
    public function save($users, $property) {
        $excel = \PHPExcel_IOFactory::load($users['tmp_name']);
        $this->beginTransaction();
        try {
            $worksheet = $excel->getActiveSheet();
            $this->process($worksheet, $property);
            $this->commit();
            $excel->disconnectWorksheets();
            unset($excel);
            return true;
        } catch (\Exception $exc) {
            $this->rollBack();
            return false;
        }
    }
    
    private function process($worksheet, $property) {
        $highestRow = $worksheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $user = $this->getUser($worksheet, $row);
            $property = $this->getProperty($worksheet, $property, $row);
            $this->saveHelper($user, $property);
        }
    }
    
    private function getColumnHeadings($worksheet) {
        if (!$this->columnHeadings) {
            $columnHeadings = [];
            $highestCol = $worksheet->getHighestColumn();
            $highestColIndex = \PHPExcel_Cell::columnIndexFromString($highestCol);
            for ($col = 0; $col <= $highestColIndex; $col++) {
                $columnHeadings[] = strtolower($worksheet->getCellByColumnAndRow($col, 1)->getValue());
            }
            $this->columnHeadings = $columnHeadings;
        }
        return $this->columnHeadings;
    }

    private function getColumnIndex($heading, $worksheet) {
       $headings = $this->getColumnHeadings($worksheet); 
       foreach ($headings as $key => $value){
           if($value == $heading){
               return $key;
           }
       }
       return null;
    }

    private function getUser($worksheet, $row) {
        $columnHeadings = $this->getColumnHeadings($worksheet);
        $user = $this->getController()->getEportalUserService()->getEntity();
        if ($this->inColumnHeading('date of birth', $columnHeadings)) {
            $col = $this->getColumnIndex('date of birth', $worksheet);
            $user->setDob($worksheet->getCellByColumnAndRow($col, $row)->getFormattedValue());
        }
        if($this->inColumnHeading('registration number', $columnHeadings)){
            $col = $this->getColumnIndex('registration number', $worksheet);
            $user->setUsername($worksheet->getCellByColumnAndRow($col, $row)->getValue());
        }
        if($this->inColumnHeading('gender', $columnHeadings)){
            $col = $this->getColumnIndex('gender', $worksheet);
            $user->setGender($worksheet->getCellByColumnAndRow($col, $row)->getValue());
        }
        if($this->inColumnHeading('first name', $columnHeadings)){
            $col = $this->getColumnIndex('first name', $worksheet);
            $user->setFirstName($worksheet->getCellByColumnAndRow($col, $row)->getValue());
        }
        if($this->inColumnHeading('last name', $columnHeadings)){
            $col = $this->getColumnIndex('last name', $worksheet);
//            $user->setOtherNames($worksheet->getCellByColumnAndRow($col, $row)->getValue());
            $user->setLastName($worksheet->getCellByColumnAndRow($col, $row)->getValue());
        }
        return $user;
    }

    private function getProperty($worksheet, $property, $row) {
        $columnHeadings = $this->getColumnHeadings($worksheet);
        if ($this->inColumnHeading('department', $columnHeadings)) {
            $col = $this->getColumnIndex('department', $worksheet);
            $property->setDepartment($worksheet->getCellByColumnAndRow($col, $row)->getValue());
        }
        if($this->inColumnHeading('class', $columnHeadings)){
            $col = $this->getColumnIndex('class', $worksheet);
            $property->setClass($worksheet->getCellByColumnAndRow($col, $row)->getValue());
        }
        if($this->inColumnHeading('section', $columnHeadings)){
            $col = $this->getColumnIndex('section', $worksheet);
            $property->setSection($worksheet->getCellByColumnAndRow($col, $row)->getValue());
        }
        return $property;
    }

    private function inColumnHeading($property, $columnHeadings){
        return in_array($property, $columnHeadings);
    }
}
