DROP TABLE IF EXISTS `stagiaires`;
CREATE TABLE `stagiaires` (
  `identifiant` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) NOT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `stagiaires` (`identifiant`, `nom`) VALUES
(1,	'Inès'),
(2,	'Marie'),
(3,	'Yassine');