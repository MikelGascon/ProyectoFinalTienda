<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="productos")
 */
class Producto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string") */
    private $nombre;

    /** @ORM\Column(type="decimal", precision=10, scale=2) */
    private $precio;

    /** @ORM\Column(type="string") */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity="CategoriaSexo")
     * @ORM\JoinColumn(name="categoriaId", referencedColumnName="id")
     */
    private $categoria;

    /**
     * @ORM\ManyToOne(targetEntity="Marcas")
     * @ORM\JoinColumn(name="marcaId", referencedColumnName="id")
     */
    private $marca;

    /**
     * @ORM\ManyToOne(targetEntity="TipoRopa")
     * @ORM\JoinColumn(name="tipo_ropaId", referencedColumnName="id")
     */
    private $tipoRopa;

    /**
     * @ORM\ManyToOne(targetEntity="TallaRopa")
     * @ORM\JoinColumn(name="tallaId", referencedColumnName="id")
     */
    private $talla;

    // Getters necesarios para el HTML
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getPrecio() { return $this->precio; }
    public function getColor() { return $this->color; }
    public function getCategoria() { return $this->categoria; }
    public function getMarca() { return $this->marca; }
    public function getTipoRopa() { return $this->tipoRopa; }
    public function getTalla() { return $this->talla; }

    // Setters para la edición rápida
    public function setColor($color) { $this->color = $color; }
    public function setTipoRopa($tipo) { $this->tipoRopa = $tipo; }
    public function setTalla($talla) { $this->talla = $talla; }
}