<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Url\Get;

/**
 * Description of Curl
 *
 * @author Jacob
 */
class Curl extends \Url\Request\Init
{
    protected $getOptions = array
        (
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT => 'Code Test cURL Request'
        );
    protected function getOptions()
    {
        $this->urlOptions($this->getOptions);
    }
}