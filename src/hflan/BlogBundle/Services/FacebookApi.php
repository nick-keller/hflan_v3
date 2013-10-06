<?php
namespace hflan\BlogBundle\Services;


class FacebookApi
{
    public function call($parameters)
    {
        $curl = curl_init('https://graph.facebook.com/'.$parameters);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return json_decode(curl_exec($curl), true);
    }
}