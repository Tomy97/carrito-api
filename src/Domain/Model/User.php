<?php

namespace App\Domain\Model;

use App\Domain\Model\Order;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: "string")]
    private string $password;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2,)]
    private float $balance = 0;

    #[ORM\ManyToOne(targetEntity: Rol::class, inversedBy: "users")]
    #[ORM\JoinColumn(name: "rol_id", referencedColumnName: "id")]
    private ?Rol $rol = null;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: "users")]
    #[ORM\JoinColumn(name: "cart_id", referencedColumnName: "id")]
    private ?Cart $cart = null;


    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        // Consider hashing the password here if not done elsewhere
        $this->password = $password;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;
        return $this;
    }

    public function getRol(): ?Rol
    {
        return $this->rol;
    }

    public function setRol(?Rol $rol): self
    {
        $this->rol = $rol;
        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;
        return $this;
    }
}
