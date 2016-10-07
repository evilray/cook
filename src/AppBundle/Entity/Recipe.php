<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Recipe {
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var string
	 * @Gedmo\Slug(fields={"name"}, updatable=true)
	 * @ORM\Column(name="slug", type="string", length=255, unique=true)
	 */
	private $slug;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=255, nullable=true)
	 */
	private $description;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="duration", type="string")
	 */
	private $duration = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="portions", type="integer")
	 */
	private $portions = 0;


	/**
	 * @var string
	 *
	 * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $owner;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="createdAt", type="datetime")
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updateAt", type="datetime", nullable=true)
	 */
	private $updateAt;

	/**
	 * @ORM\ManyToMany(targetEntity="Category", inversedBy="recipes")
	 * @ORM\JoinTable(name="recipe_category")
	 *
	 */
	private $categories;

	/**
	 * @ORM\OneToMany(targetEntity="Photo", mappedBy="recipe")
	 */
	private $photos;

	/**
	 * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="recipe")
	 */
	private $ingredients;


	/**
	 * @var bool
	 * @ORM\Column(name="isDraft", type="boolean")
	 */
	private $isDraft = true;

	public function __construct() {
		$this->categories  = new ArrayCollection();
		$this->photos      = new ArrayCollection();
		$this->ingredients = new ArrayCollection();
	}

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Recipe
	 */
	public function setName( $name ) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set slug
	 *
	 * @param string $slug
	 *
	 * @return Recipe
	 */
	public function setSlug( $slug ) {
		$this->slug = $slug;

		return $this;
	}

	/**
	 * Get slug
	 *
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * Set description
	 *
	 * @param string $description
	 *
	 * @return Recipe
	 */
	public function setDescription( $description ) {
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Set duration
	 *
	 * @param integer $duration
	 *
	 * @return Recipe
	 */
	public function setDuration( $duration ) {
		$this->duration = $duration;

		return $this;
	}

	/**
	 * Get duration
	 *
	 * @return int
	 */
	public function getDuration() {
		return $this->duration;
	}

	/**
	 * Set portions
	 *
	 * @param integer $portions
	 *
	 * @return Recipe
	 */
	public function setPortions( $portions ) {
		$this->portions = $portions;

		return $this;
	}

	/**
	 * Get portions
	 *
	 * @return int
	 */
	public function getPortions() {
		return $this->portions;
	}

	/**
	 * Set owner
	 *
	 * @param \UserBundle\Entity\User $owner
	 *
	 * @return Recipe
	 */
	public function setOwner( \UserBundle\Entity\User $owner ) {
		$this->owner = $owner;

		return $this;
	}

	/**
	 * Get owner
	 *
	 * @return \UserBundle\Entity\User
	 */
	public function getOwner() {
		return $this->owner;
	}

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 *
	 * @return Recipe
	 */
	public function setCreatedAt( $createdAt ) {
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * Get createdAt
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * Set updateAt
	 *
	 * @param \DateTime $updateAt
	 *
	 * @return Recipe
	 */
	public function setUpdateAt( $updateAt ) {
		$this->updateAt = $updateAt;

		return $this;
	}

	/**
	 * Get updateAt
	 *
	 * @return \DateTime
	 */
	public function getUpdateAt() {
		return $this->updateAt;
	}

	/**
	 * Add category
	 *
	 * @param \AppBundle\Entity\Category $category
	 *
	 * @return Recipe
	 */
	public function addCategory( \AppBundle\Entity\Category $category ) {
		$this->categories[] = $category;

		return $this;
	}

	/**
	 * Remove category
	 *
	 * @param \AppBundle\Entity\Category $category
	 */
	public function removeCategory( \AppBundle\Entity\Category $category ) {
		$this->categories->removeElement( $category );
	}

	/**
	 * Get categories
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Add photo
	 *
	 * @param \AppBundle\Entity\Photo $photo
	 *
	 * @return Recipe
	 */
	public function addPhoto( \AppBundle\Entity\Photo $photo ) {
		$this->photos[] = $photo;

		return $this;
	}

	/**
	 * Remove photo
	 *
	 * @param \AppBundle\Entity\Photo $photo
	 */
	public function removePhoto( \AppBundle\Entity\Photo $photo ) {
		$this->photos->removeElement( $photo );
	}

	/**
	 * Get photos
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getPhotos() {
		return $this->photos;
	}

	/**
	 * Add ingredient
	 *
	 * @param \AppBundle\Entity\Ingredient $ingredient
	 *
	 * @return Recipe
	 */
	public function addIngredient( \AppBundle\Entity\Ingredient $ingredient ) {
		$this->ingredients[] = $ingredient;

		return $this;
	}

	/**
	 * Remove ingredient
	 *
	 * @param \AppBundle\Entity\Ingredient $ingredient
	 */
	public function removeIngredient( \AppBundle\Entity\Ingredient $ingredient ) {
		$this->ingredients->removeElement( $ingredient );
	}

	/**
	 * Get ingredients
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getIngredients() {
		return $this->ingredients;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function prePersist() {
		$this->createdAt = new \DateTime();

	}

	/**
	 * @ORM\PreUpdate
	 */
	public function preUpdate() {
		$this->updatedAt = new \DateTime();
	}

	/**
	 * @return boolean
	 */
	public function isDraft() {
		return $this->isDraft;
	}

	/**
	 * @param boolean $isDraft
	 *
	 * @return Recipe
	 */
	public function setIsDraft( $isDraft ) {
		$this->isDraft = $isDraft;

		return $this;
	}

}
