<?php
namespace hflan\LanBundle\Services;


use Doctrine\ORM\EntityManager;
use hflan\LanBundle\Entity\ExtraFieldRepository;
use hflan\LanBundle\Entity\Player;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Translation\TranslatorInterface as Translator;

class ExtraFieldsFormFactory
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ExtraFieldRepository
     */
    private $extraFieldRep;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /** @var  Translator */
    private $translator;

    private $locale;

    public function __construct(EntityManager $entityManager, FormFactory $formFactory, Translator $translator)
    {
        $this->em = $entityManager;
        $this->extraFieldRep = $this->em->getRepository('hflanLanBundle:ExtraField');
        $this->formFactory = $formFactory;
        $this->translator = $translator;
        $this->locale = $this->translator->getLocale();
    }

    public function createFromPlayer(Player $player)
    {
        $playerData     = $player->getExtraFields();
        $defaultData    = array();
        $constraints    = array();
        $fields         = array();

        foreach($playerData as $id => $value)
        {
            $fields[$id]      = $this->extraFieldRep->findOneById($id);
            $defaultData[$id] = $value;
            $constraints[$id] = array( new NotBlank() );

            if($fields[$id]->getValidator() == '#.*#')
                $constraints[$id] = array();

            if($fields[$id]->getValidator() && strpos($fields[$id]->getValidator(), "\n") === false)
                $constraints[$id][] = new Regex(array( 'pattern' => $fields[$id]->getValidator() ));
        }

        $form = $this->formFactory->createBuilder(
            'form',
            $defaultData,
            array( 'constraints' => new Collection($constraints) )
        );

        foreach($playerData as $id => $value)
        {
            /*
             * if regex has multiple lines then we must render multiple radio inputs
             */
            if(strpos($fields[$id]->getValidator(), "\n") !== false){
                $choices = array();
                $type = 'radiobar'; // by default we'll use a radiobar for small choices like 'yes' or 'no'

                foreach(explode("\n", $fields[$id]->getValidator()) as $choice){
                    $choices[trim($choice)] = $this->trans($choice);

                    // if a choice has more than one space it means that we should render a regular radio input instead of our custom radiobar
                    if(substr_count($this->trans($choice), ' ') > 1)
                        $type = 'choice';
                }

                $form->add(
                    $id,
                    $type,
                    array(
                        'label' => $this->trans($fields[$id]->getName()),
                        'choices' => $choices,
                        'expanded' => true,
                        'attr' => array(
                            'class' => 'staked-radio',
                        )
                    )
                );
            }
            /*
             * else we can render a simple text field
             */
            else{
                $form->add(
                    $id,
                    'text',
                    array(
                        'label' => $this->trans($fields[$id]->getName()),
                        'required' => false,
                        'attr' => array(
                            'placeholder' => $this->trans($fields[$id]->getPlaceholder()),
                        ),
                    )
                );
            }
        }

        return $form->getForm();
    }

    /**
     * Parse strings which have this format "french text [english text]" based on the locale.
     * @param $string
     * @return string
     */
    private function trans($string)
    {
        $string = trim($string);

        if(preg_match('#^.+\[.+\]$#', $string)){
            if($this->locale == 'en')
                return trim(preg_replace('#^.+\[(.+)\]$#', '$1', $string));
            return trim(preg_replace('#^(.+)\[.+\]$#', '$1', $string));
        }

        return $string;
    }
}