<?php
namespace hflan\LanBundle\Twig;

use Symfony\Component\Translation\TranslatorInterface as Translator;

class DateExtension extends \Twig_Extension
{
    /** @var  Translator */
    private $translator;

    private $locale;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
        $this->locale = $this->translator->getLocale();
    }

    public function getFilters()
    {
        return array(
            'countdown' => new \Twig_Filter_Method($this, 'countdown'),
            'simpleDate' => new \Twig_Filter_Method($this, 'simpleDate'),
        );
    }

    public function getFunctions()
    {
        return array(
            'weekend' => new \Twig_Function_Method($this, 'weekend'),
            'dateRange' => new \Twig_Function_Method($this, 'dateRange'),
        );
    }

    public function countdown(\DateTime $date = null)
    {
        if($date == null) return '';

        $now = new \DateTime();
        $nowMidnight = new \DateTime();
        $dateMidnight = new \DateTime($date->format("Y-m-d\TH:i:sP"));

        $dateMidnight->setTime(0,0);
        $nowMidnight->setTime(0,0);

        $diff = $date->diff($now);
        $diffMidnight = $dateMidnight->diff($nowMidnight);

        $time = $diff->invert ? 'future' : 'past';

        if($diffMidnight->m)
        {
            if($diffMidnight->d < 4)
                return $this->trans("date.Xmonth.$time", array('%x%'=> $diffMidnight->m));
            elseif($diffMidnight->d >15)
                return $this->trans("date.Xmonth.lessThan.$time", array('%x%'=> $diffMidnight->m+1));
            else
                return $this->trans("date.Xmonth.moreThan.$time", array('%x%'=> $diffMidnight->m));
        }
        else if($diffMidnight->d >= 14)
        {
            if($diffMidnight->d%7 == 0)
                return $this->trans("date.Xweek.$time", array('%x%'=> $diffMidnight->d/7));
            else
                return $this->trans("date.Xweek.lessThan.$time", array('%x%'=> ceil($diffMidnight->d/7)));
        }
        else if($diffMidnight->d >= 7)
            return $this->trans("date.Xday.$time", array('%x%'=> $diffMidnight->d));
        else if($diffMidnight->d >= 2)
            return $this->trans("date.dayAt.$time", array('%day%'=> $this->trans("date.day.".$date->format("N")), "%at%"=>$date->format("H:i")));
        elseif($diffMidnight->d == 1)
            return $this->trans("date.tomorrow.$time", array("%at%"=>$date->format("H:i")));
        elseif($diff->h >= 1)
        {
            if($diff->i < 10)
                return $this->trans("date.Xhour.$time", array('%x%'=> $diff->h));
            elseif($diff->i >30)
                return $this->trans("date.Xhour.lessThan.$time", array('%x%'=> $diff->h+1));
            else
                return $this->trans("date.Xhour.moreThan.$time", array('%x%'=> $diff->h));
        }
        else if($diff->i)
            return $this->trans("date.Xmin.$time", array('%x%'=> $diff->i));
        else
            return $this->trans("date.Xsec.$time", array('%x%'=> $diff->s));
    }

    public function simpleDate(\DateTime $date, $separator = '/')
    {
        if($this->locale == 'en')
            return $date->format('m'.$separator.'d'.$separator.'Y');

        return $date->format('d'.$separator.'m'.$separator.'Y');
    }

    public function weekend(\DateTime $from, \DateTime $to)
    {
        if($from->format('m') == $to->format('m')){
            return $this->trans("date.weekend.sameMonth", array(
                '%from%'     => $from->format('d'),
                '%to%'       => $to->format('d'),
                '%fromTime%' => $from->format('H\hi'),
                '%endTime%'  => $to->format('H\hi'),
                '%month%'    => $this->trans('date.month.'.$from->format('n')),
            ));
        }

        return $this->trans("date.weekend.differentMonth", array(
            '%from%'      => $from->format('d'),
            '%to%'        => $to->format('d'),
            '%fromTime%'  => $from->format('H\hi'),
            '%endTime%'   => $to->format('H\hi'),
            '%fromMonth%' => $this->trans('date.month.'.$from->format('n')),
            '%toMonth%'   => $this->trans('date.month.'.$to->format('n')),
        ));
    }

    public function dateRange(\DateTime $from, \DateTime $to)
    {
        if($from->format('m') == $to->format('m')){
            return $this->trans("date.range.sameMonth", array(
                '%from%'     => $from->format('d'),
                '%to%'       => $to->format('d'),
                '%fromTime%' => $from->format('H\hi'),
                '%endTime%'  => $to->format('H\hi'),
                '%month%'    => $this->trans('date.month.'.$from->format('n')),
            ));
        }

        return $this->trans("date.range.differentMonth", array(
            '%from%'      => $from->format('d'),
            '%to%'        => $to->format('d'),
            '%fromMonth%' => $this->trans('date.month.'.$from->format('n')),
            '%fromTime%'  => $from->format('H\hi'),
            '%endTime%'   => $to->format('H\hi'),
            '%toMonth%'   => $this->trans('date.month.'.$to->format('n')),
        ));
    }
    
    protected function trans($key, array $params = array())
    {
        return $this->translator->trans($key, $params, 'dates');
    }

    public function getName()
    {
        return 'date_extension';
    }
}