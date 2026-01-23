<?php
namespace App\Entity;
<<<<<<< HEAD
require_once "Usuario.php";
=======
require_once 'Usuario.php';

>>>>>>> f0acb15c720182d68a4c057b6dcd707afd5564b5
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Usuario;

#[ORM\Entity]
#[ORM\Table(name: 'direcciones')]
class Direccion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(name: 'usuario_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Usuario $usuario;

    #[ORM\Column(type: 'string', length: 100)]
    private string $nombre;

    #[ORM\Column(type: 'string', length: 255)]
    private string $direccion;
    
    #[ORM\Column(name: 'codigo_postal', type: 'string', length: 15)]
    private string $codigo_postal;

    #[ORM\Column(type: 'string', length: 100)]
    private string $ciudad;

    #[ORM\Column(type: 'string', length: 100)]
    private string $provincia;

    #[ORM\Column(type: 'string', length: 100)]
    private string $pais = 'España';
    
    #[ORM\Column(name: 'tel', type: 'string', length: 20, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(name: 'predeterminada', type: 'boolean')]
    private bool $predeterminada = false;

    // --- CONSTRUCTOR ---
    public function __construct() {
        // Valores por defecto
        $this->pais = 'España';
        $this->predeterminada = false;
    }

    // --- GETTERS Y SETTERS ---

    public function getId(): int { 
        return $this->id; 
    }

    public function getUsuario(): Usuario { 
        return $this->usuario; 
    }

    public function setUsuario(Usuario $usuario): self { 
        $this->usuario = $usuario; 
        return $this; 
    }

    public function getNombre(): string { 
        return $this->nombre; 
    }

    public function setNombre(string $nombre): self { 
        $this->nombre = $nombre; 
        return $this; 
    }

    public function getDireccion(): string { 
        return $this->direccion; 
    }

    public function setDireccion(string $direccion): self { 
        $this->direccion = $direccion; 
        return $this; 
    }

    public function getCodigoPostal(): string { 
        return $this->codigo_postal; 
    }

    public function setCodigoPostal(string $codigo_postal): self { 
        $this->codigo_postal = $codigo_postal; 
        return $this; 
    }

    public function getCiudad(): string { 
        return $this->ciudad; 
    }

    public function setCiudad(string $ciudad): self { 
        $this->ciudad = $ciudad; 
        return $this; 
    }

    public function getProvincia(): string { 
        return $this->provincia; 
    }

    public function setProvincia(string $provincia): self { 
        $this->provincia = $provincia; 
        return $this; 
    }

    public function getPais(): string { 
        return $this->pais; 
    }

    public function setPais(string $pais): self { 
        $this->pais = $pais; 
        return $this; 
    }

    public function getTelefono(): ?string { 
        return $this->telefono; 
    }

    public function setTelefono(?string $telefono): self { 
        $this->telefono = $telefono; 
        return $this; 
    }

    public function isPredeterminada(): bool { 
        return $this->predeterminada; 
    }

    public function setPredeterminada(bool $predeterminada): self { 
        $this->predeterminada = $predeterminada; 
        return $this; 
    }
}
