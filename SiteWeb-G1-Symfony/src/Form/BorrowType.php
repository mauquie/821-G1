<?php

namespace App\Form;

use App\Entity\Borrow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use \DateTime;

class BorrowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $quantity = $options['quantity'];
        $locationTime = $options['locationTime'];
        $choices=[];
        while ($quantity > 0){
            $choices[strval($quantity)] = $quantity;
            $quantity = $quantity -1;
        }
        
        $date=new \DateTime("now");
        $date = date_format($date, "d-m-Y");
        $newDate = date('d-m-Y',strtotime('+'.$locationTime.' days'));
        $array = [];
        $k = 1;
        
        while ($date <= $newDate){
            $array[strval($date)] = $date;
            $date = date('d-m-Y',strtotime('+'.$k.'days'));
            $k = $k +1;
        }
        
        
        $builder
            ->add('linker',ChoiceType::class,['choices'=>$array,'label'=>"Fin d'emprunt"])
            ->add('quantity',ChoiceType::class,[
                'choices' => $choices,
                'data' => 1
            ])            
        ;                        
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([ 'data_class' => Borrow::class ]);
        $resolver->setRequired(['quantity','locationTime']);
    }
}