<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\Product\UseCase\CreateUpdateProductUseCase;
use App\Service\Product\UseCase\ToggleStatusProductUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/product', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function show(Product $product): Response
    {
        return $this->render('product/details.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, CreateUpdateProductUseCase $useCase): Response
    {

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $useCase->handle($form);
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function update(Product $product, Request $request, CreateUpdateProductUseCase $useCase): Response
    {

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $useCase->handle($form);
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/change/status/{id}', name: 'change_status')]
    public function changeStatus(Product $product, Request $request, ToggleStatusProductUseCase $useCase): Response
    {
        $useCase->handle($product);
        return $this->redirectToRoute('product_list');
    }
}
