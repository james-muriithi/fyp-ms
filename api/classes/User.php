<?php
include_once 'UserInterface.php';

class User implements UserInterface
{

    /**
     * @var PDO
     */
    public $conn;
    private $username, $password,$token;

    /**
     * @return string
     */
    public function getToken() :string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return string
     * @throws Exception
     */
    private function generateToken():string
    {
        return bin2hex(random_bytes(32));
    }



    /**
     * @return bool
     */
    public function verifyUser() :bool
    {
        if (isset($this->username)) {
            return $this->userExists($this->username) && password_verify($this->password, $this->getDbPass());
        }
        return false;
    }

    /**
     * @return array
     */
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

        $stmt->bindParam(':empid', $this->username);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return string
     */
    public function getDbToken() : string
{
    $username = strval($this->getUserName());

    $query = 'SELECT token FROM user WHERE username = :username';

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':username', $username);

    $stmt->execute();

    return @$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

    /**
     * @param String $username
     * @return bool
     */
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
        $stmt->bindParam(':username', $this->username);

        // execute the query
        $stmt->execute();

        // return
        return strval($stmt->fetchAll(PDO::FETCH_ASSOC)[0]['password']);

    }

    /**
     * @return string
     */
    public function getUsername() :string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword() :string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function verifyToken() :bool
    {
        $query = 'SELECT token FROM user WHERE token = :token';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':token', $this->token);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}