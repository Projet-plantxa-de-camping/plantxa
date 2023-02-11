<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'adresse email que vous avez tapée est déjà utilisée !" * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Votre mot de passe doit comporter au minimum {{ limit }} caractères")
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath = "password",
     * message="Vous n'avez pas saisi le même mot de passe !" )
     */
    private $confirm_password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\Column(type="integer")
     */
    private $role_id;

    public function __construct()
    {
        $this->role = $this->getDefaultRole();
    }

    private function getDefaultRole()
    {
        $role = $this->getDoctrine()
            ->getRepository(Role::class)
            ->findOneBy(['name' => 'User']);

        return $role;
    }
    public function getRoles(): array
    {
        $roles = $this->roles;
        // garantit que chaque utilisateur possède le rôle ROLE_USER
        // équivalent à array_push() qui ajoute un élément au tabeau
        $roles[] = 'ROLE_USER';
        //array_unique élimine des doublons
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

        public
        function getConfirmPassword()
        {
            return $this->confirm_password;
        }

        public
        function setConfirmPassword($confirm_password)
        {
            $this->confirm_password = $confirm_password;
            return $this;
        }

        public
        function getId(): ?int
        {
            return $this->id;
        }

        public
        function getEmail(): ?string
        {
            return $this->email;
        }

        public
        function setEmail(string $email): self
        {
            $this->email = $email;

            return $this;
        }

        public
        function getUsername(): ?string
        {
            return $this->username;
        }

        public
        function setUsername(string $username): self
        {
            $this->username = $username;

            return $this;
        }

        public
        function getPassword(): ?string
        {
            return $this->password;
        }

        public
        function setPassword(string $password): self
        {
            $this->password = $password;

            return $this;
        }

        public
        function eraseCredentials(): void
        {
        }


        public
        function getSalt()
        {
        }

        public function getRoleId(): ?int
        {
            return $this->role_id;
        }

        public function setRoleId(int $role_id): self
        {
            $this->role_id = $role_id;

            return $this;
        }
    }
