<?php

namespace Phuong\Bundle\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text')
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('firstname')
            ->add('lastname')
            ->add('displayname')
            ->add('birthday')
            ->add('gender', 'choice', [
                // Shows "Male" to the user, returns "nam" when selected
                'choices' => [
                    'Male' => 'nam',
                    'Female' => 'nu'
                ],
                'choices_as_values' => true,
                // 'choice_label' => function ($value, $key, $index) {
                //     // if ($value == true) {
                //     //     return 'Definitely!';
                //     // }
                //     //return strtoupper($key);

                //     // or if you want to translate some key
                //     return 'form.choice.'.$key;
                // },
                'choice_attr' => function($val, $key, $index) {
                    // adds a class like attending_yes, attending_no, etc
                    return ['class' => 'attending_'.strtolower($key)];
                },
                'placeholder' => 'Choose an option',
                'required' => false
                // 'group_by' => function($category, $key, $index) {
                //     // randomly assign things into 2 groups
                //     return rand(0, 1) == 1 ? 'Group A' : 'Group B'
                // },
                // 'preferred_choices' => function($category, $key, $index) {
                //     return $category->getName() == 'Cat2' || $category->getName() == 'Cat3';
                // },
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Phuong\Bundle\DemoBundle\Entity\Login'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'phuong_bundle_demobundle_login';
    }
}
