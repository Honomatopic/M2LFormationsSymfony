<?php
/** Class qui permet implémenter les formulaires des employés dans l'association */

namespace App\Form;

use App\Entity\Employe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, ['label' => false, 'attr' =>['placeholder'=>'Votre nom']])
        ->add('prenom', TextType::class, ['label' => false, 'attr' =>['placeholder'=>'Votre prénom']])
        ->add('email', EmailType::class, ['label' => false, 'attr' =>['placeholder'=>'Votre email']])
        ->add('password', PasswordType::class, ['label' => false, 'attr' =>['placeholder'=>'Votre mot de passe']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
