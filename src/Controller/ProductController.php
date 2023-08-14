<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\HistoryView;
use App\Entity\Products;
use App\Entity\Question;
use App\Entity\User;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Bridge\Doctrine\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
//use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;
use function Zenstruck\Foundry\faker;

/**
 * @property $entityManager
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show(int $id, Request $request, PaginatorInterface $paginator, EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker, CartService $cart): Response
    {
        $sale = '10';
        $offset = 3;

//        $securityContext = $this->container->get('security.authorization_checker');
        $product = $entityManager->getRepository(Products::class)->find($id);
//        dump($cart->getQuantity($id));
//        if ($amount = $cart->getQuantity($id))
//        if ($request->isMethod('POST')) {
//            $amount = $request->request->get('amount');
//        }
        $error = null;
        $access = $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');

        if ($access) {
            $customer = $request->getSession()->get(
                Security::LAST_USERNAME
            );

            $userDetails = $entityManager->getRepository(User::class)->findOneBy([
               'email' => $customer,
            ]);

            $view = new HistoryView();
            $view
                ->setUser($userDetails)
                ->addProduct($product)
                ->setCreatedAt(new \DateTime('now'));
                $entityManager->persist($view);
                $entityManager->flush();
        }

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
                    ->setProducts($product)
                    ->setName($request->request->get('name'))
                    ->setReview($request->request->get('review'))
                    ->setEmail($request->request->get('email'))
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
                ->setProducts($product)
                ->setAuthor($request->request->get('author'))
                ->setContent($request->request->get('post'))
                ->setEmail($request->request->get('mail'))
                ->setCreatedAt(new \DateTime());
            $entityManager->persist($question);
            $entityManager->flush();
        }

        $comments = $entityManager->getRepository(Comment::class)->findBy([
            'products' => $id],
            ['createdAt'=> 'DESC'
        ]);
        $count_comments = count($comments);

        $questions = $entityManager->getRepository(Question::class)->findBy([
            'products' => $id,
        ]);
        $count_questions = count($questions);

        $pagination = $paginator->paginate(
            $comments,
            $request->query->getInt('page', 1),
            $offset
        );

        $questions_pagination = $paginator->paginate(
            $questions,
            $request->query->getInt('page', 1),
            $offset
        );

        return $this->render('product/product.html.twig', [
            // 'controller_name' => 'ProductController',
            'product' => $product,
            'quantity' => $cart->getQuantity($id),
            'comments' => $pagination,
            'questions' => $questions,
            'sale' => $sale,
            'error' => $error,
            'count_comments'=>$count_comments,
            'count_questions'=>$count_questions,
        ]);
    }

    /**
     * @Route("/product", name="create_product")
     */
    public function createProduct(EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $product = new Products();
        $maxId = $doctrine->getRepository(Products::class)->getMaxId();
        $newId = $maxId[0][1] + 1;
//        dump(strval($newId));
        $product->setName(name: 'Product ' . $newId);
        $product->setPrice(mt_rand(10, 600));
        $product->setSeller(mt_rand(1, 20));
        $product->setDescription(faker()->text(mt_rand(20, 50)));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

//        return new Response('Saved new product with id '.$product->getId());
        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
        ]);
    }

    #[Route('/product/edit/{id}', name: 'product_edit')]
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Products::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
        ]);
    }

    #[Route('/product/buy/{id}', name: 'product_buy')]
    public function addToCart(Request $request, int $id)
    {
        $amount = null;
        if ($request->isMethod('POST')
            && $request->request->get('quantity')
        ) {
            $amount = $request->request->get('quantity');
        }
        dd($amount, $id);
        return $this->redirectToRoute('app_cart_add', [
            'id' => $id,
        ]);
        }
}
