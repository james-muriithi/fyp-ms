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

    public function getUser()
    {
        // TODO: Implement getUser() method.
    }

    public function getToken()
    {
        // TODO: Implement getToken() method.
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