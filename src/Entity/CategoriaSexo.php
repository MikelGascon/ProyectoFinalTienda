<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity @ORM\Table(name="categoriaSexo") */
class CategoriaSexo {
    /** @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer") */
    private $id;
    /** @ORM\Column(type="string", length=50) */
    private $nombre;

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
}