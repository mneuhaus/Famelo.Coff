<?php
namespace Famelo\Coff\Domain\Model;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Access {

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $keypair;

    /**
     * @var \Famelo\Coff\Domain\Model\Part
     * @ORM\ManyToOne(inversedBy="accesses")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $part;

    /**
     * @var \Famelo\Coff\Domain\Model\User
     * @ORM\ManyToOne(inversedBy="accesses")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $user;

    /**
     * Gets keypair.
     *
     * @return string $keypair
     */
    public function getKeypair() {
        return $this->keypair;
    }

    /**
     * Sets the keypair.
     *
     * @param string $keypair
     */
    public function setKeypair($keypair) {
        $this->keypair = $keypair;
    }

    /**
     * Gets part.
     *
     * @return \Famelo\Coff\Domain\Model\Part $part
     */
    public function getPart() {
        return $this->part;
    }

    /**
     * Sets the part.
     *
     * @param \Famelo\Coff\Domain\Model\Part $part
     */
    public function setPart($part) {
        $this->part = $part;
    }

    /**
     * Gets user.
     *
     * @return \Famelo\Coff\Domain\Model\User $user
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Sets the user.
     *
     * @param \Famelo\Coff\Domain\Model\User $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

}