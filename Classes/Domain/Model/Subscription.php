<?php
namespace S3b0\EcomNewsletterSubscription\Domain\Model;

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

/**
 * Class Subscription
 * @package S3b0\EcomNewsletterSubscription\Domain\Model
 */
class Subscription extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var int
     */
    protected $pid = 0;

    /**
     * @var int
     */
    protected $creationDate;

    /**
     * @var bool
     */
    protected $hidden = true;

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';

    /**
     * @var int
     */
    protected $gender = -1;

    /**
     * @var string
     */
    protected $firstName = '';

    /**
     * @var string
     */
    protected $middleName = '';

    /**
     * @var string
     */
    protected $lastName = '';

    /**
     * @var \DateTime
     */
    protected $birthday;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     * @validate EmailAddress
     */
    protected $email = '';

    /**
     * @var string
     */
    protected $phone = '';

    /**
     * @var string
     */
    protected $fax = '';

    /**
     * @var string
     */
    protected $mobile = '';

    /**
     * @var string
     */
    protected $www = '';

    /**
     * @var string
     */
    protected $address = '';

    /**
     * @var string
     */
    protected $building = '';

    /**
     * @var string
     */
    protected $room = '';

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $company = '';

    /**
     * @var string
     */
    protected $city = '';

    /**
     * @var string
     */
    protected $zip = '';

    /**
     * @var \Ecom\EcomToolbox\Domain\Model\State
     */
    protected $state;

    /**
     * @var \Ecom\EcomToolbox\Domain\Model\Region
     */
    protected $country;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $hash = '';

    /**
     * @return boolean
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @param boolean $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return int
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param int $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getGender()
    {
        switch ($this->gender) {
            case 1:
                return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('gender.1',
                    'ecom_newsletter_subscription') ?: 'Mrs.';
            default:
                return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('gender.0',
                    'ecom_newsletter_subscription') ?: 'Mr.';
        }
    }

    /**
     * @param int $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getWww()
    {
        return $this->www;
    }

    /**
     * @param string $www
     */
    public function setWww($www)
    {
        $this->www = $www;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param string $building
     */
    public function setBuilding($building)
    {
        $this->building = $building;
    }

    /**
     * @return string
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param string $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return \Ecom\EcomToolbox\Domain\Model\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param \Ecom\EcomToolbox\Domain\Model\State $state
     */
    public function setState(\Ecom\EcomToolbox\Domain\Model\State $state = null)
    {
        $this->state = $state;
    }

    /**
     * @return \Ecom\EcomToolbox\Domain\Model\Region
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param \Ecom\EcomToolbox\Domain\Model\Region $country
     */
    public function setCountry(\Ecom\EcomToolbox\Domain\Model\Region $country = null)
    {
        $this->country = $country;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image = null)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

}
