<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: "marcas")]
class Marcas 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private ?string $nombre = null;

    // --- GETTERS ---

    public function getId(): ?int 
    { 
        return $this->id; 
    }

    public function getNombre(): ?string 
    { 
        return $this->nombre; 
    }

    // --- SETTERS ---

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }
}