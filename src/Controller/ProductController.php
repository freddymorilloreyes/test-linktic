<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function show(Product $product): Response
    {

        return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    #[Route('/new', name: 'create_')]
    public function createProduct(EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $errors = $validator->validate($product);

        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        $entityManager->persist($product);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function update(Product $product, ProductRepository $repository): Response
    {

        $product->setName('New product name!');
        $repository->save($product);

        return $this->redirectToRoute('product_details', [
            'id' => $product->getId()
        ]);
    }
}
