CREATE DATABASE IF NOT EXISTS `bob-vance`;

CREATE TABLE IF NOT EXISTS `coolkasten` (
    id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `naam` VARCHAR(255) NOT NULL,
    `euro` DECIMAL(5,2),
    `energieklasse` VARCHAR(100),
    `cm` DECIMAL(5,2),
    `img` VARCHAR(255) NOT NULL
);

INSERT INTO `coolkasten` (`naam`, `euro`, `energieklasse`, `cm`, `img`) VALUES ("Samsung-RB34T605CB1", 550.55, "C", 185.3, "koelkast-in-space.png");
