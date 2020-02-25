<?php
include_once 'UserInterface.php';

class Student implements UserInterface
{
    private $email, $regNo, $password, $token;
    public $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /*
     * Verify Student Details
     * */

    public function verifyUser() :bool
    {
        if (isset($this->regNo)) {
            return $this->verifyUserWithReg($this->regNo);
        }elseif (isset($this->email)){
            return $this->verifyUserWithEmail($this->email);
        }else{
            return false;
        }
    }

    private function verifyUserWithEmail(String $email) : bool
    {
        //sql query
        $query = 'SELECT student_id FROM student WHERE email = :email AND password = :password';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

        //bind the values
        $stmt->bindParam(':name', $email);
        $stmt->bindParam(':password', $password_hash);

        // execute the query
        $stmt->execute();

        // return
        return $stmt->rowCount() > 0;
    }

    private function verifyUserWithReg(String $reg_no) : bool
    {
        //sql query
        $query = 'SELECT student_id FROM student WHERE reg_no = :reg_no AND password = :password';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

        //bind the values
        $stmt->bindParam(':reg_no', $reg_no);
        $stmt->bindParam(':password', $password_hash);

        // execute the query
        $stmt->execute();

        // return
        return $stmt->rowCount() > 0;
    }

    public function saveUser($reg_no, $full_name, $email, $phone_no, $password, $year = '2019-2020'):bool
    {
        $query = 'INSERT INTO `student`(
                    `reg_no`,
                    `full_name`,
                    `email`,
                    `phone_no`,
                    `year_of_study`,
                    `password`,
                    `token`
                )
                VALUES(
                       :reg_no,
                       :full_name,
                       :email,
                       :phone_no,
                       :year,
                       :pass,
                       :token
                )';

        // prepare the query
        $stmt = $this->conn->prepare($query);

        $token = self::generateToken();
        $password = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':reg_no', $reg_no);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':phone_no', $phone_no);
        $stmt->bindParam(':pass', $password);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':token', $token);

        return $stmt->execute();
    }

    private function generateToken():String
    {
        return bin2hex(random_bytes(32));
    }

    /*
     * Get User Details
     * */
    public function getUser()
    {
        // TODO: Implement getUser() method.
    }

    public function getToken()
    {
        // TODO: Implement getToken() method.
    }

    /**
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return String
     */
    public function getRegNo()
    {
        return $this->regNo;
    }

    /**
     * @param String $regNo
     */
    public function setRegNo($regNo)
    {
        $this->regNo = $regNo;
    }

    /**
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param String $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}