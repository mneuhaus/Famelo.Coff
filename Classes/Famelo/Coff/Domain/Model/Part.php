<?php
namespace Famelo\Coff\Domain\Model;
use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\Context;

/**
 * @Flow\Entity
 */
class Part {

    /**
     * TODO: Document this Property!
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $name;

    /**
     * TODO: Document this Property!
     * @var string
     */
    protected $type;

    /**
     * TODO: Document this Property!
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $data;

    /**
     * @var \Famelo\Coff\Domain\Model\Page
     * @ORM\ManyToOne(inversedBy="parts")
     */
    protected $page;

    /**
     * @var \Doctrine\Common\Collections\Collection<\Famelo\Coff\Domain\Model\Access>
     * @ORM\OneToMany(mappedBy="part")
     */
    protected $accesses;

    /**
     * @var Context
     * @Flow\Inject
     * @Flow\Transient
     */
    protected $securityContext;

    /**
     * TODO: Document this Method! ( __toString )
     */
    public function __toString() {
        return $this->name;
    }

    public function __constuct() {
        $this->accesses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \Famelo\Coff\Domain\Model\User $user
     */
    public function getUserAccess($user = NULL) {
        if ($user === NULL) {
            $user = $this->securityContext->getParty();
        }
        if ($this->accesses === NULL) {
            return;
        }
        foreach ($this->accesses as $access) {
            if ($access->getUser() == $user) {
                return $access;
            }
        }
    }

    /**
     * Gets data.
     *
     * @return string $data
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Sets the data.
     *
     * @param string $data
     */
    public function setData($data) {
        $this->data = $data;
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
     * Gets page.
     *
     * @return \Famelo\Coff\Domain\Model\Page $page
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * Sets the page.
     *
     * @param \Famelo\Coff\Domain\Model\Page $page
     */
    public function setPage($page) {
        $this->page = $page;
    }

    /**
     * Gets type.
     *
     * @return string $type
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Sets the type.
     *
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

}