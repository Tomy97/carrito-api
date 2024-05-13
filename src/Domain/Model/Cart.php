<?php

namespace App\Domain\Model;

use AllowDynamicProperties;
use App\Infrastructure\Repository\DoctrineCartRepository;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: DoctrineCartRepository::class)]

class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'cart', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', unique: true)]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: CartProduct::class, mappedBy: 'cart', cascade: ['persist', 'remove'])]
    #[Groups(['cart_details'])]
    private Collection $cartProducts;

    public function __construct()
    {
        $this->cartProducts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function addProduct(Product $product): void
    {
        if (!$this->cartProducts->contains($product)) {
            $this->cartProducts->add($product);
        }
    }

    public function getProducts(): Collection
    {
        return $this->cartProducts;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): User
    {
        return $this->user = $user;
    }

    public function addCartProduct(CartProduct $cartProduct): Cart
    {
        if (!$this->cartProducts->contains($cartProduct)) {
            $this->cartProducts->add($cartProduct);
            $cartProduct->setCart($this);
        }
        return $this;
    }
}
