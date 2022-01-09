<?php

require_once __DIR__ .'/vendor/autoload.php';

use Datnn\Database\MysqlConnector;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$statement = 
"CREATE TABLE IF NOT EXISTS `movie` (
    `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` varchar(300) NOT NULL,
  `year` varchar(4) NOT NULL,
  `director_name` varchar(100) NOT NULL,
  `release_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `song` (
    `id` int NOT NULL AUTO_INCREMENT,
    `title` varchar(150) NOT NULL,
    `album_name` varchar(150) NOT NULL,
    `year` varchar(4) NOT NULL,
    `artist_name` varchar(100) NOT NULL,
    `release_date` datetime NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `movie` (`title`, `description`, `year`, `director_name`,`release_date`) VALUES
('The Shawshank Redemption', 'Two imprisoned something', '1994', 'Frank Darabont', '1994-10-14 00:00:00'),
('The Godfather', 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', '1972', 'Francis Ford Coppola', '1972-03-14 00:00:00'),
('The Godfather: Part II', 'The early life and career of Vito Corleone in 1920s New York is portrayed while his son, Michael, expands and tightens his grip on the family crime syndicate.', '1974', 'Francis Ford Coppola', '1974-12-20 00:00:00'),
('The Dark Knight', 'When the menace known as the Joker emerges from his mysterious past, he wreaks havoc and chaos on the people of Gotham, the Dark Knight must accept one of the greatest psychological and physical tests of his ability to fight injustice.', '2008', 'Christopher Nolan', '2008-07-16 00:00:00');

INSERT INTO `song` (`title`, `album_name`, `year`, `artist_name`, `release_date`) VALUES
('Africa', 'Africa', '1990', 'Toto', '1972-03-14 00:00:00'),
('Master of Puppet','Master of Puppet', '1985', 'Metallica', '1993-03-14 00:00:00'),
('One', '...And Justice For All', '1988', 'Metallica', '1993-03-14 00:00:00'),
('Paranoid', 'Paranoid', '1970', 'Black Sabbath', '1993-03-14 00:00:00'),
('The Trooper', 'The Trooper', '1992', 'Iron Maiden', '1993-03-14 00:00:00'),
";
try {
    $db = new MysqlConnector();
    $db->getConnection()->exec($statement);
} catch (\PDOException $e)  {
    exit($e->getMessage());
}
    
