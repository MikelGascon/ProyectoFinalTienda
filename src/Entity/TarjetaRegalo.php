<?php
namespace App\Entity;
require_once "Usuario.php";
<<<<<<< HEAD
=======

>>>>>>> 8369c3836a2321d50042d3f5820d1b0e4b664ba1
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Usuario;


#[ORM\Entity]
#[ORM\Table(name: 'tarjetas_regalo')]

class TarjetaRegalo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(name: 'usuario_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Usuario $usuario;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $codigo = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $importe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $mensaje = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $fecha_compra;

    public function __construct()
    {
        $this->fecha_compra = new \DateTime();
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

     public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function getImporte(): float
    {
        return $this->importe;
    }

    public function setImporte(float $importe): self
    {
        $this->importe = $importe;
        return $this;
    }

    public function getMensaje(): ?string
    {
        return $this->mensaje;
    }

    public function setMensaje(?string $mensaje): self
    {
        $this->mensaje = $mensaje;
        return $this;
    }

    public function getFechaCompra(): \DateTime
    {
        return $this->fecha_compra;
    }

    public function setFechaCompra(\DateTime $fechaCompra): self
    {
        $this->fecha_compra = $fechaCompra;
        return $this;
    }
}