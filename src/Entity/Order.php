<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id_order", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idOrder;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_service", type="integer")
     */
    private $idService;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", columnDefinition="text")
     */
    private $comment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_confirmed", type="boolean")
     */
    private $isConfirmed;

    /**
     * @return int
     */
    public function getIdOrder(): int
    {
        return $this->idOrder;
    }

    /**
     * @return int
     */
    public function getIdService(): int
    {
        return $this->idService;
    }

    /**
     * @param int $idService
     * @return Order
     */
    public function setIdService(int $idService): Order
    {
        $this->idService = $idService;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Order
     */
    public function setName(string $name): Order
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Order
     */
    public function setPhone(string $phone): Order
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Order
     */
    public function setComment(string $comment): Order
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    /**
     * @param boolean $isConfirmed
     * @return Order
     */
    public function setIsConfirmed(bool $isConfirmed): Order
    {
        $this->isConfirmed = $isConfirmed;
        return $this;
    }
}
