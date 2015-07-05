<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Command\Set;

/**
 * Description of TwitterCommand
 *
 * @author Jacob
 */

use \Command\Fetch\Command as CommandOptions;
use \Twitter\Data\Options as TwitterOptions;

class TwitterCommand
{
    public $commandObject;

    public $twitterDataObject;

    public function __construct(CommandOptions $cObj, TwitterOptions $tObj)
    {
        $this->twitterDataObject = $tObj;
        $this->commandObject = $cObj;
        $this->setTwitterData();
    }
    private function setTwitterData()
    {
        if(is_string($this->commandObject->screenName))
        {
            $this->twitterDataObject->setScreenName($this->commandObject->screenName);
        }
        if(is_int($this->commandObject->count))
        {
            $this->twitterDataObject->setCount($this->commandObject->count);
        }
    }
}