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
     * @var string
     */
    private $pid;


    /**
     * Project constructor.
     * @param $conn
     */
    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->conn = $conn;
    }

    public function addProject(string $title, string $description,string $category, string $reg_no = ''):bool
    {
        $reg_no = !empty($reg_no) ? $reg_no : $this->getRegNo();
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
        $title = !empty($this->title) ? $title :$this->title;

        $query = 'SELECT title FROM project WHERE title = :title ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $title);

        $stmt->execute();

        return $stmt->rowCount()>0;
    }

    public function studentHasProject($reg_no = ''): bool
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


    public function viewProject($pid = ''):array
    {
        $pid = !empty($pid) ? pid : $this->pid;
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
                    ON nou.project_id = p.id
                    WHERE p.id  = :pid ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':pid', $pid);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }


    public function viewStudentProject($reg_no = ''):array
    {
        $reg_no = !empty($reg_no) ? $reg_no : $this->getRegNo();
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
                    ON nou.project_id = p.id
                    WHERE student = :reg ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':reg', $reg_no);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
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

        $stmt = $this->conn->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewProjectUploads($reg_no):array
    {
        $projectDetails = $this->viewStudentProject($reg_no);

        $query = 'SELECT 
                        u.id, u.name, uc.name, u.upload_time, uc.deadline
                    FROM 
                         upload u 

                    LEFT JOIN upload_category uc on u.id = uc.id
                    WHERE u.project_id = :project_id ';

        $stmt = $this->conn->prepare($query);

        $project_id = $projectDetails['id'];

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


    /**
     * @return string
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param string $pid
     */
    public function setPid($pid): void
    {
        $this->pid = $pid;
    }

}