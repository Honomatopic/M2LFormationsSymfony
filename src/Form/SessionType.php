<?php
/** Class essentielle permettant d'implémenter les formulaires des sessions de formation */

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Duree;
use App\Entity\Intervenant;
use App\Entity\Prestataire;
use App\Entity\Salle;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('formations', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => function (Formation $formation) {
                    return $formation->getId() . ' - ' . $formation->getIntitule();
                },
                'label' => false, 
                'attr' =>['placeholder'=>'La formation']])

            ->add('durees', EntityType::class, [
                'class' => Duree::class,
                'choice_label' => function (Duree $duree) {
                    return $duree->getId() . ' - Du '.$duree->getDatedebut()->format('d/m/Y'). ' au '. $duree->getDatefin()->format('d/m/Y');
                },
                'label' => false, 
                'attr' =>['placeholder'=>'La durée']])

            ->add('salles', EntityType::class, [
                'class' => Salle::class,
                'choice_label' => function (Salle $salle) {
                    return $salle->getId() . ' - ' . $salle->getNom();
                },
                'label' => false, 
                'attr' =>['placeholder'=>'La salle']])

            ->add('intervenants', EntityType::class, [
                'class' => Intervenant::class,
                'choice_label' => function (Intervenant $intervenant) {
                    return $intervenant->getId() . ' - '. $intervenant->getNom();
                },
                'label' => false, 
                'attr' =>['placeholder'=>'L\'intervenant']])

            ->add('prestataires', EntityType::class, [
                'class' => Prestataire::class,
                'choice_label' => function (Prestataire $prestataire) {
                    return $prestataire->getId() . ' - ' . $prestataire->getNom();
                },
                'label' => false, 
                'attr' =>['placeholder'=>'Le prestataire']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
