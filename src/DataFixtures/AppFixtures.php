<?php

namespace App\DataFixtures;

use App\Domain\Model\Cart;
use App\Domain\Model\CartProduct;
use App\Domain\Model\Product;
use App\Domain\Model\Rol;
use App\Domain\Model\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Crear roles
        $adminRole = new Rol();
        $adminRole->setName('Admin');
        $manager->persist($adminRole);

        $userRole = new Rol();
        $userRole->setName('User');
        $manager->persist($userRole);

        // Crear usuario normal
        $user = new User();
        $user->setName('John Doe');
        $user->setEmail('john.doe@example.com');
        $user->setPassword('securepassword');
        $user->setBalance(150.50);
        $user->setRol($adminRole);
        $manager->persist($user);

        // Crear usuario admin
        $user1 = new User();
        $user1->setName('User Admin');
        $user1->setEmail('admin@admin.com');
        $user1->setPassword('admin');
        $user1->setBalance(200000);
        $user1->setRol($adminRole);
        $manager->persist($user1);


        // Crear productos
        $product1 = new Product();
        $product1->setName('Product 1');
        $product1->setDescription('Description of product 1');
        $product1->setCategory('Electronica');
        $product1->setPrice(10.99);
        $product1->setStock(20);
        $product1->setImageFilename('https://http2.mlstatic.com/D_NQ_NP_749183-MLA54967257394_042023-O.webp');
        $manager->persist($product1);

        // Crear productos
        $product2 = new Product();
        $product2->setName('Remeras Talles Especiales Lisas 3xl 4xl 5xl 6xl 7xl 8xl');
        $product2->setDescription('Descripcion 2');
        $product2->setCategory('Electronica');
        $product2->setPrice(6000);
        $product2->setStock(20);
        $product2->setImageFilename('https://http2.mlstatic.com/D_NQ_NP_760847-MLA74217675247_012024-O.webp');
        $manager->persist($product2);

        // Crear carrito
        $cart = new Cart();
        $cart->setUser($user);
        $cart->setCartProducts(new ArrayCollection());
        $manager->persist($cart);

        // Crear CartProduct
        $cartProduct = new CartProduct();
        $cartProduct->setCart($cart);
        $cartProduct->setProduct($product1);
        $cartProduct->setQuantity(2);
        $manager->persist($cartProduct);

        // Guardar
        $manager->flush();
    }
}
