<?php
namespace Famelo\Coff\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Coff".           *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * The User Command Controller
 *
 * @Flow\Scope("singleton")
 */
class CoffCommandController extends \TYPO3\Flow\Cli\CommandController {
	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @Flow\Inject
	 * @var \Famelo\Coff\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountFactory
	 */
	protected $accountFactory;

	/**
	 * @var string
	 */
	protected $authenticationProvider = 'CoffProvider';

	/**
	 * Create a new user
	 *
	 * This command creates a new user which has access to the backend user interface.
	 * It is recommended to user the email address as a username.
	 *
	 * @param string $username The username of the user to be created.
	 * @param string $password Password of the user to be created
	 * @param string $firstName First name of the user to be created
	 * @param string $lastName Last name of the user to be created
	 * @param string $roles Roles to add to the user
	 * @return void
	 */
	public function createUserCommand($username, $password, $firstName, $lastName, $roles = NULL) {
		$account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($username, $this->authenticationProvider);
		if ($account instanceof \TYPO3\Flow\Security\Account) {
			$this->outputLine('The username "%s" is already in use', array($username));
			$this->quit(1);
		}

		$user = new \Famelo\Coff\Domain\Model\User;
		$name = new \TYPO3\Party\Domain\Model\PersonName('', $firstName, '', $lastName, '', $username);
		$user->setName($name);

		$this->userRepository->add($user);

		if ($roles !== NULL) {
			$roles = explode(',', $roles);
		} else {
			$roles = array();
		}
		$account = $this->accountFactory->createAccountWithPassword($username, $password, $roles, $this->authenticationProvider);
		$account->setParty($user);
		$this->accountRepository->add($account);

		$this->outputLine('Created user "%s".', array($username));
	}

}
