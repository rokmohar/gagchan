<?php
namespace Category\Mapper;
use Zend\Db\ResultSet\HydratingResultSet;
use Core\Mapper\AbstractMapper;
use Category\Entity\CategoryEntityInterface;
/**
 * @author Rok Mohar <rok.mohar@gmail.com>
 * @author Rok Založnik <tugamer@gmail.com>
 */
class CategoryMapper extends AbstractMapper implements CategoryMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function insertRow(CategoryEntityInterface $category)
    {
        // Check if entity has pre-insert method
        if (method_exists($category, 'preInsert')) {
            // Call a method
            call_user_func(array($category, 'preInsert'));
        }
        // Extract data
        $data = $this->getHydrator()->extract($category);
        // Get insert
        $insert = $this->getInsert();
        $insert
            ->values($data)
        ;
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($insert);
        // Execute statement
        $result = $statement->execute();
        // Set identifier
        $category->setId($result->getGeneratedValue());
        // Return result
        return $result;
    }
    /**
     * {@inheritDoc}
     */
    public function selectAll(array $where = array(), array $order = array())
    {
        // Get select
        $select = $this->getSelect();
        $select
            ->where($where)
            ->order($order)
        ;
        // Prepare a statement
        $stmt = $this->getSql()->prepareStatementForSqlObject($select);
        // Execute the statement
        $resultSet = new HydratingResultSet(
            $this->getHydrator(),
            $this->getEntityClass()
        );
        $resultSet->initialize($stmt->execute());
        // Return result
        return $resultSet;
    }
    /**
     * {@inheritDoc}
     */
    public function selectRow(array $where = array(), array $order = array())
    {
        // Get select
        $select = $this->getSelect();
        $select
            ->where($where)
            ->order($order)
        ;
        // Prepare a statement
        $stmt = $this->getSql()->prepareStatementForSqlObject($select);
        // Execute the statement
        $resultSet = new HydratingResultSet(
            $this->getHydrator(),
            $this->getEntityClass()
        );
        $resultSet->initialize($stmt->execute());
        // Return result
        return $resultSet->current();
    }
    /**
     * Select a row by identifier.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function selectRowById($id)
    {
        return $this->selectRow(array(
            'id' => $id,
        ));
    }
    /**
     * Select a row category by slug.
     *
     * @param string $slug
     *
     * @return mixed
     */
    public function selectRowBySlug($slug)
    {
        return $this->selectRow(array(
            'slug' => $slug,
        ));
    }
    /**
     * {@inheritDoc}
     */
    public function updateRow(CategoryEntityInterface $category)
    {
        // Check if entity has pre-update method
        if (method_exists($category, 'preUpdate')) {
            // Call a method
            call_user_func(array($category, 'preUpdate'));
        }
        // Extract data
        $data = $this->getHydrator()->extract($category);
        // Get update
        $update = $this->getUpdate();
        $update
            ->set($data)
            ->where(array(
                'id' => $category->getId(),
            ))
        ;
        // Prepare statement
        $statement = $this->getSql()->prepareStatementForSqlObject($update);
        // Execute statement
        return $statement->execute();
    }
}
