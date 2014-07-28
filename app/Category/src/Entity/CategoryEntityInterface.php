<?php
namespace Category\Entity;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
interface CategoryEntityInterface
{
    /**
     * Return the identifier.
     *
     * @return int
     */
    public function getId();
    /**
     * Set the identifier.
     *
     * @param int $id
     */
    public function setId($id);
    /**
     * Return the slug.
     *
     * @return string
     */
    public function getSlug();
    /**
     * Set the slug.
     *
     * @return string $slug
     */
    public function setSlug($slug);
    /**
     * Return the name.
     *
     * @return string
     */
    public function getName();
    /**
     * Set the name.
     *
     * @param string $name
     */
    public function setName($name);
    /**
     * Return the priority.
     *
     * @return int
     */
    public function getPriority();
    /**
     * Set the priority.
     *
     * @param int $priority
     */
    public function setPriority($priority);
    /**
     * Return created at date.
     *
     * @return \DateTime
     */
    public function getCreatedAt();
    /**
     * Set create at date.
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);
    /**
     * Return updated at date.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();
    /**
     * Set updated at date.
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);
}
