<?php

namespace App\Interfaces\Controller;

use App\Application\Service\FileUploader;
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

    /**
     * @Route("/products", name="create_product", methods={"POST"})
     */
    public function createProduct(Request $request): JsonResponse
    {
        $product = new Product();

        $name = $request->request->get('name');
        $description = $request->request->get('description');
        // Añade un var_dump o log para ver los valores recibidos:
        var_dump($name, $description);

        $product->setName($request->request->get('name'));
        $product->setDescription($request->request->get('description'));
        $product->setPrice($request->request->get('price'));
        $product->setStock($request->request->get('stock'));
        $product->setCategory($request->request->get('category'));

        $file = $request->files->get('image');
        if ($file) {
            $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

            try {
                $file->move($this->getParameter('images_directory'), $filename);
                $product->setImageFilename($filename);
            } catch (FileException $e) {
                return new JsonResponse(['error' => 'Failed to upload file'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Product created'], Response::HTTP_CREATED);
    }

    private function generateUniqueFileName(): string
    {
        // This generates a unique name for the file
        return md5(uniqid());
    }

    private function getFormErrors($form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()] = $error->getMessage();
        }
        return $errors;
    }
}
