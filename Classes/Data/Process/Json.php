<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Data\Process;

/**
 * Description of Json
 *
 * @author Jacob
 */
class Json
{
    public $results;
    protected $timelineObj;
    public function __construct($jsonObj)
    {
        $this->timelineObj = $jsonObj;
        $this->processResults();
    }
    protected function processResults()
    {
        $this->results = array();
        foreach ($this->timelineObj as $result)
        {
            //Found tweet
            if(isset($result->text))
            {
                $this->processTweet($result->text);
            }
           
        }
        arsort($this->results);
    }
    protected function processTweet($string)
    {
        $delimiter = " ";
        $array = explode($delimiter, $string);
        foreach ($array as $word)
        {
            //
            $lowerCase = strip_tags(strtolower($word));
            $content = preg_replace("/&#?[a-z0-9]+;/i","",$lowerCase);
            $cleanString = preg_replace('/[^a-z]+/i', '', $content);
            if(!$this->hasTags($lowerCase) && !$this->isUrl($lowerCase) && !empty($cleanString))
            {
                
                
                $this->results[$cleanString] =
                    (isset($this->results[$cleanString]))?$this->results[$cleanString] + 1 :  1;
            }
        }

    }
    protected function isUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            return FALSE;
        }
        return TRUE;

    }
    protected function hasTags($string)
    {
        $tag = substr($string, 0, 1);
        return ($tag == '#' || $tag == '@')? TRUE: FALSE;
    }
}