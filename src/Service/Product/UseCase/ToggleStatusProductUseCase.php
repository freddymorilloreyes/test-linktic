<?php

namespace App\Service\Product\UseCase;

use App\Entity\Product;
use App\Repository\ProductRepository;

readonly class ToggleStatusProductUseCase
{

    public function __construct(
        private ProductRepository $productRepository
    )
    {
    }

    public function handle(Product $product): Product
    {
        $product->toggleStatus();
        $this->productRepository->save($product, true);
        return $product;
    }
}