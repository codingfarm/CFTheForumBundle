<?php

namespace CF\TheForumBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TopicFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array('label' => 'topic.name'));
        $builder->add('category', null, array('label' => 'topic.create.choise.category'));
        $builder->add('firstPost', $options['post_form'], array('data_class' => $options['post_class']));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'post_class' => '',
            'post_form' => '',
            'data_class' => ''
        );
    }


    public function getName()
    {
        return 'topic';
    }

}