<?php


interface UserInterface
{
    public function verifyUser();

    public function getUser();

    public function verifyToken();

    public function userExists(String $username);
}