<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: "productos")]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private $precio;

    #[ORM\Column(type: Types::STRING, length: 100, nullable: true)]
    private ?string $color = null;

    #[ORM\ManyToOne(targetEntity: CategoriaSexo::class)]
    #[ORM\JoinColumn(name: "categoriaId", referencedColumnName: "id")]
    private ?CategoriaSexo $categoria = null;

    #[ORM\ManyToOne(targetEntity: Marcas::class)]
    #[ORM\JoinColumn(name: "marcaId", referencedColumnName: "id")]
    private ?Marcas $marca = null;

    #[ORM\ManyToOne(targetEntity: TipoRopa::class)]
    #[ORM\JoinColumn(name: "tipo_ropaId", referencedColumnName: "id")]
    private ?TipoRopa $tipoRopa = null;

    #[ORM\ManyToOne(targetEntity: TallaRopa::class)]
    #[ORM\JoinColumn(name: "tallaId", referencedColumnName: "id")]
    private ?TallaRopa $talla = null;

    // --- GETTERS ---

    public function getId(): ?int 
    { 
        return $this->id; 
    }

    public function getNombre(): ?string 
    { 
        return $this->nombre; 
    }

    public function getPrecio() 
    { 
        return $this->precio; 
    }

    public function getColor(): ?string 
    { 
        return $this->color; 
    }

    public function getCategoria(): ?CategoriaSexo 
    { 
        return $this->categoria; 
    }

    public function getMarca(): ?Marcas 
    { 
        return $this->marca; 
    }

    public function getTipoRopa(): ?TipoRopa 
    { 
        return $this->tipoRopa; 
    }

    public function getTalla(): ?TallaRopa 
    { 
        return $this->talla; 
    }

    // --- SETTERS ---

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function setPrecio($precio): self
    {
        $this->precio = $precio;
        return $this;
    }

    public function setColor(?string $color): self 
    { 
        $this->color = $color; 
        return $this;
    }

    public function setCategoria(?CategoriaSexo $categoria): self
    {
        $this->categoria = $categoria;
        return $this;
    }

    public function setMarca(?Marcas $marca): self
    {
        $this->marca = $marca;
        return $this;
    }

    public function setTipoRopa(?TipoRopa $tipo): self 
    { 
        $this->tipoRopa = $tipo; 
        return $this;
    }

    public function setTalla(?TallaRopa $talla): self 
    { 
        $this->talla = $talla; 
        return $this;
    }
}