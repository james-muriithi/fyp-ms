<?php
include_once 'User.php';

class Lecturer extends User
{
    /**
     * @param String $email
     * @return bool
     */
    public function emailExists(String $email) : bool
    {
        //sql query
        $query = 'SELECT * FROM lecturer WHERE email = :email';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind the values
        $stmt->bindParam(':email', $email);

        // execute the query
        $stmt->execute();

        // return
        return $stmt->rowCount() > 0;
    }

    public function empIdExists(string $empId) :bool
    {
        //sql query
        $query = 'SELECT * FROM lecturer WHERE emp_id = :emp_id';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind the values
        $stmt->bindParam(':emp_id', $empId);

        // execute the query
        $stmt->execute();

        // return
        return $stmt->rowCount() > 0;
    }


    public function getUser() : array
    {
        $query = 'SELECT
                    l.emp_id,
                    l.full_name,
                    l.email,
                    l.phone_no,
                    l.expertise,
                    user.level,
                    l.profile,
                    l.created_at,
                    IF(c.emp_id IS NULL, "False", "True") as coordinator
                    
                FROM
                    lecturer l
                LEFT JOIN user on user.username = l.emp_id
                LEFT JOIN coordinator c on l.emp_id = c.emp_id
                WHERE
                    l.emp_id = :empid';

        // prepare the query
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':empid', $this->username);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    public function getAllUsers():array
    {
        $query = 'SELECT
                    l.*,
                    user.level,
                    IF(c.emp_id IS NULL, "False", "True") as coordinator,
                    ifnull(nos.no_of_students, 0) as no_of_projects
                FROM
                    lecturer l
                LEFT JOIN user on user.username = l.emp_id
                LEFT JOIN coordinator c on l.emp_id = c.emp_id
                LEFT JOIN (SELECT supervisor,COUNT(*) no_of_students FROM project GROUP BY supervisor)as nos
                ON nos.supervisor = l.emp_id';

        // prepare the query
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $empId string
     * @param $full_name string
     * @param $email string
     * @param $phone_no string
     * @param $expertise string
     * @return bool
     */
    public function saveUser($empId, $full_name, $email, $phone_no, $expertise):bool
    {
        $query = 'INSERT INTO lecturer(
                    `emp_id`,
                    `full_name`,
                    `email`,
                    `phone_no`,
                     `expertise`
                )
                VALUES(
                       :emp_id,
                       :full_name,
                       :email,
                       :phone_no,
                       :expertise
                )';

        // prepare the query
        $stmt = $this->conn->prepare($query);


        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':emp_id', $empId);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':phone_no', $phone_no);
        $stmt->bindParam(':expertise', $expertise);


        return $stmt->execute();
    }

    public function updateImage($filename) :bool
    {
        $query = 'UPDATE lecturer
                  SET profile = :profile 
                  WHERE emp_id= :empid';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':profile',$filename);
        $stmt->bindParam(':empid', $this->username);

        return $stmt->execute();
    }


    public function updateUser($empid, $name, $email, $phone, $expertise) :bool
    {
        $query = 'UPDATE lecturer
                  SET full_name = :name,
                      email =:email,
                      phone_no =:phone,
                      expertise = :expertise
                  WHERE emp_id= :empid';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':expertise', $expertise);
        $stmt->bindParam(':empid', $empid);

        return $stmt->execute();
    }

    public function userExists(String $employeeId): bool
    {
        //sql query
        $query = 'SELECT emp_id FROM lecturer WHERE emp_id = :empid';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind the values
        $stmt->bindParam(':empid', $employeeId);

        // execute the query
        $stmt->execute();

        // return
        return $stmt->rowCount() > 0;
    }

}