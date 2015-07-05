<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Twitter\Data;

/**
 * Description of Timeline
 *
 * @author Jacob
 */
class Options
{
    /**
     * Twitter Screen Name
     * @var string
     */
    protected $screenName = "@Secretsales";
    /**
     * The number of twitter to return
     * @var type 
     */
    protected $count = 100;

    private $consumerKey = "NT4maJ0vF3Ly3cGQ0oPoA";

    private $consumerSecret= "4DhV73NV0asfeUpblXRnizYgFvC4FP9hOtJyWMTnI";

    private $accessToken = "199252208-OjgCAYfRWDmi9HWNm7W7s4PXJYUBiYAaQYkFhQmn";

    private $accessSecret = "iDTBxZeemQfalgrrqX6klDLsfsiuIASPa1tmc5biV2RaA";

    public function setScreenName($name)
    {
        $this->screenName =  "@".$this->removeAtSign($name);
    }

    public function setCount($count)
    {
      if($count < 100)
      {
          $this->count = intval($count);
      }
    }
    public function returnParam()
    {
        return  array(
        "screenName" => $this->screenName,
        "count" => $this->count,
        "consumerKey" => $this->consumerKey,
        "consumerSecret" => $this->consumerSecret,
        "accessToken" => $this->accessToken,
         "accessSecret" => $this->accessSecret
        );
    }

    private function removeAtSign($name)
    {
        return str_replace("@", "", $name);
    }
}