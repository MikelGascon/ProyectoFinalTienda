<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use DateTime;

#[ORM\Entity]
#[ORM\Table(name: 'favoritos')]
#[ORM\UniqueConstraint(name: 'usuario_producto', columns: ['usuario_id', 'producto_id'])]
class Favorito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(name: 'usuario_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Usuario $usuario = null;

    #[ORM\ManyToOne(targetEntity: Producto::class)]
    #[ORM\JoinColumn(name: 'producto_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Producto $producto = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name: 'fecha_agregado', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?DateTime $fechaAgregado = null;

    // --- CONSTRUCTOR ---
    public function __construct()
    {
        $this->fechaAgregado = new DateTime();
    }

    // --- GETTERS ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function getFechaAgregado(): ?DateTime
    {
        return $this->fechaAgregado;
    }

    // --- SETTERS ---

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;
        return $this;
    }

    public function setFechaAgregado(?DateTime $fechaAgregado): self
    {
        $this->fechaAgregado = $fechaAgregado;
        return $this;
    }
}