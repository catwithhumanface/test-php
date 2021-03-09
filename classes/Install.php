<?php

class Install
{
    public function __construct()
    {
        $this->dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

        $sql = "CREATE TABLE IF NOT EXISTS `blog` (
              `id_blog` int(11) NOT NULL AUTO_INCREMENT,
              `title` varchar(255) NOT NULL,
              `body` text NOT NULL,
              `link` text NOT NULL,
              `id_user` int(11) NOT NULL,
              `create_date` date NOT NULL DEFAULT current_timestamp(),
              PRIMARY KEY (`id_blog`)
            );";

        $sql .= "CREATE TABLE IF NOT EXISTS `users` (
              `id_user` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `email` varchar(255) NOT NULL,
              `password` varchar(255) NOT NULL,
              PRIMARY KEY (`id_user`)
            );";

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
    }
}