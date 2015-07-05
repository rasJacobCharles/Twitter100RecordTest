<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Database\Get;

/**
 * Description of Data
 *
 * @author Jacob
 */
class Data
{
    private $mysqliObj;

    public function __construct(\mysqli $pdo)
    {
        $this->mysqliObj = $pdo;
    }
   
    public function fetchNonWords()
    {
        $query = "SELECT word
           FROM grammatical
           ";
       return $words = $this->selectRecords($query);
    }

    private function returnResults($type, $query)
    {
       $result = $this->selectRecord($query);
       return (isset( $result[$type]))? $result[$type]: FALSE;
    }
    private function selectRecords($query)
    {
        $results = $this->mysqliObj->query($query, MYSQLI_USE_RESULT);
       
        $resultArray = array();
        
        // output data of each row
        while($row = $results->fetch_assoc()) {
            $resultArray[] = $row;
        }
        
        return $resultArray;
        
    }
    private function selectRecord($query)
    {
     $result = $this->mysqliObj->query($query);
     
        $resultArray = $result->fetch_assoc();
        
        return $resultArray;
    }
    private function close()
    {
        $this->mysqliObj->close();
    }
}