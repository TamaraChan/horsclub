<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="service")
 */
class Service
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id_service", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idService;

    /**
     * @ORM\Column(type="string", length=255, name="name")
     */
    private $name;


    public function getIdService(): ?int
    {
        return $this->idService;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
