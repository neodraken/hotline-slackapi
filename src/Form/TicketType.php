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
                'label' => 'Requester name'
            ])
            ->add('email', EmailType::class)
            ->add('summary')
            ->add('description')
            ->add('type', ChoiceType::class, [
                'label' => 'Ticket status',
                'choices'  => [
                    'Problem' => Ticket::TYPE_PROBLEM,
                    'Incident' => Ticket::TYPE_INCIDENT,
                    'Task' => Ticket::TYPE_TASK,
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
