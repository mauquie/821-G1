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
       
        $choices=[];
        while ($quantity > 0){
            $choices[strval($quantity)] = $quantity;
            $quantity = $quantity -1;
        }
        
        $date=new \DateTime("now");
        $date = date_format($date, "d-m-Y H:00");
        
        $builder
            ->add('borrow_end',null,array('data'=>DateTime::createFromFormat("d-m-Y H:00",$date)))
            ->add('quantity',ChoiceType::class,[
                'choices' => $choices,
                'data' => 1
            ])            
        ;                        
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([ 'data_class' => Borrow::class ]);
        $resolver->setRequired(['quantity']);
    }
}