<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Data\Process;

use Database\Get\Data as mysqlConnect;
/**
 * Description of Results
 *
 * @author Jacob
 */
class Results
{
    public $resultObj;

    public $mysqlObj;

    private $nonWordsArray;


    /**
     *
     * @param mysqlConnect $mysqlObj
     * @param \Data\Process\Json $result
     */
    public function __construct(mysqlConnect $mysqlObj, Json $result)
    {
        $this->mysqlObj = $mysqlObj;
        $this->resultObj = $result;
        $this->getNonWords();
        $this->removeNonWords();
    }

    private function getNonWords()
    {
        $this->nonWordsArray = $this->mysqlObj->fetchNonWords();
    }
    private function removeNonWords()
    {
        foreach ($this->nonWordsArray as $result)
        {
            if(isset($this->resultObj->results[$result['word']]))
            {
                unset($this->resultObj->results[$result['word']]);
            }
        }
    }

}