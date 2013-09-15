<?php
namespace hflan\LanBundle\Services;


use Doctrine\ORM\EntityManager;
use hflan\LanBundle\Entity\ExtraFieldRepository;
use hflan\LanBundle\Entity\Player;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Collection;

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

    public function __construct(EntityManager $entityManager, FormFactory $formFactory)
    {
        $this->em = $entityManager;
        $this->extraFieldRep = $this->em->getRepository('hflanLanBundle:ExtraField');
        $this->formFactory = $formFactory;
    }

    public function createFromPlayer(Player $player)
    {
        $playerData     = $player->getExtraFields();
        $defaultData    = array();
        $constraints    = array();
        $fields         = array();

        foreach($playerData as $id => $value)
        {
            $fields[$id] = $this->extraFieldRep->findOneById($id);
            $defaultData[$id] = $value;
            $constraints[$id] = new Regex(array( 'pattern' => $fields[$id]->getValidator() ));
        }

        $form = $this->formFactory->createBuilder(
            'form',
            $defaultData,
            array( 'constraints' => new Collection($constraints) )
        );

        foreach($playerData as $id => $value)
        {
            $form->add(
                $id,
                'text',
                array(
                    'label' => $fields[$id]->getName(),
                    'required' => false,
                    'attr' => array(
                        'placeholder' => $fields[$id]->getPlaceholder(),
                    ),
                )
            );
        }

        return $form->getForm();
    }
}