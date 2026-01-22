<?php
namespace App\Entity;
require_once "Usuario.php";
<<<<<<< HEAD
=======

>>>>>>> 8369c3836a2321d50042d3f5820d1b0e4b664ba1
use Doctrine\ORM\Mapping as ORM;
use DateTime;
// Importamos la entidad Usuario para la relación
use App\Entity\Usuario;

#[ORM\Entity]
#[ORM\Table(name: 'pedido')]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(name: 'usuario_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Usuario $usuario;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nombre;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $precio;

    #[ORM\Column(type: 'integer')]
    private int $cantidadProductos;

    #[ORM\Column(type: 'datetime')]
    private DateTime $fecha;

    public function __construct()
    {
        $this->fecha = new DateTime();
    }

    // --- GETTERS Y SETTERS ---
    public function getId(): int
    {
        return $this->id;
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    // El Setter ahora recibe un objeto Usuario
    public function setUsuario(Usuario $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getPrecio(): string
    {
        return $this->precio;
    }
    public function setPrecio(string $precio): self
    {
        $this->precio = $precio;
        return $this;
    }

    public function getCantidadProductos(): int
    {
        return $this->cantidadProductos;
    }
    public function setCantidadProductos(int $cantidadProductos): self
    {
        $this->cantidadProductos = $cantidadProductos;
        return $this;
    }

    public function getFecha(): DateTime
    {
        return $this->fecha;
    }
}
