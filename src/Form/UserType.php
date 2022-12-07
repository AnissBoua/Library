<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Unique;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'nom',
                ],
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'prenom',
                ],
            ])
            ->add('tel', TelType::class, [
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'tel',
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'email',
                ],
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'password',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'form_btn primary_font',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
