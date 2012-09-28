<?php

namespace CF\TheForumBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ForumControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/forum/');

        $this->assertTrue($crawler->filter('h1:contains("Welcome to TheForum")')->count() > 0);


        $topics = $crawler->filter("h2.cf-topic-title a");

        $this->assertTrue($topics->count() > 0);

        $firstTopic = $topics->first();
        $firstTopicText = $firstTopic->text();
        $firstTopicCrawler = $client->click($firstTopic->link("get"));

        $this->assertEquals($firstTopicText, $firstTopicCrawler->filter(".cf-topic-title h2")->text());

        $postCrawler = $firstTopicCrawler->filter('li.cf-post');

        $replyLink = $postCrawler->filter("li.cf-reply a")->first()->link("get");
        $replyCrawler = $client->click($replyLink);

        $this->assertTrue($replyCrawler->filter("form")->count() == 0); // we are don't authenticated


        /*
        $this->assertTrue($replyCrawler->filter("form")->count() > 0);
        $sendButtonCrawlerNode = $replyCrawler->selectButton('post_save'); // #id кнопки для отправки
        $form = $sendButtonCrawlerNode->form(
            array(
                'post[reply_to]' => $postCrawler->filter('article')->first()->attr('data-post-id'),// article должен быть атрибут data-post-id
                'post[body]' => 'test post body'
            )
        );

        $formSendedCrawler = $client->submit($form);
        $this->assertTrue($formSendedCrawler->filter("li.cf-post:contains('test post body')")->count()==1);
        */
    }


}
