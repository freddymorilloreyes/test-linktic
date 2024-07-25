<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Repository\OrderRepository;
use App\Service\Order\UseCase\ChangeStatusUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_SELLER')]
#[Route('/seller/order', name: 'order_')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function show(Order $order): Response
    {
        return $this->render('order/details.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/change/status/{id}/{status}', name: 'change_status')]
    public function changeStatus(Order $order, OrderStatus $status, ChangeStatusUseCase $useCase): Response
    {
        $useCase->handle($order, $status);
        return $this->redirectToRoute('order_details', ['id' => $order->getId()]);
    }
}
