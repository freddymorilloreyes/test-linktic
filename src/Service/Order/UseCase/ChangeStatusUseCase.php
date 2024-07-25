<?php

namespace App\Service\Order\UseCase;

use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Repository\OrderRepository;

class ChangeStatusUseCase
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }

    public function handle(Order $order, OrderStatus $status): Order
    {
        switch ($status->value) {
            case OrderStatus::InProcess->value:
                $order->setInProcess();
                break;
            case OrderStatus::Completed->value:
                $order->setCompleted();
                break;
            case OrderStatus::Rejected->value:
                $order->setRejected();
                break;
        }

        $this->orderRepository->save($order, true);
        return $order;
    }
}