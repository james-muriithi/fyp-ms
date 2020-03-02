<?php


class Lecturer implements UserInterface
{
    /**
     * @var PDO
     */
    public $conn;
    private $email, $userName, $password;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function verifyUser()
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
        $query = 'SELECT * FROM lecturer WHERE email = :email';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind the values
        $stmt->bindParam(':name', $email);

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

    public function userExists(String $username) :bool
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
                    l.created_at
                FROM
                    lecturer l
                LEFT JOIN user on user.username = l.emp_id
                WHERE
                    l.emp_id = :empid';

        // prepare the query
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':empid', $this->userName);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getToken() : string
    {
        $username = strval($this->getUserName());

        $query = 'SELECT token FROM user WHERE username = :username';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $username);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    /**
     * @param $empId string
     * @param $full_name string
     * @param $email string
     * @param $phone_no string
     * @param $expertise string
     * @throws Exception PDOException
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
        $stmt->bindParam(':emp_id', $reg_no);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':phone_no', $phone_no);
        $stmt->bindParam(':expertise', $expertise);


        return $stmt->execute();
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
     * @return string
     */
    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUserName():string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getPassword():string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}