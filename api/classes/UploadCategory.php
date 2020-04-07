<?php
date_default_timezone_set('Africa/Nairobi');

class UploadCategory
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

    public function addCategory(string $name,$description, $startDate, $deadline) :bool
    {
        $query = 'INSERT INTO upload_category 
                    SET name = :name, description = :desc, start_date = :start_date, deadline =:deadline';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':desc', $description);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':deadline', $deadline);

        return $stmt->execute();
    }

    public function editCategory($id,string $name,$description, $startDate, $deadline) :bool
    {
        $query = 'UPDATE upload_category SET 
                           name = :name,description = :desc, start_date = :start_date, deadline =:deadline  
                    WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':desc', $description);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':deadline', $deadline);

        return $stmt->execute();
    }

    public function deleteCategory(string $id):bool
    {
        $query = 'DELETE FROM upload_category WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function viewAllCategories():array
    {
        $query = 'SELECT 
                        uc.*,
                        ifnull(nou.no_of_uploads, 0) as no_of_uploads
                   FROM upload_category uc
                    LEFT JOIN (SELECT category, COUNT(*) as no_of_uploads FROM upload GROUP BY category) as nou
                    ON nou.category = uc.id
                    ORDER BY uc.deadline ASC';

        $stmt = $this->conn->query($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewCategory($catId = ''):array
    {
        $catId = !empty($catId) ? $catId : $this->catId;
        $query = 'SELECT 
                        uc.*,
                        ifnull(nou.no_of_uploads, 0) as no_of_uploads
                   FROM upload_category uc
                    LEFT JOIN (SELECT category, COUNT(*) as no_of_uploads FROM upload GROUP BY category) as nou
                    ON nou.category = uc.id
                   WHERE uc.id = :cat_id
                   ORDER BY uc.deadline ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':cat_id', $catId);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    public function categoryExists($catId = ''):bool
    {
        $catId = !empty($catId) ? $catId :$this->getCatId();
        if (empty($catId)){
            return false;
        }

        $query = 'SELECT name FROM upload_category WHERE id = :cat_id ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':cat_id', $catId);

        $stmt->execute();

        return $stmt->rowCount()>0;
    }

    public function categoryNameExists($name):bool
    {

        $query = 'SELECT name FROM upload_category WHERE name = :name ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);

        $stmt->execute();

        return $stmt->rowCount()>0;
    }

    public function pastDeadline($id):bool
    {
        $today = date('Y-m-d');
        $deadline = strtotime($this->viewCategory($id)['deadline']);
        return $today > $deadline;
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