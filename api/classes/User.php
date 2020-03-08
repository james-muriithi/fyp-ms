<?php
include_once 'UserInterface.php';

class User implements UserInterface
{

    /**
     * @var PDO
     */
    public $conn;
    private $username, $password,$token, $level;

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

    public function generateOTP() :array
    {
        // Create random password
         $alphabets = '0123456789';
        $count = strlen($alphabets) - 1;
        $pass = '';
        for ($i = 0; $i < 6; $i++) {
            try {
                $pass .= $alphabets[random_int(0, $count)];
            } catch (Exception $e) {
                return [
                    'otp' => ''
                ];
            }
        }

        // Database entry
        $query = 'UPDATE user SET otp = :otp WHERE username =:username';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':otp', $pass);
        $ok = $stmt->execute();

        // Result
        return [
            'otp' => $ok ? $pass : ''
        ];
    }

    public function saveToken():array
    {
        try {
            $token = $this->generateToken();
        } catch (Exception $e) {
            return array('token'=>'');
        }

        $query = 'UPDATE user SET token = :token WHERE username =:username';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':token', $token);

        if ( $stmt->execute()){
            return array('token'=> $token);
        }
        return array('token'=> $token);
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
                    *
                FROM
                    user 
                WHERE
                    username= :username';

        // prepare the query
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);

        $stmt->execute();

        return @$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
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
        if ($this->userExists($username)){
            $this->level = $this->getUser()['level'];
        }
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
        $query = 'SELECT username, level FROM user WHERE token = :token';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':token', $this->token);

        $stmt->execute();

        if ($stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->username = $row['username'];
            $this->level = $row['level'];
            return true;
        }
        return $stmt->rowCount() > 0;
    }

    /**
     * @return string
     */
    public function getLevel() :string
    {
        return $this->level;
    }

    /**
     * @param string $level
     */
    public function setLevel($level): void
    {
        $this->level = $level;
    }
}