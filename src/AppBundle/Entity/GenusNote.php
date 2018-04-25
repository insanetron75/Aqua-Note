<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GenusNoteRepository")
 * @ORM\Table(name="genus_note")
 */
class GenusNote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $userName;
    /**
     * @ORM\Column(type="string")
     */
    private $userAvatarFileName;
    /**
     * @ORM\Column(type="text")
     */
    private $note;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Genus", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genus;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getUserAvatarFileName()
    {
        return $this->userAvatarFileName;
    }

    /**
     * @param mixed $userAvatarFileName
     */
    public function setUserAvatarFileName($userAvatarFileName): void
    {
        $this->userAvatarFileName = $userAvatarFileName;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note): void
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Genus
     */
    public function getGenus()
    {
        return $this->genus;
    }

    /**
     * @param Genus $genus
     */
    public function setGenus(Genus $genus): void
    {
        $this->genus = $genus;
    }

}