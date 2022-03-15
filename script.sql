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


CREATE TABLE articles (
    id_article INT PRIMARY KEY AUTO_INCREMENT,
    reference CHAR(10) NOT NULL,
    marque VARCHAR(200) NOT NULL,
    designation VARCHAR(200) NOT NULL,
    prix_unitaire float NOT NULL,
    qte_stock INT NOT NULL, 
    grammage INT NULL,
    couleur VARCHAR(50) NULL, 
    type CHAR(10) NOT NULL
);