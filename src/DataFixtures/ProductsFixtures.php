<?php

namespace App\DataFixtures;


use App\Entity\Products;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ProductsFixtures extends Fixture implements FixtureGroupInterface
{
//    public $product;

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin
            ->setEmail('admin@example.com')
            ->setPassword('123456')
            ->setRoles(["ROLE_ADMIN"])
            ->setCustomer('Петров Петр Петрович')
            ->setCity('Муром')
            ->setAddress('Петра Великого ул.')
            ->setPhone('+7' . random_int(9000000000,9999999999))
        ;
        $manager->persist($admin);

        for ($i = 1; $i <= 20; ++$i) {
            $user = new User();
            $user
                ->setEmail('user-' . $i . '@ya.ru')
                ->setPassword('123456')
                ->setRoles(["ROLE_USER"])
                ->setCustomer('User ' . $i)
                ->setCity('City ' . $i)
                ->setAddress('address ' . $i)
                ->setPhone('+7' . random_int(9000000000,9999999999))
            ;
            $manager->persist($user);
        }

        for ($i = 1; $i <= 20; ++$i) {
            $product = new Products();
            $product
                ->setName('Product ' . $i)
                ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua')
                ->setPrice(mt_rand(10, 600))
                ->setSeller(mt_rand(1, 20))
            ;
            $manager->persist($product);

             for ($j = 0; $j <  1; $j++) {
                $this->addComment($manager, $product);
            }

        }
        $manager->flush();
    }

    public function addComment(ObjectManager $manager, $product): void
    {
        for ($i = 1; $i <= 10; ++$i) {
            $comment = new Comment();
            $comment
                ->setProducts($product)
                ->setName('user'.$i)
                ->setReview('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua')
                ->setCreatedAt(new \DateTime(sprintf('-%d days', rand(0, 100))));

            $manager->persist($comment);
        }
//        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}
