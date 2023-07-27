<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Products;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
//use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show(int $id, Request $request, EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker): Response
    {
//        $securityContext = $this->container->get('security.authorization_checker');
        $product = $entityManager->getRepository(Products::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        $error = null;
        $access = $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');

//        $access = $authorizationChecker->isGranted('IS_FULLY_AUTHENTICATED');
        if (!$access) {
            $error = 'Чтобы оставить отзыв, нужно авторизоваться или зарегистрироваться';
        } else {
            if ($request->isMethod('POST')
                && $request->request->get('name')
            ) {
                $comment = new Comment();
                //  $comment = $products->getComments();
                $comment
                    ->setName($request->request->get('name'))
                    ->setReview($request->request->get('review'))
                    ->setProducts($product)
                    ->setCreatedAt(new \DateTime());
                $entityManager->persist($comment);
                $entityManager->flush();
            }
        }
        if ($request->isMethod('POST')
            && $request->request->get('author')
        ) {
            $question = new Question();
            //  $comment = $products->getComments();
            $question
                ->setAuthor($request->request->get('author'))
                ->setContent($request->request->get('post'))
                ->setEmail($request->request->get('mail'))
                ->setProducts($product)
                ->setCreatedAt(new \DateTime());
            $entityManager->persist($question);
            $entityManager->flush();
        }

        $comments = $entityManager->getRepository(Comment::class)->findBy([
            'products' => $id,
        ]);
        $questions = $entityManager->getRepository(Question::class)->findBy([
            'products' => $id,
        ]);
        return $this->render('product/product.html.twig', [
            // 'controller_name' => 'ProductController',
            'product' => $product,
            'comments' => $comments,
            'questions' => $questions,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/product", name="create_product")
     */
    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        $product = new Products();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}
