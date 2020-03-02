<?php
include_once 'UserInterface.php';

class Student implements UserInterface
{
    private $email, $userName, $password;

    /**
     * @var PDO
     */
    public $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return bool
     */
    public function verifyUser() :bool
    {
        if (isset($this->userName)) {
            return $this->userExists($this->userName) && password_verify($this->password, $this->getDbPass());
        }
        return false;
    }

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
     * @param String $username
     * @return bool
     */
    public function userExists(String $username) : bool
    {
        //sql query
        $query = 'SELECT username FROM user WHERE username = :username';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind the values
        $stmt->bindParam(':username', $username);

        // execute the query
        $stmt->execute();

        // return
        return $stmt->rowCount() > 0;
    }

    public function updatePassword(string $newPass): bool
    {
        $query = 'UPDATE user SET password = :password WHERE username =: username';

        $stmt = $this->conn->prepare($query);

        $newPass = password_hash($newPass, PASSWORD_BCRYPT);

        $stmt->bindParam(':password', $newPass);
        $stmt->bindParam(':username', $this->userName);

        return $stmt->execute();
    }

    /**
     * @return String
     */
    private function getDbPass():String
    {
        $query = 'SELECT password FROM user WHERE username = :username';

        //prepare the query
        $stmt = $this->conn->prepare($query);


        //bind the values
        $stmt->bindParam(':username', $this->userName);

        // execute the query
        $stmt->execute();

        // return
        return strval($stmt->fetchAll(PDO::FETCH_ASSOC)[0]['password']);

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

    public function signUp($password):array
    {
        $password = password_hash($password,PASSWORD_BCRYPT);
        $token = $this->generateToken();

        $query = 'UPDATE user SET password = :pass, token = :token';

       $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':pass', $password);
        $stmt->bindParam(':token', $token);
        if ($stmt->execute()){
            return array('token'=>$token);
        }
        return array('token'=>'');
    }


    /**
     * @return String
     * @throws Exception
     */
    private function generateToken():String
    {
        return bin2hex(random_bytes(32));
    }

    /*
     * Get User Details
     * */
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

        $stmt->bindParam(':reg_no', $this->userName);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getToken(){
        $reg_no = strval($this->getRegNo());

        $query = 'SELECT token FROM user WHERE username = :reg_no';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':reg_no', $reg_no);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }
    /**
     * @return String
     */
    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * @param String $email
     */
    public function setEmail($email):void
    {
        $this->email = $email;
    }

    /**
     * @return String
     */
    public function getRegNo():string
    {
        return $this->userName;
    }

    /**
     * @param String $regNo
     */
    public function setRegNo($regNo):void
    {
        $this->userName = $regNo;
    }

    /**
     * @return String
     */
    public function getPassword():string
    {
        return $this->password;
    }

    /**
     * @param String $password
     */
    public function setPassword($password):void
    {
        $this->password = $password;
    }
}