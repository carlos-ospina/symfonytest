<?php


namespace Blog\ModelBundle\DataFixtures\ORM;

use Blog\ModelBundle\Entity\Author;
use Blog\ModelBundle\Entity\Post;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * Fixture for the Posts Entity
 */
class Posts extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 15;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $p1 = new Post();
        $p1->setTitle('Lorem Ipsum Dolor Sit Amet');
        $p1->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fringilla arcu mauris, in pellentesque magna facilisis in. Nulla nunc augue, sodales eget nulla eget, mattis volutpat diam. Pellentesque ipsum mi, aliquet feugiat pretium non, pulvinar quis metus. Integer suscipit magna lacus, a tempus massa interdum vitae. Suspendisse eu laoreet mi. Nulla libero elit, varius luctus magna quis, porta ornare nibh. Proin quis fermentum tellus. Donec in ligula at ipsum bibendum vestibulum in in sapien.');
        $p1->setAuthor($this->getAuthor($manager, 'David'));

        $p2 = new Post();
        $p2->setTitle('Interdum et malesuada fames ac ante ipsum primis in faucibus.');
        $p2->setBody('Proin leo metus, mollis quis fringilla eget, posuere at lectus. Nam convallis velit est, nec gravida tortor dignissim nec. Aenean consectetur imperdiet sapien, eu feugiat felis sodales eget. Proin dapibus fringilla sodales. In hac habitasse platea dictumst. Cras non nulla id leo auctor tempor id eget ligula. Praesent tempor in enim eget posuere. Phasellus viverra porta lacus, accumsan bibendum neque lobortis tincidunt.');
        $p2->setAuthor($this->getAuthor($manager, 'Eddie'));

        $p3 = new Post();
        $p3->setTitle('Cras tristique vitae justo vel facilisis.');
        $p3->setBody('Pellentesque vulputate lacus ac sapien facilisis blandit. Aenean vulputate elit arcu, vel auctor lectus facilisis et. Nullam ante risus, tincidunt convallis tortor at, convallis feugiat dui. Donec sodales porta vestibulum. Phasellus egestas egestas dui, vel facilisis justo sollicitudin sit amet. Maecenas justo urna, fringilla in elementum vitae, molestie vitae mi. Ut vel nunc non nisi porttitor luctus a iaculis enim. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ligula sem, suscipit nec sem non, consequat fermentum metus. Proin posuere sollicitudin lacus, eget tristique erat adipiscing et. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id leo feugiat, lobortis leo nec, elementum dui. Nulla vitae euismod dui, a posuere ante.');
        $p3->setAuthor($this->getAuthor($manager, 'Eddie'));

        $manager->persist($p1);
        $manager->persist($p2);
        $manager->persist($p3);

        $manager->flush();
    }

    /**
     * Get an Author
     *
     * @param ObjectManager $manager
     * @param string        $name
     *
     * @return Author
     */
    private function getAuthor(ObjectManager $manager, $name)
    {
        return  $manager->getRepository('ModelBundle:Author')->findOneBy(
            array(
                'name'=>$name
            )
        );
    }
}




