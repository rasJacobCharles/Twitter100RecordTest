<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Url\Request;

/**
 * Description of Init
 *
 * @author Jacob
 */
class Init extends urlAbstract
{
    public $url = "";

    /**
     *
     * @var object curl
     */
    public $chObject;

    protected function initUrl()
    {
        // create curl resource
        $this->chObject = curl_init();
        curl_setopt($this->chObject, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->chObject, CURLOPT_SSL_VERIFYPEER, 0);

       
          
    }

    protected function urlOptions(array $options)
    {
           
             
            if (curl_setopt_array($this->chObject, $options))
            {}
            else
            {
  
               throw new \Exception("curl_setopt option: Is not a vaild curl option value or resource", 1);
            }
        
    }
    protected function setHeaders($header)
    {
        curl_setopt($this->chObject, CURLOPT_HTTPHEADER, $header);
    }

    protected function execUrl()
    {
     $output = curl_exec($this->chObject);
       if (($error = curl_error($this->chObject)) !== '')
        {
            curl_close($this->chObject);

            throw new \Exception($error);
        }

        // close curl resource to free up system resources
        curl_close($this->chObject);
        return  $output;
    }
}