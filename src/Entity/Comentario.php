<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'comentarios')]
class Comentario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    
    private int $id_usuario;

    #[ORM\Column(type: 'integer')]
    private int $rating;

    #[ORM\Column(type: 'text')]
    private string $texto;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $fecha;

    // --- GETTERS Y SETTERS ---

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdUsuario(): int
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(int $idUsuario): self
    {
        $this->id_usuario = $idUsuario;
        return $this;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    public function getTexto(): string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;
        return $this;
    }

    public function getFecha(): \DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): self
    {
        $this->fecha = $fecha;
        return $this;
    }
}
