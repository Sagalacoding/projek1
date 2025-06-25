<?php
require_once __DIR__ . '/../../config/database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function isEmailExists($email)
    {
        $where = ['email' => $email];
        $result = $this->db->select('users', $where);
        return !empty($result);
    }

    public function register($email, $fullname, $password)
    {
        if ($this->isEmailExists($email)) {
            return false;
        }

        $data = [
            'email' => $email,
            'fullname' => $fullname,
            'password' => $password
        ];
        $this->db->insert('users', $data);
        return true;
    }

    public function login($email, $password)
    {
        $where = ['email' => $email];
        $result = $this->db->select('users', $where);

        if (!empty($result)) {
            $user = $result[0];
            if ($user['password'] === $password) {
                return $user;
            }
        }
        return false;
    }
}
