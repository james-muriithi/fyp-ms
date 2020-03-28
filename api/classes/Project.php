<?php
include_once 'Student.php';

class Project extends Student
{
    /**
     * @var PDO
     */
    public $conn;
    /**
     * @var String
     */
    /**
     * @var String
     */
    public $title, $description;

    /**
     * Project constructor.
     * @param $conn
     */
    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->conn = $conn;
    }

    public function addProject(string $category,string $title, string $description, string $reg_no = ''):bool
    {
        $reg_no = isset($reg_no) ? $reg_no : $this->getRegNo();
        if (empty($reg_no)){
            return false;
        }

        $query = 'INSERT INTO project set title =:title, description=:desc, category =:category, student=:reg_no ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':desc', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':reg_no', $reg_no);

        return $stmt->execute();
    }

    public function projectExists($id):bool
    {
        $query = 'SELECT title FROM project WHERE id = :id ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->rowCount()>0;
    }

    public function projectTitleExists($title = ''):bool
    {
        $title = !isset($this->title) ? $title :$this->title;

        $query = 'SELECT title FROM project WHERE title = :title ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $title);

        $stmt->execute();

        return $stmt->rowCount()>0;
    }

    public function studentHasProject($reg_no = '')
    {
        $reg_no = empty($this->getRegNo()) ? $reg_no :$this->getRegNo();
        if (empty($reg_no)){
            return false;
        }

        $query = 'SELECT title FROM project WHERE student = :reg ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':reg', $reg_no);

        $stmt->execute();

        return $stmt->rowCount()>0;
    }


    public function viewProject($reg_no):mixed
    {
        $query = 'SELECT 
                        s.reg_no,p.id, p.title, p.description, pc.name as category
                    FROM 
                         project p 
                    LEFT JOIN project_categories pc on p.category = pc.id
                    LEFT JOIN student s on p.student = s.reg_no
                    WHERE student = :reg ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':reg', $reg_no);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewAllProjects():array
    {
        $query = 'SELECT 
                        p.id, 
                        p.title,
                        p.description,
                        ifnull(nou.no_of_uploads, 0) as no_of_uploads,
                        CASE
                            WHEN p.status = 0 THEN "in progress"
                            WHEN p.status = 1 THEN "complete"
                            WHEN p.status = 0 THEN "rejected"
                        END AS status,
                        pc.name as category,
                        s.full_name,
                        s.course,
                        s.reg_no
                    FROM 
                         project p 
                    LEFT JOIN project_categories pc on p.category = pc.id
                    LEFT JOIN student s on p.student = s.reg_no
                    LEFT JOIN (SELECT project_id,COUNT(*) no_of_uploads FROM upload GROUP BY project_id) as nou
                    ON nou.project_id = p.id';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewProjectUploads($reg_no):mixed
    {
        $projectDetails = $this->viewProject($reg_no);

        $query = 'SELECT 
                        u.id, u.name, uc.name, u.upload_time, uc.deadline
                    FROM 
                         upload u 

                    LEFT JOIN upload_category uc on u.id = uc.id
                    WHERE u.project_id = :project_id ';

        $stmt = $this->conn->prepare($query);

        $project_id = $projectDetails[0]['id'];

        $stmt->bindParam(':project_id', $project_id);

        $stmt->execute();

        $projectDetails['uploads'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $projectDetails;
    }


    public function editProject($reg_no, $category, $title , $description):bool
    {
        $query = 'UPDATE project SET 
                        title = :title, category = :category, description = :description 
                    WHERE student =:regno';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':desc', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':reg_no', $reg_no);

        return $stmt->execute();
    }

}