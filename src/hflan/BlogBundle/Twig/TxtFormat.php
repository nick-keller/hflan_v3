<?php
namespace hflan\BlogBundle\Twig;

class TxtFormat extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('stripHTML', array($this, 'stripHtml')),
        );
    }

    public function stripHtml($txt, $length = 0)
    {
        $txt = preg_replace('#<.+>#U', '', $txt);

        if($length != 0 && strlen($txt) > $length && strpos($txt, ' ', $length) !== false)
            $txt = substr($txt, 0, strpos($txt, ' ', $length)).'...';

        return $txt;
    }

    public function getName()
    {
        return 'txt_format';
    }
}