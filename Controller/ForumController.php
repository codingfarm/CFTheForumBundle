<?php

namespace CF\TheForumBundle\Controller;

use CF\TheForumBundle\Form\PostFormType;
use CF\TheForumBundle\Model\PostInterface;
use CF\TheForumBundle\Model\TopicInterface;
use CF\TheForumBundle\Form\PostDeleteFormType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use LogicException;
use Exception;
use DateTime;
use JMS\SecurityExtraBundle\Annotation\Secure;

class ForumController extends BaseController
{

    public function indexAction()
    {
        $request         = $this->getRequest();
        $categorySlug    = $request->get('category');
        $currentCategory = null;
        if ($categorySlug) {
            $currentCategory = $this->getCategoryManager()->findBySlug($categorySlug);
        }

        $topicsPager = $this->getTopicManager()->getTopicsPager($currentCategory ? $currentCategory->getSlug() : '', 20);
        $topicsPager->setCurrentPage($this->getRequest()->get('page', 1));

        return $this->render(
            'CFTheForumBundle:Forum:index.html.twig',
            array(
                "pager"             => $topicsPager,
                'current_category'  => $currentCategory
            )
        );
    }


    public function topicAction($topic_id)
    {
        $topic = $this->findTopicOr404($topic_id);

        /** @var $postForm Form */
        $postForm = $this->get('forum.post_form');

        $emptyPost = $this->getPostManager()->createPost();
        $cookies   = $this->getRequest()->cookies;
        $response  = new Response();
        $cookieKey = 'cf-post-' . $topic->getId();
        if ($cookies->has($cookieKey)) {
            $emptyPost->setBody($cookies->get($cookieKey));
            $response->headers->clearCookie($cookieKey, "/");
            $postForm->setData($emptyPost);
        }

        $isTreeMode = true;

        $talkersStat = $this->getPostManager()->fetchAuthorsStatFromPosts($this->getPostManager()->getTopicPosts($topic_id));

        $viewParams = array(
            'is_tree_mode'    => $isTreeMode,
            'topic'           => $topic,
            'post_form'       => $postForm->createView(),
            'post_form_clone' => $postForm->createView(),
            'talkers_stat'    => $talkersStat,
            'current_category'=> $topic->getCategory()
        );

        if ($isTreeMode) {
            $viewParams['tree'] = $this->getPostManager()->getTopicPostsAsTree($topic_id);
        } else {
            $viewParams['posts'] = $this->getPostManager()->getTopicPosts($topic_id);
        }

        $response->setContent(
            $this->renderView('CFTheForumBundle:Forum:topic.html.twig', $viewParams)
        );

        return $response;
    }

    public function categoriesNavAction()
    {
        $categories      = $this->getCategoryManager()->getList();
        $currentCategory = $this->getRequest()->attributes->get('current_category');

        //var_dump($this->getRequest());exit;
        return $this->render(
            'CFTheForumBundle:Forum:categoriesNav.html.twig',
            array(
                "categories"      => $categories,
                'current_category'=> $currentCategory
            )
        );
    }

    /**
     * @param $topic_id
     * @throws \LogicException
     * @Secure(roles="ROLE_USER")
     */
    public function createPostAction($topic_id)
    {
        $request = $this->getRequest();

        $topic = $this->findTopicOr404($topic_id);

        $postManager = $this->getPostManager();
        $post        = $postManager->createPost();

        $form = $this->get('forum.post_form');
        $form->setData($post);

        $replyPost = null;

        $replyPost = $this->fetchReplyToPost($topic);
        $post->setReplyPost($replyPost);

        if ($request->getMethod() === 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $post = $form->getData();

                $this->getTopicManager()->addPostToTopic($topic, $post, $this->getUser(), $request);

                return $this->redirect(
                    $this->generateUrl('forum_topic', array('topic_id' => $topic_id)) . '#post_' . $post->getId()
                );
            }
        }

        return $this->render(
            'CFTheForumBundle:Forum:postNew.html.twig',
            array(
                'form'          => $form->createView(),
                'reply_to'      => $replyPost,
                'topic'         => $topic,
                'post'          => $post
            )
        );
    }

    public function fetchReplyToPost(TopicInterface $topic)
    {
        $request     = $this->getRequest();
        $postManager = $this->getPostManager();
        if ($request->get('reply_to')) {
            /** @var $replyPost PostInterface */
            $replyPost = $postManager->findById($request->get('reply_to'));
            if ($replyPost->getTopic()->getId() != $topic->getId()) {
                throw new LogicException();
            }

            return $replyPost;
        }

        return null;
    }

    /**
     * Edit a post by a moderator or a post's owner
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Secure(roles="ROLE_USER")
     */
    public function postEditAction()
    {
        $request = $this->getRequest();
        $post_id = $request->get('id');

        $post = $categories = $this->getPostManager()->findById($post_id);
        if (!$this->get('forum.services.permissions')->isAllowEdit($post, $this->getUser())) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException;
        }

        $form = $this->createForm(new PostFormType(), $post);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $postManager = $this->getPostManager();
                $postManager->persist($form->getData(), true);

                return $this->redirect(
                    $this->generateUrl('forum_topic', array('topic_id' => $post->getTopic()->getId())) . "#post_" . $post_id
                );
            }
        }

        return $this->render(
            'CFTheForumBundle:Forum:postEdit.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function topicCreateAction(Request $request)
    {
        /** @var $form Form */
        $form = $this->get('forum.topic_form');
        /** @var $topic TopicInterface */
        $topic = $this->getTopicManager()->createTopic();

        if ($request->get('category')) {
            $category = $this->getCategoryManager()->findBySlug($request->get('category'));
            if ($category) {
                $topic->setCategory($category);
            }
        }

        $form->setData($topic);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $topic = $form->getData();
                $post  = $topic->getFirstPost();
                $this->getTopicManager()->saveNewTopic($topic, $post, $this->getUser(), $request);

                return $this->redirect($this->generateUrl('forum_topic', array('topic_id' => $topic->getId())));
            }
        }

        return $this->render(
            'CFTheForumBundle:Forum:topicEdit.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Secure(roles="ROLE_FORUM_MODERATOR")
     */
    public function postDeleteAction($id)
    {
        $request = $this->getRequest();

        $post = $this->getPostManager()->findById($id);

        if (!$post) {
            new NotFoundHttpException();
        }

        $form = $this->createForm(new PostDeleteFormType(), array('type' => 'soft'));

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $type = $data['type'];

                $topic = $post->getTopic();

                if ($type === 'hard') {
                    $post->setIsDeleted(true);
                } else {
                    $post->setIsBlocked(true);
                }

                $this->getPostManager()->persist($post);

                $redirectUrl = $this->generateUrl('forum_topic', array('topic_id' => $topic->getId())) . '#post_' . $id;

                if ($topic->getFirstPost()->getId() == $id && 'hard' == $type) {
                    $redirectUrl = $this->generateUrl('forum');
                }

                return $this->redirect($redirectUrl);
            }
        }

        return $this->render(
            'CFTheForumBundle:Forum:postDelete.html.twig',
            array(
                'form' => $form->createView(),
                'post' => $post
            )
        );
    }


    private function processTopicForm($form)
    {
    }

    private function processPostForm()
    {
    }
}
