<?php
namespace App\Entity;

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

    /* 
       Enlace con Usuario: 
       Muchas direcciones pertenecen a un único usuario.
    */
    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(name: 'usuario_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Usuario $usuario;

    #[ORM\Column(type: 'string', length: 255)]
    private string $direccion;

    #[ORM\Column(type: 'string', length: 100)]
    private string $pais;

    #[ORM\Column(type: 'string', length: 100)]
    private string $provincia;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $tel; // Permitimos que sea nulo si no se proporciona

    
    // --- GETTERS Y SETTERS ---
    public function getId(): int
    {
        return $this->id;
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;
        return $this;
    }

    public function getPais(): string
    {
        return $this->pais;
    }

    public function setPais(string $pais): self
    {
        $this->pais = $pais;
        return $this;
    }

    public function getProvincia(): string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): self
    {
        $this->provincia = $provincia;
        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;
        return $this;
    }
}
