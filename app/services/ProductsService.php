<?php

namespace services;

require_once __DIR__ . '/../dtos/ProductResponse.php';
require_once __DIR__ . '/../entities/Product.php';

use dtos\ProductExtensions;
use dtos\ProductResponse;
use entities\Product;
use interfaces\IProductsService;
use models\Decimal;
use models\Guid;

require_once __DIR__ . '/../interfaces/IProductsService.php';

class ProductsService implements IProductsService
{
    private static ?ProductsService $instance = null;
    private array $products;

    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }

        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = $this->seedData();
        }

        $this->products = $_SESSION['products'];
    }


    public static function getInstance(): ProductsService
    {
        if (self::$instance === null) {
            self::$instance = new ProductsService();
        }

        return self::$instance;
    }

    private function __clone() {}

    public function __wakeup() {}

    public function getProducts(): array
    {
        return array_map(function ($prod) {
            $product = new Product();

            $product->id = $prod->id;
            $product->name = $prod->name;
            $product->description = $prod->description;
            $product->price = $prod->price;
            $product->quantity = $prod->quantity;
            $product->image = $prod->image;

            return ProductExtensions::toProductResponse($product); // Use the existing method
        }, $this->products);
    }

    public function getProductById(string $id): ?Product
    {
//        echo $id . "<br>";
//        var_dump($this->products);

//        var_dump($this->products);
        foreach ($this->products as $product) {
            if ($product->id === $id) {
                return $product;
            }
        }

        return null;
    }


    private function seedData() : array
    {
        $product1 = new Product();
        $product1->id = Guid::createGUID();
        $product1->name = "Financial Planner";
        $product1->description = "A stylish paper planner with monthly and weekly sections for tracking expenses, setting savings goals, and building better financial habits.";
        $product1->price = new Decimal(20);
        $product1->quantity = 90;
        $product1->image = "/images/planner.jpg";

        $product2 = new Product();
        $product2->id = Guid::createGUID();
        $product2->name = "Budgeting Stickers & Highlighters Kit";
        $product2->description = "A set of colorful highlighters and stickers to label different spending categories in your planner or journal.";
        $product2->price = new Decimal(8);
        $product2->quantity = 150;
        $product2->image = "/images/stickers.jpeg";

        $product3 = new Product();
        $product3->id = Guid::createGUID();
        $product3->name = "Personal Finance 101 (Book)";
        $product3->description = "A practical guide to budgeting, cutting unnecessary expenses, and building a solid financial foundation. Great for beginners!";
        $product3->price = new Decimal(15);
        $product3->quantity = 75;
        $product3->image = "/images/book.jpg";

        $product4 = new Product();
        $product4->id = Guid::createGUID();
        $product4->name = "Mastering Your Money (Course)";
        $product4->description = "A video course with actionable lessons on managing personal finances, building a budget, and saving smarter. Includes downloadable materials.";
        $product4->price = new Decimal(50);
        $product4->quantity = 200;
        $product4->image = "/images/course.jpg";

        $product5 = new Product();
        $product5->id = Guid::createGUID();
        $product5->name = "Envelope Budgeting Starter Kit";
        $product5->description = "A physical kit with labeled cash envelopes, a budget tracker pad, and tips to use the cash envelope method for better control over spending.";
        $product5->price = new Decimal(25);
        $product5->quantity = 100;
        $product5->image = "/images/envelope.jpg";

        return [$product1, $product2, $product3, $product4, $product5];
    }
}