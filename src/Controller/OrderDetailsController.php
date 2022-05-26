<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderDetailsType;
use App\Repository\OrderDetailsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order/details')]
class OrderDetailsController extends AbstractController
{
    #[Route('/', name: 'app_order_details_index', methods: ['GET'])]
    public function index(OrderDetailsRepository $orderDetailsRepository): Response
    {
        return $this->render('order_details/index.html.twig', [
            'order_details' => $orderDetailsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_order_details_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrderDetailsRepository $orderDetailsRepository): Response
    {
        $orderDetail = new OrderDetails();
        $form = $this->createForm(OrderDetailsType::class, $orderDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderDetailsRepository->add($orderDetail, true);

            return $this->redirectToRoute('app_order_details_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order_details/new.html.twig', [
            'order_detail' => $orderDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_details_show', methods: ['GET'])]
    public function show(OrderDetails $orderDetail, ManagerRegistry $doctrine, int $id): Response
    {
        $order = $doctrine->getRepository(Order::class)->find($id);
        $orderDetail = $order->getProducts();
        return $this->render('order_details/show.html.twig', [
            'order_detail' => $orderDetail,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_details_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OrderDetails $orderDetail, OrderDetailsRepository $orderDetailsRepository): Response
    {
        $form = $this->createForm(OrderDetailsType::class, $orderDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderDetailsRepository->add($orderDetail, true);

            return $this->redirectToRoute('app_order_details_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order_details/edit.html.twig', [
            'order_detail' => $orderDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_details_delete', methods: ['POST'])]
    public function delete(Request $request, OrderDetails $orderDetail, OrderDetailsRepository $orderDetailsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderDetail->getId(), $request->request->get('_token'))) {
            $orderDetailsRepository->remove($orderDetail, true);
        }

        return $this->redirectToRoute('app_order_details_index', [], Response::HTTP_SEE_OTHER);
    }
}
