<?php
namespace Famelo\Coff\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Coff".           *
 *                                                                        *
 *                                                                        */

use Flowpack\Expose\Controller\CrudController;
use TYPO3\Flow\Annotations as Flow;

/**
 * Standard controller for the Brain package
 *
 * @Flow\Scope("singleton")
 */
class PublicKeyController extends CrudController {
	/**
	 * @var string
	 */
	protected $entity = '\Famelo\Coff\Domain\Model\User';
}

?>