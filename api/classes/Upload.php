<?php


class Upload
{

    /**
     * @var PDO
     */
    public $conn;

    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    private $uid, $pid, $cid, $name;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param string $name filename of the upload
     * @param string $project_id project id
     * @param string $category_id upload category id
     * @return bool
     */
    public function addUpload($name, $project_id, $category_id): bool
    {
        $query = 'INSERT INTO upload SET 
                       name =:name, project_id =:pid, category = :cat_id';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':pid',$project_id);
        $stmt->bindParam(':cat_id',$category_id);

        return $stmt->execute();
    }


    /**
     * @param string $uid upload id
     * @param string $pid new project id
     * @param string $cat_id new category id
     * @return bool
     */
    public function editUpload($uid, $pid, $cat_id):bool
    {
        $query = 'UPDATE upload SET project_id=:pid, category=:cid WHERE id=:uid';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':uid',$uid);
        $stmt->bindParam(':pid',$pid);
        $stmt->bindParam(':cid',$cat_id);

        return $stmt->execute();
    }

    /**
     * @param string $uid upload id
     * @return bool
     */
    public function deleteUpload($uid): bool
    {
        $query = 'DELETE FROM upload WHERE id=:uid';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':uid',$uid);

        return $stmt->execute();
    }

    /**
     * @return array
     */
    public function viewAllUploads():array
    {
        $query = 'SELECT 
                    u.id, u.name, approved, upload_time,
                    s.reg_no,
                    s.full_name,
                    p.title as project,
                    uc.name as category,
                    uc.id as category_id,
                    uc.deadline
                    FROM upload u
                    LEFT JOIN upload_category uc on u.id = uc.id
                    LEFT JOIN project p on u.project_id = p.id
                    LEFT JOIN (SELECT full_name,reg_no FROM student GROUP BY reg_no) as s 
                        ON s.reg_no = p.student';

        $stmt = $this->conn->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $uid upload id
     * @return array
     */
    public function viewUpload($uid):array
    {
        $query = 'SELECT 
                    u.id, u.name, approved, upload_time,
                    s.reg_no,
                    s.full_name,
                    p.title as project,
                    uc.name as category,
                    uc.deadline
                    FROM upload u
                    LEFT JOIN upload_category uc on u.id = uc.id
                    LEFT JOIN project p on u.project_id = p.id
                    LEFT JOIN (SELECT full_name,reg_no FROM student GROUP BY reg_no) as s 
                        ON s.reg_no = p.student
                     WHERE u.id =:uid';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':uid',$uid);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    /**
     * @param string $cid category id
     * @param string $pid project id
     * @return bool
     */
    public function hasUpload($pid, $cid) :bool
    {
        $query = 'SELECT 
                    u.id
                    FROM upload u
                     WHERE u.project_id =:pid
                     AND u.category =:cid';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':pid',$pid);
        $stmt->bindParam(':cid',$cid);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }


    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid(string $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getPid(): string
    {
        return $this->pid;
    }

    /**
     * @param string $pid
     */
    public function setPid(string $pid): void
    {
        $this->pid = $pid;
    }

    /**
     * @return string
     */
    public function getCid(): string
    {
        return $this->cid;
    }

    /**
     * @param string $cid
     */
    public function setCid(string $cid): void
    {
        $this->cid = $cid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}