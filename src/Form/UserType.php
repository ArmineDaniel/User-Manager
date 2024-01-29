<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\Length(['max' => 255]),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\Email(),
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
                'constraints' => [
                    new Assert\Choice(['choices' => ['male', 'female']]),
                ],
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Select gender',
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\Date(),
                ],
            ])
            ->add('street', TextType::class, [
                'constraints' => [
                    new Assert\Length(['max' => 255]),
                ],
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new Assert\Length(['max' => 255]),
                ],
            ])
            ->add('zip', TextType::class, [
                'constraints' => [
                    new Assert\Regex(['pattern' => '/^\d{4}$/']),
                ],
            ]);
    }

}
