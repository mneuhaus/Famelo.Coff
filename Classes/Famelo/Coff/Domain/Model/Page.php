<?php
namespace Famelo\Coff\Domain\Model;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @Flow\Entity
 */
class Page {

    use TimestampableEntity;
    /**
     * TODO: Document this Property!
     * @var string
     */
    protected $name;

    /**
     * @var \Doctrine\Common\Collections\Collection<\Famelo\Coff\Domain\Model\Part>
     * @ORM\OneToMany(mappedBy="page")
     */
    protected $parts;

    public function __constuct() {
        $this->parts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Gets name.
     *
     * @return string $name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Add to the parts.
     *
     * @param \Famelo\Coff\Domain\Model\Part $part
     */
    public function addPart($part) {
        $this->parts->add($part);
    }

    /**
     * Remove from parts.
     *
     * @param \Famelo\Coff\Domain\Model\Part $part
     */
    public function removePart($part) {
        $this->parts->remove($part);
    }

    /**
     * Gets parts.
     *
     * @return \Doctrine\Common\Collections\Collection<\Famelo\Coff\Domain\Model\Part> $parts
     */
    public function getParts() {
        return $this->parts;
    }

    /**
     * Sets the parts.
     *
     * @param \Doctrine\Common\Collections\Collection<\Famelo\Coff\Domain\Model\Part> $parts
     */
    public function setParts($parts) {
        $this->parts = $parts;
    }

}