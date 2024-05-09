<?php

namespace App\Application\Service;

use App\Domain\Repository\OrderRepositoryInterface;
use App\Domain\Repository\CartRepositoryInterface;
use App\Domain\Model\Order;
use App\Domain\Model\CartItem;
use App\Application\DTO\OrderData;
use DateTime;

class OrderService
{
    private $orderRepository;
    private $cartRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, CartRepositoryInterface $cartRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
    }

    public function placeOrder($userId, $paymentDetails): OrderData
    {
        $cart = $this->cartRepository->findByUserId($userId);
        if (!$cart || count($cart->getItems()) == 0) {
            throw new \Exception("Cart is empty or not found.");
        }

        $items = [];
        foreach ($cart->getItems() as $item) {
            $items[] = new CartItem($item->getProduct(), $item->getQuantity());
        }

        $total = $cart->getTotal();
        $date = new DateTime();
        $status = 'pending'; // Assuming the initial status is 'pending'

        // Optional: Integrate payment processing logic here
        if (!$this->processPayment($paymentDetails, $total)) {
            throw new \Exception("Payment failed.");
        }

        $order = new Order(null, $items, $total, $status, $date);
        $this->orderRepository->save($order);

        // Clear the cart after placing the order
        $this->cartRepository->remove($cart);

        return new OrderData($order->getId(), $items, $total, $date);
    }

    private function processPayment($paymentDetails, $amount)
    {
        // Implement payment logic here
        return true; // Simulating a successful payment
    }
}