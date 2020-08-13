<?php

namespace App\Form;

use App\Entity\Borrow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
        $builder
            ->add('borrow_end')
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