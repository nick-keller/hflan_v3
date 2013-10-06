<?php
namespace hflan\BlogBundle\Twig;

class TxtFormat extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('stripHTML', array($this, 'stripHtml'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('nl2br', array($this, 'nl2br'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('maxLength', array($this, 'maxLength')),
        );
    }

    public function stripHtml($txt, $length = 0)
    {
        $txt = preg_replace('#<.+>#U', '', trim($txt));

        if($length != 0 && strlen($txt) > $length && strpos($txt, ' ', $length) !== false)
            $txt = substr($txt, 0, strpos($txt, ' ', $length)).'...';

        return $txt;
    }

    public function nl2br($txt)
    {
        $txt = str_replace("<", '&lt;', trim($txt));
        $txt = str_replace("\r", '', $txt);
        $txt = preg_replace('#\n{2,}#', '</p><p>', $txt);
        $txt = str_replace("\n", '<br>', $txt);

        return "<p>$txt</p>";
    }

    public function maxLength($txt, $length)
    {
        if(strlen($txt) <= $length)
            return $txt;
        return substr($txt, 0, $length - 3).'...';
    }

    public function getName()
    {
        return 'txt_format';
    }
}