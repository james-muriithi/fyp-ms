<?php


interface UserInterface
{
    public function verifyUser();

    public function getUser();

    public function getToken();

    public function userExists(String $username);
}