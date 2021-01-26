<?php
/** Class qui permet implémenter les formulaires des durées des sessions de formation */

namespace App\Form;

use App\Entity\Duree;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DureeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datedebut', DateType::class, [
                'label' => false,
                'widget' => 'choice',
                'required' => false,
                'empty_data' => '',
                'format' => 'dd-MM-yyyy',
                'attr' =>['placeholder'=>'Votre date de début']
            ])

            ->add('datefin', DateType::class, [
                'label' => false,
                'widget' => 'choice',
                'required' => false,
                'empty_data' => '',
                'format' => 'dd-MM-yyyy',
                'attr' =>['placeholder'=>'Votre date de fin']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Duree::class,
        ]);
    }
}
