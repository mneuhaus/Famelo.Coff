<?php
namespace Famelo\Coff\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Coff".           *
 *                                                                        *
 *                                                                        */

use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * A person
 *
 * @Flow\Entity
 */
class User extends \TYPO3\Party\Domain\Model\Person {

    use TimestampableEntity;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $publicKey;

    /**
     * @var \Doctrine\Common\Collections\Collection<\Famelo\Coff\Domain\Model\Access>
     * @ORM\OneToMany(mappedBy="user")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $accesses;

    /**
     * TODO: Document this Method! ( __toString )
     */
    public function __toString() {
        return $this->getName()->getFullName();
    }

    /**
     * Add to the accesses.
     *
     * @param \Famelo\Coff\Domain\Model\Access $access
     */
    public function addAccess($access) {
        $this->accesses->add($access);
    }

    /**
     * Gets accesses.
     *
     * @return \Doctrine\Common\Collections\Collection<\Famelo\Coff\Domain\Model\Access> $accesses
     */
    public function getAccesses() {
        return $this->accesses;
    }

    /**
     * Sets the accesses.
     *
     * @param \Doctrine\Common\Collections\Collection<\Famelo\Coff\Domain\Model\Access> $accesses
     */
    public function setAccesses($accesses) {
        $this->accesses = $accesses;
    }

    /**
     * Remove from accesses.
     *
     * @param \Famelo\Coff\Domain\Model\Access $access
     */
    public function removeAccess($access) {
        $this->accesses->remove($access);
    }

    /**
     * Gets publicKey.
     *
     * @return string $publicKey
     */
    public function getPublicKey() {
        return $this->publicKey;
    }

    /**
     * Sets the publicKey.
     *
     * @param string $publicKey
     */
    public function setPublicKey($publicKey) {
        $this->publicKey = $publicKey;
    }

}