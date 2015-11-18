<?php
namespace S3b0\EcomNewsletterSubscription\Domain\Repository;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Sebastian Iffland <Sebastian.Iffland@ecom-ex.com>, ecom instruments GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository for Subscriptions
 */
class SubscriptionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Set repository wide settings
	 */
	public function initializeObject() {
		/** @var \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface $querySettings */
		$querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface::class);
		$querySettings->setRespectStoragePage(false); // Disable storage pid
		$this->setDefaultQuerySettings($querySettings);
	}

	/**
	 * @param int $uid
	 * @return object
	 */
	public function findByUid($uid) {
		$query = $this->createQuery();
		$this->setLocalQuerySettings($query);

		return $query->matching(
			$query->equals('uid', $uid)
		)->execute()->getFirst();
	}

	/**
	 * @param string $email
	 * @return null|object
	 */
	public function findByEmail($email) {
		if ( !GeneralUtility::validEmail($email) ) {
			return null;
		}

		$query = $this->createQuery();
		$this->setLocalQuerySettings($query);

		return $query->matching(
			$query->logicalAnd(
				$query->equals('deleted', 0),
				$query->equals('email', $email, false),
				$query->greaterThan('crdate', time() - 604800)
			)
		)->setOrderings([
			'tstamp' => \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_DESCENDING
		])->execute()->getFirst();
	}

	/**
	 * @param string $hash
	 * @param string $email
	 * @return null|object
	 */
	public function findUnconfirmedByHashAndEmail($hash, $email) {
		if ( !GeneralUtility::validEmail($email) ) {
			return null;
		}

		$query = $this->createQuery();
		$this->setLocalQuerySettings($query);

		return $query->matching(
			$query->logicalAnd([
				$query->equals('hidden', 1),
				$query->equals('deleted', 0),
				$query->equals('hash', $hash),
				$query->equals('email', $email, false)
			])
		)->setOrderings([
			'tstamp' => \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_DESCENDING
		])->execute()->getFirst();
	}

	/**
	 * @param string $hash
	 * @param string $email
	 * @return null|object
	 */
	public function findConfirmedByHashAndEmail($hash, $email) {
		if ( !GeneralUtility::validEmail($email) ) {
			return null;
		}

		$query = $this->createQuery();
		$this->setLocalQuerySettings($query);

		return $query->matching(
			$query->logicalAnd([
				$query->equals('hidden', 0),
				$query->equals('deleted', 0),
				$query->equals('hash', $hash),
				$query->equals('email', $email, false)
			])
		)->setOrderings([
			'tstamp' => \TYPO3\CMS\Extbase\Persistence\Generic\Query::ORDER_DESCENDING
		])->execute()->getFirst();
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
	 * @return void
	 */
	private function setLocalQuerySettings(\TYPO3\CMS\Extbase\Persistence\QueryInterface &$query) {
		$query->setQuerySettings(
			$query->getQuerySettings()
				  ->setRespectStoragePage(false)
				  ->setIgnoreEnableFields(true)
		);
	}
}