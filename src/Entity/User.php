<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
#[UniqueEntity(fields: 'email', message: 'Пользователь с таким email уже существует')]
#[UniqueEntity(fields: 'phone', message: 'Пользователь с таким phone уже существует')]

class User
{
    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"AUTO")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    #[Assert\NotBlank(message: 'Заполните email')]
    #[Assert\Email(message: 'Неверный формат email')]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Заполните name')]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Заполните age')]
    #[Assert\GreaterThan(0, message: 'Возраст age должен быть больше 16')]
    private ?int $age = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Заполните sex')]
    #[Assert\Choice(choices: ['м', 'ж'], message: "Выбранный пол недействителен. Пол должен быть либо 'м', либо 'ж'.")]
    private ?string $sex = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Заполните birthday')]
    #[Assert\Regex(pattern: "/^\d{1,2}\-\d{2}\-\d{4}$/", message: "Формат birthday должен быть 'd-m-Y'")]
    private ?string $birthday = null;

    #[ORM\Column(length: 20, unique: true, nullable: false)]
    #[Assert\NotBlank(message: 'Заполните phone')]
    #[Assert\Regex(pattern: "/^\+?\d+$/", message: 'Неверный формат phone')]
    #[Assert\Length(
        max: 11,
        maxMessage: 'Длинна phone не должна превышать {{ limit }} цифр'
    )]
    private ?string $phone = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function setBirthday(string $birthday): static
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
