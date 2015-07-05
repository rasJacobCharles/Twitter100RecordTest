<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Display;

use Data\Process\Results as Results;
/**
 * Description of Output
 *
 * @author Jacob
 */
class Output
{
    private $resultObj;

    public function __construct(Results $result)
    {
        $this->resultObj = $result;
        $this->display();
    }
    public function display()
    {
        echo PHP_EOL;
        foreach ($this->resultObj->resultObj->results as $word => $count)
        {
            echo "$word.$count".PHP_EOL;
        }

    }
}