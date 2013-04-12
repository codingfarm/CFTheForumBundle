<?php

namespace CF\TheForumBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PostDeleteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'type',
            'choice',
            array(
                'choices' => array('soft' => 'soft.delete.choice', 'hard' => 'hard.delete.choice'),
                'expanded' => true,
                'required'=>true,
            )
        );
    }

    public function getName()
    {
        return 'post_delete';
    }

}