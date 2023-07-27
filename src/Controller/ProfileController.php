<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $customer = $request->getSession()->get(
            Security::LAST_USERNAME
        );
        $repository = $em->getRepository(User::class);
        $userDetails = $repository->findOneBy(['email' => $customer]);
        if (!isset($result)) {
            $result = null;
        }
        if ($request->isMethod('POST')) {
            $userDetails
                ->setEmail($request->request->get('mail'))
                ->setPhone($request->request->get('phone'))
                ->setPassword($request->request->get('password'))
                ->setRoles(['ROLE_USER'])
                ->setCustomer($request->request->get('name'))
                ->setCity('city')
                ->setAddress('address');

            $em->flush();
            $result = 'success';
        }

        $repository = $em->getRepository(User::class);
        $userDetails = $repository->findOneBy(['email' => $customer]);

        return $this->render('profile/profile.html.twig', [
           // 'controller_name' => 'ProfileController',
            'userDetails' => $userDetails,
            'success' => $result,
        ]);
    }
}
