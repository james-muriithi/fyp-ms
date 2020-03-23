<?php
include_once 'User.php';

class Student extends User
{

    /**
     * @param String $email
     * @return bool
     */
    public function emailExists(String $email) : bool
    {
        //sql query
        $query = 'SELECT * FROM student WHERE email = :email';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind the values
        $stmt->bindParam(':email', $email);

        // execute the query
        $stmt->execute();

        // return
        return $stmt->rowCount() > 0;
    }

    /**
     * @param String $reg_no
     * @return bool
     */
    public function regExists(String $reg_no) : bool
    {
        //sql query
        $query = 'SELECT full_name FROM student WHERE reg_no = :reg_no';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind the values
        $stmt->bindParam(':reg_no', $reg_no);

        // execute the query
        $stmt->execute();

        // return
        return $stmt->rowCount() > 0;
    }


    /**
     * @param $reg_no string
     * @param $full_name string
     * @param $email string
     * @param $phone_no string
     * @return bool
     *
     */
    public function saveUser($reg_no, $full_name, $email, $phone_no):bool
    {
        $query = 'INSERT INTO 
                        student
                    SET
                        reg_no = :reg_no,
                        full_name = :full_name,
                        email = :email,
                        phone_no = :phone_no';

        // prepare the query
        $stmt = $this->conn->prepare($query);


        $stmt->bindParam(':reg_no', $reg_no);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_no', $phone_no);

        return $stmt->execute();
    }


    /**
     * @return array
     */
    public function getUser():array
    {
        $query = 'SELECT
                    s.reg_no,
                    s.full_name,
                    s.email,
                    s.phone_no,
                    s.school,
                    s.department,
                    s.course,
                    s.profile,
                    s.created_at
                FROM
                    student s 
                WHERE
                    reg_no = :reg_no';

        // prepare the query
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':reg_no', $this->username);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    public function getAllUsers():array
    {
        $query = 'SELECT
                    student.*,
                    CONCAT("pid-",p.id) as project_id,
                    p.title,
                    p.description,
                    pc.name as category,
                    l.full_name AS supervisor,
                    ifnull(nou.no_of_uploads,0) as no_of_uploads,
                    p.approved
                FROM
                    student 
                LEFT JOIN project p on student.reg_no = p.student
                LEFT JOIN project_categories pc on p.category = pc.id
                LEFT JOIN lecturer l on p.supervisor = l.emp_id
                LEFT JOIN (SELECT project_id,COUNT(*) no_of_uploads FROM upload GROUP BY project_id) as nou
                ON nou.project_id = p.id
                ORDER BY 1
                ';

        // prepare the query
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return String
     */
    public function getRegNo():string
    {
        return $this->username;
    }

    /**
     * @param String $regNo
     */
    public function setRegNo($regNo):void
    {
        $this->username = $regNo;
    }
}