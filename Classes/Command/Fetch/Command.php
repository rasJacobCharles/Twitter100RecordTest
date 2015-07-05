<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Command\Fetch;

/**
 * Description of command
 *
 * @author Jacob
 */
class Command
{
    private $longopts  = array(
    "name:",     // Screen Name
    "count:",    // Number of tweets to return
    );
    
    public $screenName;
    
    public $count;
    
    public function __construct()
    {
        
        $this->getOptions();
    }

    public function getOptions()
    {
        $shortopts = "";
        $options = getopt($shortopts, $this->longopts);
        if(is_array($options)){
            $this->getCommands($options);
        }
    }
    private function getCommands($options)
    {
        foreach ($options as $key => $value)
            {
                switch ($key)
                {
                    case "name":
                        $this->screenName = $value;
                        break;
                    case "count":
                        $this->count = intval($value);
                        break;
                }
            }
    }
}