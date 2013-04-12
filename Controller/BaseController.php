<?php

namespace CF\TheForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


abstract class BaseController extends Controller
{
    /**
     * @return \CF\TheForumBundle\Model\PostManagerInterface
     */
    public function getPostManager()
    {
        return $this->get('forum.post_manager');
    }

    /**
     * @return \CF\TheForumBundle\Model\TopicManagerInterface
     */
    public function getTopicManager()
    {
        return $this->get('forum.topic_manager');
    }

    /**
     * @return \CF\TheForumBundle\Model\CategoryManagerInterface
     */
    public function getCategoryManager()
    {
        return $this->get('forum.category_manager');
    }

    /**
     * @param $topicId
     * @return \CF\TheForumBundle\Model\TopicInterface
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function findTopicOr404($topicId, $withDeleted = false)
    {
        $topic = $this->getTopicManager()->findById($topicId);
        if (!$topic || $topic->isDeleted()) {
            throw new NotFoundHttpException(sprintf("The Topic with id(%s) not found", $topicId));
        }

        return $topic;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return parent::getUser();
    }

    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    public function getSecurityContext()
    {
        return $this->get('security.context');
    }

    /**
     * @return bool
     */
    public function isAuthentificated()
    {
        return $this->getSecurityContext()->isGranted('IS_AUTHENTICATED_FULLY');
    }

}