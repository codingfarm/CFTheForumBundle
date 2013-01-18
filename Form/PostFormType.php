<?php

namespace CF\TheForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PostFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('body','textarea',array('label'=>'post.body.label'));
    }

    public function getName()
    {
        return 'post';
    }

}