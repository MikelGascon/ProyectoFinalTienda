<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity @ORM\Table(name="tipoRopa") */
class TipoRopa {
    /** @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer") */
    private $id;
    /** @ORM\Column(type="string", name="nombre") */
    private $nombre;
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
}