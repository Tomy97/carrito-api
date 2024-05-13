<?php

namespace App\Interfaces\Controller;

use App\Application\Service\ProductService;
use App\Domain\Model\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    private ProductService $productService;

    private EntityManagerInterface $entityManager;

    public function __construct(ProductService $productService, EntityManagerInterface $entityManager)
    {
        $this->productService = $productService;
        $this->entityManager = $entityManager;
    }

    #[Route('/products', name: 'app_products')]
    public function productList(): Response
    {
        $products = $this->productService->listProducts();
        return new JsonResponse($products);
    }

    /**
     * @Route('/products/{id}', methods={"DELETE"})
     */
    public function deleteProduct(int $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            return new JsonResponse(['error' => 'Producto no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Product deleted'], Response::HTTP_OK);
    }

    /**
     * @Route('/products', methods={"POST"})
     */

    public function createProduct(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            if ($file) {
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try {
                    $file->move($this->getParameter('images_directory'), $filename);
                } catch (FileException $e) {
                    return new JsonResponse(['error' => 'Error uploading file'], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
                $product->setImageFilename($filename);
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return new JsonResponse(['status' => 'Product created'], Response::HTTP_CREATED);
        }

        return new JsonResponse(['error' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
    }

    private function generateUniqueFileName(): string
    {
        return md5(uniqid());
    }
}
