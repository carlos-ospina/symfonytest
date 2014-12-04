<?php

namespace Blog\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AuthorControllerTest
 */
class AuthorControllerTest extends WebTestCase
{
    /**
     * Test Author CRUD
     */
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient(array(), array
            (
                'PHP_AUTH_USER' => 'admin',
                'PHP_AUTH_PW'   => 'admin'
            )
        );

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/author/');
        $this->assertTrue($client->getResponse()->isSuccessful(), "The response was not successful");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(
            array(
                'blog_modelbundle_author[name]' =>  'someone'
            )
        );

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(
            0,
            $crawler->filter('td:contains("someone")')->count(),
            'The new author is not showing up'
        );

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(
            array(
                'blog_modelbundle_author[name]'  => 'Another name',
            )
        );

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Another name"]')->count(), 'Missing element [value="Another name"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }


}
