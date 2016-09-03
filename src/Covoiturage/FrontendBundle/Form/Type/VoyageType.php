<?php
/**
 * 
 * User: wissem
 * Date: 04/11/2014
 * Time: 23:47
 * Email: wissemr@gmail.com
 */

namespace Covoiturage\FrontendBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VoyageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //TODO: add the rest of the form
       $builder
            ->add('horaire', 'datetime')
            ->add('prix', 'money')
            ->add('nbPlace', 'choice', array(
                   'choices'=> array( '1' =>'1',
                                       '2' =>'2',
                                       '3' =>'3',
                                       '4' =>'4',
               ),
               'multiple' => false,
            ))
            ->add('frequence', 'choice', array(
                    'choices' => array('semaine' =>'Jour de semaine',
                                        'weekend' =>'En week-end'
                                )
                 ,
                'multiple' => false,
            ))
            ->add('idArrive', 'entity',array(
                    'class'=>'CovoiturageFrontendBundle:Localite',
                    'required'=>true,
                    'multiple'=>false
           ))
           ->add('idDepart', 'entity',array(
           'class'=> 'CovoiturageFrontendBundle:Localite',
               'required'=>true,
               'multiple'=>false
           ))
            ->add('publish','submit')
           ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Covoiturage\\FrontendBundle\\Entity\\Voyage'
        ));
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "voyage";
    }

}