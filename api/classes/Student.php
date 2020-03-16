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
        $stmt->bindParam(':name', $email);

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
        $query = 'SELECT * FROM student WHERE reg_no = :reg_no';

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
     * @param $reg_no
     * @param $full_name
     * @param $email
     * @param $phone_no
     * @return bool
     * @throws Exception
     */
    public function saveUser($reg_no, $full_name, $email, $phone_no):bool
    {
        $query = 'INSERT INTO `student`(
                    `reg_no`,
                    `full_name`,
                    `email`,
                    `phone_no`
                )
                VALUES(
                       :reg_no,
                       :full_name,
                       :email,
                       :phone_no
                )';

        // prepare the query
        $stmt = $this->conn->prepare($query);


        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':reg_no', $reg_no);
        $stmt->bindParam(':full_name', $full_name);
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