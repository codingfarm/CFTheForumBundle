<?php

namespace CF\TheForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostFormType extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('body','textarea',array('label'=>'post.body.label'));
//        $builder->add("reply_post",'hidden');
    }

    public function getName()
    {
        return 'post';
    }

}