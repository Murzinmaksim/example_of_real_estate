-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DELIMITER ;;

DROP PROCEDURE IF EXISTS `dnedv`;;
CREATE PROCEDURE `dnedv`(`a` INT)
BEGIN
delete from objectar 
where idob=a;
select*from objectar; 
END;;

DROP PROCEDURE IF EXISTS `ifnedv`;;
CREATE PROCEDURE `ifnedv`(`dis` BOOLEAN)
begin
    IF(dis=1) THEN
       SELECT idob, cenaob*0.9 AS cenaob FROM objectar;
    ELSE
       SELECT idob, cenaob FROM objectar;
    END IF;
  end;;

DROP PROCEDURE IF EXISTS `nedvi`;;
CREATE PROCEDURE `nedvi`()
BEGIN
  declare str VARCHAR(255) default '';
  declare x INT default 0;
  SET x = 1;

  WHILE x <= 5 DO
    SET str = CONCAT(str,x,',');
    SET x = x + 1;
  END WHILE;

  select str;
END;;

DROP PROCEDURE IF EXISTS `procnedv`;;
CREATE PROCEDURE `procnedv`(`a` INT, `b` CHAR(20), `c` CHAR(20), `d` FLOAT)
BEGIN
update objectar set nazvob=b, adrob=c, cenaob=d
where idob=a;
select*from objectar; 
END;;

DROP PROCEDURE IF EXISTS `rnedv`;;
CREATE PROCEDURE `rnedv`()
BEGIN
  DECLARE x INT;
  DECLARE str VARCHAR(255);
  SET x = 5;
  SET str = '';

  REPEAT
    SET str = CONCAT(str,x,',');
    SET x = x - 1;
    UNTIL x <= 0
  END REPEAT;

  SELECT str;
END;;

DELIMITER ;

DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `IDCL` int(11) NOT NULL,
  `FAMCL` char(15) DEFAULT NULL,
  `NAMECL` char(10) DEFAULT NULL,
  `ADCL` char(30) DEFAULT NULL,
  `DATACL` date DEFAULT NULL,
  `TELEFON` char(15) DEFAULT NULL,
  PRIMARY KEY (`IDCL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `client` (`IDCL`, `FAMCL`, `NAMECL`, `ADCL`, `DATACL`, `TELEFON`) VALUES
(1,	'Алексеева',	'Виктория',	'ул.Батальная,д.51 кв.8',	'2006-12-06',	'89965228423'),
(2,	'Осипова',	'Валериялоа',	'ул.Юбилейная,д.51, кв 5',	'2008-02-08',	'89992567889'),
(3,	'Сахаровоо',	'Владислав',	'ул.Гвардейская,д.21, кв 9',	'2001-08-07',	'88776578990'),
(4,	'Никифорова',	'Екатерина',	'ул.Рыбная,д.29, кв 7',	'2020-03-09',	'877777755324'),
(5,	'Козлова',	'Ольга',	'ул.Минусинская,д.44, кв 13',	'2000-03-13',	'899655673412'),
(6,	'Тихонов',	'Валерий',	'ул.Третьякова, д.33, кв. 10',	'1973-11-11',	'89953452345'),
(7,	'Демидова',	'Аделина',	'ул.Третьякова, д.11, кв. 11',	'2002-02-02',	'89909998877'),
(8,	'Юрченко',	'Михаил',	'ул.Зеленая, д.70, кв. 45',	'1977-07-07',	'89988799003'),
(9,	'Стрельцов',	'Александр',	'ул.Беговая, д.2, кв. 256',	'1977-11-11',	'89974454432'),
(10,	'Перова',	'Марина',	'ул.Батальная, д.67, кв. 124',	'2001-09-09',	'89995643290'),
(11,	'Бразовская',	'Екатерина',	'ул.Сельская, д.12, кв.48',	'2007-07-17',	'89969999654'),
(12,	'Плисецкий',	'Юрий',	'ул.Условная, д.11, кв.111',	'1995-12-27',	'89642441324'),
(13,	'Славенова',	'Алиса',	'ул.Яркая, д.90, кв.48',	'1994-10-05',	'89432152213'),
(14,	'Колесова',	'Евгения',	'ул.Минусинская, д.33, кв.8',	'2000-10-13',	'89945231314'),
(15,	'Корытова',	'Марина',	'ул.Чернигова, д.10, кв.56',	'1995-09-12',	'89922211657'),
(16,	'Светлакова',	'Александра',	'ул.Лесная, д.9, кв. 34',	'1973-05-21',	'89679006789'),
(17,	'Раевская',	'Валерия',	'ул.Новая, д.25, кв. 3',	'2002-02-28',	'89942345678'),
(18,	'Ковальчук',	'Андрей',	'ул.Старая, д.58, кв. 84',	'2003-07-10',	'89957689056'),
(19,	'Всеволодова',	'Вероника',	'ул.Мельникова, д.24, кв.61',	'1999-12-12',	'89545987659');

DROP TABLE IF EXISTS `dogovor`;
CREATE TABLE `dogovor` (
  `IDDOG` int(11) NOT NULL,
  `DATADOG` date DEFAULT NULL,
  `CENADOG` float NOT NULL,
  `PLOSHAD` float NOT NULL,
  `NAMESERVICE` char(15) NOT NULL,
  `IDCL` int(11) DEFAULT NULL,
  `IDOB` int(11) DEFAULT NULL,
  `IDSOTR` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDDOG`),
  KEY `IDCL` (`IDCL`),
  KEY `IDOB` (`IDOB`),
  KEY `IDSOTR` (`IDSOTR`),
  CONSTRAINT `dogovor_ibfk_1` FOREIGN KEY (`IDCL`) REFERENCES `client` (`IDCL`),
  CONSTRAINT `dogovor_ibfk_3` FOREIGN KEY (`IDOB`) REFERENCES `objectar` (`IDOB`),
  CONSTRAINT `dogovor_ibfk_4` FOREIGN KEY (`IDSOTR`) REFERENCES `sotrudnic` (`IDSOTR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `dogovor` (`IDDOG`, `DATADOG`, `CENADOG`, `PLOSHAD`, `NAMESERVICE`, `IDCL`, `IDOB`, `IDSOTR`) VALUES
(1,	'2011-11-20',	42088,	54,	'Аренда',	2,	4,	1),
(3,	'2020-02-20',	2800000,	22,	'Купля',	3,	4,	1),
(4,	'2007-02-20',	1100000,	23,	'Купля',	5,	11,	1),
(8,	'2015-04-20',	6290000,	79,	'Аренда',	5,	11,	1),
(9,	'2028-01-20',	3700000,	44,	'Аренда',	3,	6,	1),
(10,	'2018-03-20',	3100000,	31,	'Аренда',	1,	19,	1),
(11,	'2021-10-20',	2778240,	25,	'Аренда',	6,	14,	1),
(12,	'2014-07-20',	4750000,	37,	'Аренда',	7,	10,	1),
(13,	'2012-02-20',	6050000,	41,	'Аренда',	7,	9,	1),
(14,	'2007-01-20',	4100000,	36,	'Аренда',	9,	4,	1),
(15,	'2017-08-20',	4900000,	34,	'Аренда',	7,	1,	1),
(16,	'2013-09-20',	5000000,	40,	'Аренда',	8,	7,	1),
(17,	'2026-01-20',	4900000,	34,	'Аренда',	5,	1,	1),
(18,	'2018-03-20',	7600000,	58,	'Аренда',	9,	8,	1),
(19,	'2027-07-20',	5400000,	44,	'Аренда',	7,	5,	1),
(20,	'2008-08-20',	2778240,	25,	'Аренда',	5,	14,	1);

DROP TABLE IF EXISTS `objectar`;
CREATE TABLE `objectar` (
  `IDOB` int(11) NOT NULL AUTO_INCREMENT,
  `NAZVOB` char(30) DEFAULT NULL,
  `ADROB` char(30) DEFAULT NULL,
  `CENAOB` float DEFAULT NULL,
  `PLOSHAD` float NOT NULL,
  `IDCL` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDOB`),
  KEY `IDCL` (`IDCL`),
  CONSTRAINT `objectar_ibfk_3` FOREIGN KEY (`IDCL`) REFERENCES `client` (`IDCL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `objectar` (`IDOB`, `NAZVOB`, `ADROB`, `CENAOB`, `PLOSHAD`, `IDCL`) VALUES
(1,	'Магазин1чывы',	'ул.Черепная,д.22',	480000000,	34,	1),
(2,	'Гараж',	'ул.Черняховского,д.7',	4900000,	35,	2),
(4,	'1-комнатная квартира',	'ул.Олега Кошевого,д.2',	2700000,	22,	4),
(5,	'Гараж',	'ул.Черняховского,д.7',	4200000,	44,	5),
(6,	'2-х комнатная квартира',	'ул.Тростникова, д.4',	3600000,	44,	6),
(7,	'Магазин',	'ул.Кирова,д.90',	4900000,	400,	7),
(8,	'Магазин \"Мир\"',	'ул.Земская,д.18',	5800000,	63,	8),
(9,	'Магазин \"Центр\"',	'ул.Багратиона,д.5',	3300000,	43,	9),
(10,	'Участок под стоянку',	'ул.Сказочная,д.65',	4600000,	37,	10),
(11,	'Продуктовый магазин',	'ул.Стекольная,д.7',	1000000,	23,	2),
(12,	'4-комнатная квартира',	'ул.Московская,д.9',	8700000,	101,	2),
(13,	'3- комнатная квартира',	'ул.Батальная,д.10',	7000000,	80,	2),
(14,	'Склад для хранения овощей',	'ул.Лиговая,д.18',	2600000,	25,	2),
(15,	'5-комнатная квартира',	'ул.Челнокова,д.27',	9000000,	115,	2),
(16,	'Гараж № 4',	'ул.Огарная,д.68',	1550000,	21,	2),
(17,	'Магазин \"Виктория\"',	'ул.Карамзина,д.34',	4600000,	40,	2),
(18,	'Гараж № 12',	'ул.Светлая,д.21',	7900000,	70,	2),
(19,	'Салон красоты \"Свет\"',	'ул.Красная,д.44',	6700000,	56,	2),
(20,	'Салон красоты \"Красота\"',	'ул.Ленинская,д.6',	4000000,	37,	2),
(21,	'2- комнатная квартира',	'ул.Куйбышева,д.11',	1600000,	22,	2),
(22,	'1-комнатная квартира',	'ул.Чувашская,д,51',	1100000,	20,	2),
(23,	'Гараж № 15',	'ул.Орудийная,д.45',	2500000,	23,	2),
(24,	'Склад дя морепродуктов',	'ул.Полецкого,д.11',	1400000,	18,	2),
(25,	'Склад № 11',	'ул.Чекистов,д.18',	2000000,	24,	2),
(26,	'1 комнатная квартира',	'ул.Театральная,д.22',	1000000,	20,	2),
(27,	'Магазин \"Континент\"',	'ул.Картаева,д.9',	5600000,	44,	2),
(28,	'Участок под стоянку № 20',	'ул.Макаренко,д.16',	1900000,	27,	2),
(29,	'Склад для запчастей',	'ул.Урицкого,д.27',	2400000,	32,	2),
(30,	'Гараж',	'ул.Черепная,д.2',	4800000,	34,	2),
(31,	'Магазин \"Spar1\"',	'ул.Черепная,д.2',	4800000,	12,	2);

DROP TABLE IF EXISTS `sotrudnic`;
CREATE TABLE `sotrudnic` (
  `IDSOTR` int(11) NOT NULL DEFAULT '0',
  `FAMSOTR` char(15) DEFAULT NULL,
  `NAMESOTR` char(10) DEFAULT NULL,
  `DATASOTR` date DEFAULT NULL,
  `ADSOTR` char(30) DEFAULT NULL,
  `DOLSOTR` char(15) DEFAULT NULL,
  PRIMARY KEY (`IDSOTR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sotrudnic` (`IDSOTR`, `FAMSOTR`, `NAMESOTR`, `DATASOTR`, `ADSOTR`, `DOLSOTR`) VALUES
(1,	'Фёдороввцу',	'Михаилвыв',	'2002-01-23',	'ул.Октябрьская,д.20',	'Менеджер'),
(2,	'Михалков',	'Федор',	'1990-07-11',	'ул.Красноармейская,д.11',	'Менеджер'),
(4,	'Светлов',	'Марк',	'1980-12-03',	'ул.Береговая,д.3',	'Менеджер'),
(5,	'Кувшинова',	'Мария',	'2003-07-04',	'ул.Малинникова,д.5',	'Менеджер'),
(6,	'Миронова',	'Алиса',	'1992-11-11',	'ул.Калинина,д.2',	'Менеджер'),
(7,	'Маликов',	'Вячеслав',	'1997-09-24',	'ул.Блокадная,д.14',	'Менеджер'),
(8,	'Петров',	'Дмитрий',	'1992-12-13',	'ул.Заливная,д.78',	'Менеджер'),
(9,	'Зарьков',	'Анатолий',	'1998-02-02',	'ул.Морская,д.27',	'Менеджер'),
(10,	'Власова',	'Ольга',	'1980-06-26',	'ул.Мореходная,д.19',	'Менеджер'),
(11,	'Светлова',	'Олеся',	'1992-10-26',	'ул.Хмельницкого,д.13',	'Менеджер'),
(12,	'Кирова',	'Альбина',	'1982-01-02',	'ул.Озерная,д.89',	'Менеджер'),
(13,	'Толстова',	'Анна',	'1994-04-13',	'ул.Высокая,д.11',	'Менеджер'),
(14,	'Норкова',	'Виктория',	'1993-03-15',	'ул.Багратиона,д.12',	'Менеджер'),
(15,	'Новиков',	'Ян',	'1997-12-20',	'ул.Горького,д.26',	'Менеджер'),
(16,	'Тихонов',	'Антон',	'1987-08-09',	'ул.Светлая,д.23',	'Менеджер'),
(17,	'Васько',	'Алексей',	'1997-04-05',	'ул.Маршала Жукова,д.29',	'Менеджер'),
(18,	'Котусова',	'Елизавета',	'1996-12-10',	'ул.Василькова,д.25',	'Менеджер'),
(19,	'Кафков',	'Павел',	'1993-11-11',	'ул.Кировская,д.26',	'Менеджер'),
(20,	'Юрков',	'Владимир',	'1992-09-10',	'ул.Невского,д.22',	'Менеджер');

-- 2023-01-27 15:53:50
