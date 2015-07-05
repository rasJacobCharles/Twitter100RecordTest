<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Timeline
 *
 * @author Jacob
 */
namespace Url\Twitter;


use Url\Get\Curl as FetchUrl;
use Command\Set\TwitterCommand as Parameters;

class Timeline extends FetchUrl
{
    protected $parameterObject;

    public $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

    protected $timelineObj;

    private $consumerSecret;

    private $accessSecret;

    private $oauth;

    private $screenName;

    private $count;

    private $getfield;

    public function __construct(Parameters $timeObj)
    {
        $this->parameterObject = $timeObj;
        $this->getTimeline();
    }
    public function setGetfield($string)
    {
        $getfields = preg_replace('/^\?/', '', explode('&', $string));
        $params = array();

        foreach ($getfields as $field)
        {
            if ($field !== '')
            {
                list($key, $value) = explode('=', $field);
                $params[$key] = $value;
            }
        }

        $this->getfield = '?' . http_build_query($params);
    }
    public function getTimeline()
    {
        $this->getOauthArray();
        $this->getOAuthParam();
        $this->setGetfield("?count=$this->count&screen_name=$this->screenName");
        $this->getOauthFields();
        $this->createOauthSignature();
        $this->setCurlOptions();
        $this->timelineObj = $this->returnJsonObject($this->execUrl());
    }
    public function fetchTimeline()
    {
        return $this->timelineObj;
    }

    private function returnJsonObject($json)
    {
        return json_decode($json);
    }
    private function setCurlOptions()
    {
        $header =  array($this->buildAuthorizationHeader($this->oauth), 'Expect:');
        $options =  array(
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        );
        $this->initUrl();
        if ($this->getfield !== '')
        {
            $options[CURLOPT_URL] .= $this->getfield;
        }
        $this->urlOptions($options);
    }

    private function createOauthSignature()
    {
     $base_info = $this->buildBaseString($this->url, $this->oauth);
        $composite_key = rawurlencode($this->consumerSecret) . '&' . rawurlencode($this->accessSecret);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $this->oauth['oauth_signature'] = $oauth_signature;   
    }

    private function getOauthFields()
    {
        if (!is_null($this->getfield))
        {
            $getfields = str_replace('?', '', explode('&', $this->getfield));
            foreach ($getfields as $g)
            {

                $split = explode('=', $g);

                /** In case a null is passed through **/
                if (isset($split[1]))
                {
                    $this->oauth[$split[0]] = urldecode($split[1]);
                }
            }
        }
    }

    private function getOauthArray()
    {
        $this->oauth=  array(
            'oauth_consumer_key' => '',
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => '',
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );
    }
    private function getOAuthParam()
    {
        foreach ($this->parameterObject->twitterDataObject->returnParam() as $key => $value){
            switch ($key)
            {
                case "accessToken":
                    $this->oauth['oauth_token'] = $value;
                break;
                case "screenName":
                    $this->screenName = $value;
                break;
                case "count":
                    $this->count= $value;
                break;
                case "consumerKey":
                    $this->oauth['oauth_consumer_key'] = $value;
                break;
                case "consumerSecret":
                    $this->consumerSecret = $value;
                break;
                case "accessSecret":
                    $this->accessSecret = $value;
                break;
            }

        }
    }
    private function buildBaseString($baseURI, $params)
    {
        $return = array();
        ksort($params);

        foreach($params as $key => $value)
        {
            $return[] = rawurlencode($key) . '=' . rawurlencode($value);
        }

        return "GET" . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $return));
    }



    private function buildAuthorizationHeader(array $oauth)
    {
        $return = 'Authorization: OAuth ';
        $values = array();

        foreach($oauth as $key => $value)
        {
            if (in_array($key, array('oauth_consumer_key', 'oauth_nonce', 'oauth_signature',
                'oauth_signature_method', 'oauth_timestamp', 'oauth_token', 'oauth_version'))) {
                $values[] = "$key=\"" . rawurlencode($value) . "\"";
            }
        }

        $return .= implode(', ', $values);
        return $return;
    }
}