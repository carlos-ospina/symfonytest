<?php

namespace Blog\CoreBundle\Tests\Controller;

use Blog\ModelBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PostControllerTest
 */
class PostControllerTest extends WebTestCase
{
    /**
     * Tests post index
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');
        $this->assertCount(3, $crawler->filter('h2'), ' there shold be three displayed posts');

    }

    /**
     * Test show post
     */
    public function testShow()
    {
        $client = static::createClient();
        /** @var Post $post */
        $post = $client->getContainer()->get('doctrine')->getManager()->getRepository('ModelBundle:Post')->findFirst();

        $crawler = $client->request('GET', '/' . $post->getSlug());

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response is not succesful');

        $this->assertEquals($post->getTitle(), $crawler->filter('h1')->text(), 'invalid post title');

        $this->assertGreaterThanOrEqual(1, $crawler->filter('article.comment')->count(), 'ther should be at least one comment');

    }

    /**
     * Test create comment
     */
    public function testCreateComment()
    {

        $client = static::createClient();
        /** @var Post $post */
        $post = $client->getContainer()->get('doctrine')->getManager()->getRepository('ModelBundle:Post')->findFirst();

        $crawler = $client->request('GET', '/' . $post->getSlug());

        $buttonCrawlerNode = $crawler->selectButton('Send');

        $form = $buttonCrawlerNode->form(array(
            'blog_modelbundle_comment[authorName]' => 'A humble commenter',
            'blog_modelbundle_comment[body]' => ' Hi im commenting about symfony 2!!!',
        ));

        $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->isRedirect('/'.$post->getSlug()), 'there was no redirection after submiting the form'
        );

        $crawler = $client->followRedirect();

        $this->assertCount(
            1,
            $crawler->filter('html:contains("your comment was submited successfuly")'),
            'There was nor any confirmation message'
        );

    }

}
