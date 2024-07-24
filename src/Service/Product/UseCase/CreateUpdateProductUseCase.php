<?php

namespace App\Service\Product\UseCase;

use App\Repository\ProductRepository;
use App\Service\Product\ProductImageUpdater;
use Symfony\Component\Form\FormInterface;

readonly class CreateUpdateProductUseCase
{

    public function __construct(
        private ProductImageUpdater $productImageUpdater,
        private ProductRepository   $productRepository
    )
    {
    }

    public function handle(FormInterface $form): mixed
    {
        $product = $form->getData();
        $this->productImageUpdater->handle($product, $form['attachment']->getData());
        $this->productRepository->save($product, true);
        return $product;

    }
}