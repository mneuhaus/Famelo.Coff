<?php
namespace Famelo\Coff\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Coff".           *
 *                                                                        *
 *                                                                        */

use Famelo\Coff\Domain\Model\Access;
use Famelo\Coff\Domain\Model\Page;
use Famelo\Coff\Domain\Model\Part;
use Famelo\Coff\Domain\Repository\AccessRepository;
use Famelo\Coff\Domain\Repository\PageRepository;
use Famelo\Coff\Domain\Repository\PartRepository;
use Flowpack\Expose\Controller\AbstractExposeController;
use GibberishAES\GibberishAES;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\Context;

/**
 * Standard controller for the Brain package
 *
 * @Flow\Scope("singleton")
 */
class StandardController extends AbstractExposeController {
	/**
	 * @var PageRepository
	 * @Flow\Inject
	 */
	protected $pageRepository;

	/**
	 * @var PartRepository
	 * @Flow\Inject
	 */
	protected $partRepository;

	/**
	 * @var AccessRepository
	 * @Flow\Inject
	 */
	protected $accessRepository;

	/**
	 * @var Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	public function indexAction() {
		$this->view->assign('pages', $this->pageRepository->findAll());
	}

	/**
	 *
	 * @param Page $page
	 */
	public function newAction(Page $page = NULL) {
		if ($page === NULL) {
			$page = new Page();
		}
		$this->view->assign('page', $page);
	}

	/**
	 *
	 * @param Page $page
	 */
	public function createAction(Page $page) {
		$this->pageRepository->add($page);
		$this->redirect('show', NULL, NULL, array('page' => $page));
	}

	/**
	 *
	 * @param Page $page
	 */
	public function showAction(Page $page) {
		$this->view->assign('page', $page);
	}

	/**
	 *
	 * @param Page $page
	 * @param string $type
	 */
	public function createPartAction(Page $page, $type) {
		$part = new Part();
		$part->setPage($page);
		$part->setType($type);
		$this->partRepository->add($part);
		$this->view->assign('part', $part);
	}

	/**
	 *
	 * @param Part $part
	 * @param string $data
	 */
	public function savePartAction(Part $part, $data) {
		$key = 'foobar';
		GibberishAES::size(256);
		$encryptedData = GibberishAES::enc($data, $key);

		$rsa = new \phpseclib\Crypt\RSA();
		$rsa->loadKey($this->securityContext->getParty()->getPublicKey());
		$rsa->setEncryptionMode(\phpseclib\Crypt\RSA::ENCRYPTION_PKCS1);
		$key = base64_encode($rsa->encrypt($key));

		$access = $part->getUserAccess($this->securityContext->getParty());
		if ($access === NULL) {
			$access = new Access();
			$access->setUser($this->securityContext->getParty());
			$access->setPart($part);
			$access->setKeypair($key);
			$this->accessRepository->add($access);
		} else {
			$access->setKeypair($key);
			$this->accessRepository->update($access);
		}

		$part->setData($encryptedData);
		$this->partRepository->update($part);

		$this->view->assign('part', $part);
	}

	/**
	 *
	 * @param Part $part
	 */
	public function removePartAction(Part $part) {
		$this->partRepository->remove($part);
		$this->persistenceManager->persistAll();
		$this->redirect('show', NULL, NULL, array('page' => $part->getPage()));
	}
}

?>