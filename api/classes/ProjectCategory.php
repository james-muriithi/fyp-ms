<?php


class ProjectCategory
{
    /**
     * @var int
     */
    private $catId;

    /**
     * @var PDO
     */
    public $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addCategory(string $name) :bool
    {
        $query = 'INSERT INTO project_categories SET name = :name';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);

        return $stmt->execute();
    }

    public function editCategory($id,string $name) :bool
    {
        $query = 'UPDATE project_categories SET name = :name WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function deleteCategory(string $id):bool
    {
        $query = 'DELETE FROM project_categories WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function viewAllCategories():array
    {
        $query = 'SELECT 
                        *
                   FROM project_categories';

        $stmt = $this->conn->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewCategory($catId = ''):array
    {
        $catId = !empty($catId) ? $catId : $this->catId;
        $query = 'SELECT 
                        *
                   FROM project_categories
                   WHERE id = :cat_id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':cat_id', $catId);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function categoryExists($catId = ''):bool
    {
        $catId = !empty($catId) ? $catId :$this->getCatId();
        if (empty($catId)){
            return false;
        }

        $query = 'SELECT name FROM project_categories WHERE id = :cat_id ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':cat_id', $this->catId);

        $stmt->execute();

        return $stmt->rowCount()>0;
    }

    public function categoryNameExists($name)
    {
        $query = 'SELECT name FROM project_categories WHERE name = :name ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);

        $stmt->execute();

        return $stmt->rowCount()>0;
    }


    /**
     * @return int
     */
    public function getCatId(): int
    {
        return $this->catId;
    }

    /**
     * @param int $catId
     */
    public function setCatId(int $catId): void
    {
        $this->catId = $catId;
    }
}