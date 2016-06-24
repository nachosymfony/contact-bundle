<?php

namespace nacholibre\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactUsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
            ])
            #->add('phone', 'text', [
            #    'label' => 'Phone',
            #    'required' => true,
            #    'mapped' => false,
            #    'constraints' => [
            #        new NotBlank(),
            #    ],
            #])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }
}
