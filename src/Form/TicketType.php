<?php

namespace App\Form;

use App\Entity\Ticket;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Name requester'
            ])
            ->add('email', EmailType::class)
            ->add('summary')
            ->add('description')
            ->add('type', ChoiceType::class, [
                'label' => 'Type task',
                'choices'  => [
                    'Problem' => 0,
                    'Incident' => 1,
                    'Task' => 2,
                ],
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class
        ]);
    }
}
