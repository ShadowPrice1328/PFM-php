<?php

namespace controllers;

require_once(__DIR__ . '/../services/ProductsService.php');
require_once(__DIR__ . '/../services/CartService.php');
require_once(__DIR__ . '/../viewmodels/ProductViewModel.php');

use DatabaseService;
use services\CartService;
use services\ProductsService;
use viewmodels\ProductViewModel;

class ShopController
{
    private DatabaseService $databaseService;
    private ProductsService $productsService;

    public function __construct(DatabaseService $databaseService, ProductsService $productsService) {
        $this->databaseService = $databaseService;
        $this->productsService = $productsService;

        $this->checkDatabaseConnection();
    }

    protected function checkDatabaseConnection(): void
    {
        list($isConnected, $errorMessage) = $this->databaseService->canConnect();

        if (!$isConnected) {
            // Redirect to home page if not connected
            header("Location: /");
            exit;
        }
    }

    public function index(): void
    {
        $viewModel = new ProductViewModel($this->productsService->getProducts());
        include_once(__DIR__ . '/../views/shop/index.php');
    }

    public function addToCart() : void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId']) && $_POST['quantity']) {
            CartService::addToCart($_POST['productId'], $_POST['quantity']);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Product added to cart successfully',
            'cart' => $_SESSION['cart']
        ]);

        exit;
    }

    public function cart() : void
    {
        $cart = CartService::getCart();
        $addedProducts = [];
        $totalPrice = 0;

        foreach ($cart as $product) {
            $foundProduct = $this->productsService->getProductById($product['id']);
            $addedProducts[] = $foundProduct;

            $totalPrice += $foundProduct->price->getValue() * $cart[$product['id']]['quantity'];
        }

        include_once(__DIR__ . '/../views/shop/cart.php');
    }

    public function updateCart() : void
    {
        CartService::updateProduct($_POST['productId'], $_POST['quantity']);

        echo json_encode([
            'status' => 'success',
            'message' => 'Product updates successfully',
            'cart' => $_SESSION['cart']
        ]);

        exit;
    }

    public function getCartInfo()
    {
        $cartInfo = [];

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product) {
                $foundProduct = $this->productsService->getProductById($product['id']);

                $cartInfo[$product['id']] = [
                    'name' => $foundProduct->name,
                    'price' => $foundProduct->price->getValue(),
                    'quantity' => $product['quantity'],
                    'total' => $foundProduct->price->getValue() * $product['quantity'],
                ];
            }
        }

        echo json_encode($cartInfo);
        exit;
    }

    public function removeFromCart() : void
    {
        CartService::removeProductFromCart($_POST['productId']);

        echo json_encode([
            'status' => 'success',
            'message' => 'Product has been removed successfully',
        ]);

        exit;
    }
}