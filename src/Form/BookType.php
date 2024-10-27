<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Customer;
use App\Entity\LoanStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('authorID', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => 'Author',
            ]);


        if (!$options['is_new']) {
            $builder->add('customerID', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => 'name',
                'required' => false,
                'label' => 'Customer',
            ]);


            $builder->add('loanID', EntityType::class, [
                'class' => LoanStatus::class,
                'choice_label' => 'status',
                'choices' => $options['loan_statuses'],
                'label' => 'Loan Status',
                'required' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'is_new' => true,
            'loan_statuses' => [],
        ]);
    }
}
