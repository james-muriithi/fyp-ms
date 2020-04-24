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

    public function addProject(string $title, string $description,string $category, string $reg_no = '', string $empId= null):bool
    {
        $empId = empty($empId) ? null : $empId;
        $reg_no = !empty($reg_no) ? $reg_no : $this->getUsername();
        if (empty($reg_no)){
            return false;
        }

        $query = 'INSERT INTO project set title =:title, description=:desc, category =:category, student=:reg_no, supervisor=:supervisor ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':desc', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':reg_no', $reg_no);
        $stmt->bindParam(':supervisor', $empId);

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

    public function projectTitleExists($title = '', $category = ''):bool
    {
        $title = empty($this->title) ? $title :$this->title;

        $query = 'SELECT title FROM project WHERE title like :title AND category= :cat';

        $stmt = $this->conn->prepare($query);

        $title = '%'.$title.'%';

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':cat', $category);

        $stmt->execute();

        return $stmt->rowCount()>0;
    }

    public function studentHasProject($reg_no = ''): bool
    {
        $reg_no = empty(!$reg_no) ? $reg_no :$this->getUsername();
        if (empty($reg_no)){
            return false;
        }

        $query = 'SELECT title FROM project WHERE student = :reg AND status!=2';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':reg', $reg_no);

        $stmt->execute();

        return $stmt->rowCount()>0;
    }

    public function getLecturerProjects($empid):array
    {
        $query = 'SELECT 
                        p.id, 
                        p.title,
                        p.description,
                        ifnull(lecturer.full_name, "") as supervisor,
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
                    LEFT JOIN lecturer ON p.supervisor = lecturer.emp_id
                    LEFT JOIN (SELECT project_id,COUNT(*) no_of_uploads FROM upload GROUP BY project_id) as nou
                    ON nou.project_id = p.id
                    WHERE p.supervisor  = :supervisor ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':supervisor', $empid);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewProject($pid = ''):array
    {
        $pid = !empty($pid) ? $pid : $this->pid;
        $query = 'SELECT 
                        p.id, 
                        p.title,
                        p.description,
                        ifnull(lecturer.full_name, "") as supervisor,
                        ifnull(lecturer.emp_id, "") as emp_id,
                        ifnull(nou.no_of_uploads, 0) as no_of_uploads,
                        CASE
                            WHEN p.status = 0 THEN "in progress"
                            WHEN p.status = 1 THEN "complete"
                            WHEN p.status = 0 THEN "rejected"
                        END AS status,
                        pc.name as category,
                        pc.id as cat_id,
                        s.full_name,
                        s.course,
                        s.reg_no
                    FROM 
                         project p 
                    LEFT JOIN project_categories pc on p.category = pc.id
                    LEFT JOIN student s on p.student = s.reg_no
                    LEFT JOIN lecturer ON p.supervisor = lecturer.emp_id
                    LEFT JOIN (SELECT project_id,COUNT(*) no_of_uploads FROM upload GROUP BY project_id) as nou
                    ON nou.project_id = p.id
                    WHERE p.id  = :pid';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':pid', $pid);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }


    public function viewStudentProject($reg_no = ''):array
    {
        $reg_no = !empty($reg_no) ? $reg_no : $this->getUsername();
        $query = 'SELECT 
                        p.id, 
                        p.title,
                        p.description,
                        ifnull(lecturer.full_name, "") as supervisor,
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
                    LEFT JOIN lecturer ON p.supervisor = lecturer.emp_id
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
                        ifnull(lecturer.full_name, "") as supervisor,
                        ifnull(lecturer.emp_id, "") as emp_id,
                        ifnull(nou.no_of_uploads, 0) as no_of_uploads,
                        CASE
                            WHEN p.status = 0 THEN "in progress"
                            WHEN p.status = 1 THEN "complete"
                            WHEN p.status = 2 THEN "rejected"
                        END AS status,
                        pc.name as category,
                        s.full_name,
                        s.course,
                        s.reg_no
                    FROM 
                         project p 
                    LEFT JOIN project_categories pc on p.category = pc.id
                    LEFT JOIN student s on p.student = s.reg_no
                    LEFT JOIN lecturer ON p.supervisor = lecturer.emp_id
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


    public function editProject($pid, $category, $title , $description):bool
    {
        $query = 'UPDATE project SET 
                        title = :title, category = :category, description = :description 
                    WHERE id = :pid';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':pid', $pid);

        return $stmt->execute();
    }

    public function deleteProject($pid):bool
    {
        $query = 'DELETE FROM project WHERE id= :pid';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':pid', $pid);

        return $stmt->execute();
    }

    public function setSupervisor($empId, $pid):bool
    {
        $query = 'UPDATE project SET 
                        supervisor = :supervisor 
                    WHERE id =:pid';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':supervisor', $empId);
        $stmt->bindParam(':pid', $pid);

        return $stmt->execute();
    }

    public function isAssigned($pid):bool
    {
        $query = 'SELECT title FROM project
                    WHERE id =:pid and supervisor is not null';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':pid', $pid);

        $stmt->execute();

        return $stmt->rowCount() >0;
    }

    public function isAssignedToMe($pid ,$empId):bool
    {
        $query = 'SELECT title FROM project
                    WHERE id =:pid and supervisor is not null and supervisor = :empid ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':empid', $empId);

        $stmt->execute();

        return $stmt->rowCount() >0;
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