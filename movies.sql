CREATE DATABASE movie;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON movie.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE movie;

CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `release_date` date NOT NULL,
  `length` int(4) NOT NULL,
  `poster` varchar(100),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


INSERT INTO `movies` (`id`, `name`, `release_date`, `length`, `poster`) VALUES
(1, 'Kill Bill', '2003-09-29', 111, 'kill_bill.jpeg'),
(2, 'Mulholland Drive', '2001-05-16', 147, 'mulholland_drive.jpeg'),
(3, 'The Godfather', '1972-03-14', 175, 'the_godfather.jpeg');
