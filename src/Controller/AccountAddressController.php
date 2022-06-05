<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Service\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/konto/address', name: 'app_account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    #[Route('/konto/neu-address', name: 'app_account_add_address')]
    public function add(Request $request, Cart $cart): Response
    {

        // creation of an address and init form

        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        /* If the customer is correctly connected to his account and the form is valid, the address is injected into
        the database, otherwise he is redirected to the page to the my addresses page.
        */

        if($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();

            if($cart ->get()) {
                return $this->redirectToRoute('app_order');

            } else {
                return $this->redirectToRoute('app_account_address');
            }
        }

        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/konto/edit_address/{id}', name: 'app_account_edit_address')]
    public function edit(Request $request, $id)
    {
        // Search an address according to the id and according to the user.

        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account_address');
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);


        // If both are valid then we modify the address

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_address');
        }

        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/konto/delete_address/{id}', name: 'app_account_delete_address')]
    public function delete($id)
    {
        /*Search an address according to the id and according to the user.
        If both are valid then we delete the address. */

        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_account_address');
    }


}
