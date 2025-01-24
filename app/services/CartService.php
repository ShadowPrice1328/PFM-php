<?php

namespace services;

class CartService
{
    public static function addToCart($id, $quantity): void {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'quantity' => $quantity
            ];
        }
    }

    public static function getCart() {
        return $_SESSION['cart'];
    }

    public static function removeFromCart($id): void {
        unset($_SESSION['cart'][$id]);
    }
}