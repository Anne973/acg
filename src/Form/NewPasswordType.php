<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 07/01/2018
 * Time: 15:03
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewPasswordType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder


            ->add('password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'constraints' => array(
                        new NotBlank()
                    ),
                ]
            );

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(

        ));
    }
}