-- Adminer 4.8.1 MySQL 10.4.25-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `charging_points`;
CREATE TABLE `charging_points` (
  `idcharging_points` int(11) NOT NULL AUTO_INCREMENT,
  `CP_IdStations` int(11) NOT NULL,
  `CP_Name` varchar(100) NOT NULL,
  `CP_InUse` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idcharging_points`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `charging_points`;
INSERT INTO `charging_points` (`idcharging_points`, `CP_IdStations`, `CP_Name`, `CP_InUse`) VALUES
(1,	1,	'S1',	0),
(2,	1,	'S2',	0),
(3,	2,	'A1',	0),
(4,	2,	'A2',	0),
(6,	3,	'Is1',	0);

DROP TABLE IF EXISTS `charging_trnxs`;
CREATE TABLE `charging_trnxs` (
  `idcharging_trnxs` int(11) NOT NULL AUTO_INCREMENT,
  `ct_IdCustomers` int(11) NOT NULL,
  `ct_VType` int(11) DEFAULT 1,
  `ct_id_evstation` int(11) NOT NULL,
  `ct_date` date NOT NULL,
  `ct_idrate` int(11) NOT NULL,
  `ct_hours` float NOT NULL,
  `ct_amount` int(11) NOT NULL,
  `ct_paymode` int(11) NOT NULL,
  PRIMARY KEY (`idcharging_trnxs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `charging_trnxs`;
INSERT INTO `charging_trnxs` (`idcharging_trnxs`, `ct_IdCustomers`, `ct_VType`, `ct_id_evstation`, `ct_date`, `ct_idrate`, `ct_hours`, `ct_amount`, `ct_paymode`) VALUES
(1,	2,	1,	1,	'2023-05-12',	2,	1,	90,	1),
(2,	1,	1,	1,	'2023-05-12',	1,	1,	50,	3),
(3,	2,	1,	1,	'2023-05-12',	2,	2,	90,	3),
(4,	2,	1,	1,	'2023-05-12',	1,	1,	50,	1),
(5,	2,	1,	1,	'2023-05-12',	1,	1,	50,	1),
(6,	1,	1,	1,	'2023-05-12',	2,	2,	90,	1),
(7,	1,	1,	2,	'2023-05-13',	1,	1,	50,	1),
(8,	2,	1,	2,	'2023-05-13',	1,	1,	50,	1),
(9,	2,	1,	1,	'2023-05-18',	2,	2,	90,	5),
(10,	2,	1,	1,	'2023-05-18',	1,	1,	50,	6);

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `idcities` int(11) NOT NULL AUTO_INCREMENT,
  `CityTitle` varchar(50) NOT NULL,
  PRIMARY KEY (`idcities`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `cities`;
INSERT INTO `cities` (`idcities`, `CityTitle`) VALUES
(1,	'Sangli'),
(2,	'Kolhapur');

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

TRUNCATE `ci_sessions`;
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('1kiln1om1hob1uns6564n654odd303on',	'::1',	1684947760,	'__ci_last_regenerate|i:1684947703;'),
('20ko874v6vf4e8h2307r1nlp0u9grf6g',	'::1',	1685845467,	'__ci_last_regenerate|i:1685845467;CustPhoto|s:13:\"File required\";__ci_vars|a:1:{s:9:\"CustPhoto\";s:3:\"new\";}'),
('2tkm9sqk0udp3pseatrf1oelv81licld',	'::1',	1685540540,	'__ci_last_regenerate|i:1685540540;CustPhoto|s:13:\"File required\";__ci_vars|a:1:{s:9:\"CustPhoto\";s:3:\"new\";}'),
('5rdabhk9d17muc5ggniu8sa2q31b8fbj',	'::1',	1685468666,	'__ci_last_regenerate|i:1685468666;'),
('79urp5m69duot9992uk9ig3s0slpq73n',	'::1',	1685839123,	'__ci_last_regenerate|i:1685839123;'),
('7lpp2cnu6jf1kh3gto6uip030ltkai4k',	'::1',	1684946688,	'__ci_last_regenerate|i:1684946688;'),
('885hs8q61mt66o8103jmbs0mneocn3d0',	'::1',	1685542334,	'__ci_last_regenerate|i:1685542323;CustPhoto|s:13:\"File required\";__ci_vars|a:1:{s:9:\"CustPhoto\";s:3:\"new\";}'),
('a54jkoq90jt7p8h9sjg927c0ttsaltl0',	'::1',	1685802497,	'__ci_last_regenerate|i:1685802497;'),
('aj1hoqdsjvl7sqadv8hqkkean8efgmel',	'::1',	1685469765,	'__ci_last_regenerate|i:1685469672;CustPhoto|s:13:\"File required\";__ci_vars|a:1:{s:9:\"CustPhoto\";s:3:\"new\";}'),
('arqbn2nb8iie36ntmk2nc67gtiign995',	'::1',	1684946991,	'__ci_last_regenerate|i:1684946991;'),
('bbu9m8jav0tl6t6i3luuro69fs8g52k1',	'::1',	1685541912,	'__ci_last_regenerate|i:1685541912;CustPhoto|s:13:\"File required\";__ci_vars|a:1:{s:9:\"CustPhoto\";s:3:\"new\";}'),
('dbu1ovnhlq0dtkum8gq8mr8u5bgsl9ev',	'::1',	1685933015,	'__ci_last_regenerate|i:1685933015;authid|s:1:\"1\";auth_idev|s:1:\"1\";authname|s:5:\"Admin\";'),
('e7rrhefltd8qgem6vji7mq2t715ke52d',	'::1',	1685894221,	'__ci_last_regenerate|i:1685894172;authid|s:1:\"1\";auth_idev|s:1:\"1\";authname|s:5:\"Admin\";'),
('evjr6a6t8e96rpn7c3k5ggrrh9bqdfob',	'::1',	1685935502,	'__ci_last_regenerate|i:1685935228;uid|s:1:\"1\";uname|s:12:\"Rahul Sharma\";'),
('h53r9uan96g9j3upd00m3hku252uj3kq',	'::1',	1685838789,	'__ci_last_regenerate|i:1685838789;alertDmessage|s:28:\"Invalid Username or password\";__ci_vars|a:2:{s:13:\"alertDmessage\";s:3:\"old\";s:9:\"login_msg\";s:3:\"old\";}login_msg|s:82:\"<div class=\"alert alert-danger text-center\">Login Failed!! Please try again.</div>\";'),
('hm8b05e8c4lar6h8c1b04urnj0o10vvi',	'::1',	1685893532,	'__ci_last_regenerate|i:1685893532;authid|s:1:\"1\";auth_idev|s:1:\"1\";authname|s:5:\"Admin\";'),
('ifm02o8igaat2k1dlku74bh2m475friq',	'::1',	1685932684,	'__ci_last_regenerate|i:1685932684;authid|s:1:\"1\";auth_idev|s:1:\"1\";authname|s:5:\"Admin\";alert_msg|s:69:\"<div class=\"alert alert-success text-center\">Succesfully added.</div>\";__ci_vars|a:1:{s:9:\"alert_msg\";s:3:\"old\";}'),
('inhhl587lgtdeprfcqepedndfu776d51',	'::1',	1684947692,	'__ci_last_regenerate|i:1684947692;'),
('j60595dudm38anj7obi8ioqv8ud3lu94',	'::1',	1685932257,	'__ci_last_regenerate|i:1685932257;authid|s:1:\"1\";auth_idev|s:1:\"1\";authname|s:5:\"Admin\";'),
('kasatus7vc5s4h1hudnr8lquialmq032',	'::1',	1685802734,	'__ci_last_regenerate|i:1685802497;CustPhoto|s:13:\"File required\";__ci_vars|a:1:{s:9:\"CustPhoto\";s:3:\"new\";}'),
('kmpp79cqfmf0qrnp862n22kvp0s8oa7m',	'::1',	1685846046,	'__ci_last_regenerate|i:1685846046;'),
('mmrih6tb3hcato547pon967jeoaaoq0f',	'::1',	1685469672,	'__ci_last_regenerate|i:1685469672;CustPhoto|s:13:\"File required\";__ci_vars|a:1:{s:9:\"CustPhoto\";s:3:\"new\";}'),
('nb3g3ge1mu89pit6q1ak1m1baiaicj9b',	'::1',	1685542323,	'__ci_last_regenerate|i:1685542323;CustPhoto|s:13:\"File required\";__ci_vars|a:1:{s:9:\"CustPhoto\";s:3:\"new\";}'),
('nbf9dhq4bib8l61ec5fphjc53c8smngp',	'::1',	1685846648,	'__ci_last_regenerate|i:1685846370;authid|s:1:\"1\";auth_idev|s:1:\"1\";authname|s:5:\"Admin\";'),
('rib6qivm4fevq0g9ulp8taqbt3lk9afe',	'::1',	1685934691,	'__ci_last_regenerate|i:1685934691;uid|s:1:\"1\";uname|s:12:\"Rahul Sharma\";'),
('t47c2nu405hes6nunmu6jkjn2cfpmjjv',	'::1',	1685469305,	'__ci_last_regenerate|i:1685469305;CustPhoto|s:13:\"File required\";__ci_vars|a:1:{s:9:\"CustPhoto\";s:3:\"new\";}'),
('trjue790a5bdn7d63bkaup3krshb0aar',	'::1',	1685894172,	'__ci_last_regenerate|i:1685894172;authid|s:1:\"1\";auth_idev|s:1:\"1\";authname|s:5:\"Admin\";'),
('tspqbie01jakp1tk94t7nrh1tmtdhca5',	'::1',	1684947296,	'__ci_last_regenerate|i:1684947296;'),
('ug829ds840aphi4iedd1escfcuk9hcon',	'::1',	1685935228,	'__ci_last_regenerate|i:1685935228;uid|s:1:\"1\";uname|s:12:\"Rahul Sharma\";'),
('vcsgsrdbupeerasehi6bs0nergnrga5b',	'::1',	1684940957,	'__ci_last_regenerate|i:1684940957;authid|s:1:\"1\";auth_idev|s:1:\"1\";authname|s:5:\"Admin\";CustPhoto|s:13:\"File required\";__ci_vars|a:1:{s:9:\"CustPhoto\";s:3:\"new\";}');

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `idcustomers` int(11) NOT NULL AUTO_INCREMENT,
  `CustName` varchar(100) NOT NULL,
  `CustPass` varchar(10) NOT NULL,
  `CustDOB` date DEFAULT NULL,
  `CustPhone` varchar(15) NOT NULL,
  `CustAddress` text NOT NULL,
  `CustBalance` int(11) DEFAULT 0,
  `CustPhoto` text DEFAULT NULL,
  PRIMARY KEY (`idcustomers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `customers`;
INSERT INTO `customers` (`idcustomers`, `CustName`, `CustPass`, `CustDOB`, `CustPhone`, `CustAddress`, `CustBalance`, `CustPhoto`) VALUES
(1,	'Rahul Sharma',	'125',	'1990-01-01',	'8788680323',	'GULMOHAR COLONY',	0,	'1684932516pro_img.jpg'),
(2,	'Harsh Sharma',	'8421310958',	'1990-01-01',	'8421310958',	'Sangli',	50,	NULL),
(3,	'New Customer',	'8080808080',	'1990-01-01',	'8080808080',	'Sangli',	50,	NULL),
(4,	'Akash Koli111',	'8989898989',	'1990-01-01',	'8989898989',	'GULMOHAR COLONY',	0,	'1684898749pro_img.jpg'),
(5,	'Test Customer',	'123',	'1991-01-01',	'8585858585',	'Sangli',	0,	'1685845611pro_img.jpg');

DROP TABLE IF EXISTS `ev_stations`;
CREATE TABLE `ev_stations` (
  `idev_stations` int(11) NOT NULL AUTO_INCREMENT,
  `StationName` varchar(200) NOT NULL,
  `StationIdCity` int(11) NOT NULL,
  `StationLat` varchar(15) DEFAULT NULL,
  `StationAddress` text DEFAULT NULL,
  `StationLong` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`idev_stations`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `ev_stations`;
INSERT INTO `ev_stations` (`idev_stations`, `StationName`, `StationIdCity`, `StationLat`, `StationAddress`, `StationLong`) VALUES
(1,	'Sangli',	1,	'16.870826704877',	'',	'74.579022736931'),
(2,	'Ashta',	1,	'16.945590009034',	'',	'74.409919032201'),
(3,	'Islampur',	0,	'',	'',	'');

DROP TABLE IF EXISTS `payment_modes`;
CREATE TABLE `payment_modes` (
  `idpayment_modes` int(11) NOT NULL AUTO_INCREMENT,
  `PayMode_Title` varchar(150) NOT NULL,
  PRIMARY KEY (`idpayment_modes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `payment_modes`;
INSERT INTO `payment_modes` (`idpayment_modes`, `PayMode_Title`) VALUES
(1,	'Customer Balance'),
(2,	'Online'),
(3,	'Cash'),
(5,	'G Pay'),
(6,	'Phone Pay');

DROP TABLE IF EXISTS `rate_chart`;
CREATE TABLE `rate_chart` (
  `idrate_chart` int(11) NOT NULL AUTO_INCREMENT,
  `rc_hours` int(11) NOT NULL,
  `rc_name` varchar(150) NOT NULL,
  `rc_amount` int(11) NOT NULL,
  PRIMARY KEY (`idrate_chart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `rate_chart`;
INSERT INTO `rate_chart` (`idrate_chart`, `rc_hours`, `rc_name`, `rc_amount`) VALUES
(1,	1,	'One Hour',	50),
(2,	2,	'Two Hour',	90),
(3,	3,	'Three Hour',	140);

DROP TABLE IF EXISTS `recharge_trnxs`;
CREATE TABLE `recharge_trnxs` (
  `idrecharge_trnxs` int(11) NOT NULL AUTO_INCREMENT,
  `crt_idcustomer` int(11) NOT NULL,
  `crt_idevstation` int(11) NOT NULL,
  `crt_amount` float NOT NULL,
  `crt_paymode` int(11) NOT NULL,
  `crt_date` date NOT NULL,
  `crt_time` time NOT NULL,
  PRIMARY KEY (`idrecharge_trnxs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `recharge_trnxs`;
INSERT INTO `recharge_trnxs` (`idrecharge_trnxs`, `crt_idcustomer`, `crt_idevstation`, `crt_amount`, `crt_paymode`, `crt_date`, `crt_time`) VALUES
(1,	2,	1,	500,	1,	'2023-05-11',	'00:00:00'),
(2,	1,	1,	100,	2,	'2023-05-12',	'00:00:00'),
(3,	2,	1,	50,	2,	'2023-05-12',	'00:00:00'),
(4,	2,	1,	50,	2,	'2023-05-12',	'00:00:00'),
(5,	1,	1,	20,	3,	'2023-05-12',	'19:58:47'),
(6,	1,	1,	500,	2,	'2023-05-12',	'20:22:44'),
(7,	2,	2,	50,	2,	'2023-05-13',	'05:36:31'),
(8,	1,	2,	20,	3,	'2023-05-13',	'05:37:17'),
(9,	3,	0,	50,	2,	'2023-05-13',	'15:37:56'),
(10,	4,	0,	100,	2,	'2023-05-18',	'08:25:45');

DROP TABLE IF EXISTS `user_auths`;
CREATE TABLE `user_auths` (
  `iduser_auths` int(11) NOT NULL,
  `UA_Name` varchar(100) NOT NULL,
  `UA_Login` varchar(50) NOT NULL,
  `US_Passkey` text NOT NULL,
  `US_Idevstation` int(11) NOT NULL,
  `US_Active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `user_auths`;
INSERT INTO `user_auths` (`iduser_auths`, `UA_Name`, `UA_Login`, `US_Passkey`, `US_Idevstation`, `US_Active`) VALUES
(1,	'Admin',	'ev1',	'123',	1,	1),
(2,	'Operator',	'ev2',	'123',	2,	1);

DROP TABLE IF EXISTS `vehicle_type`;
CREATE TABLE `vehicle_type` (
  `idvehicle_type` int(11) NOT NULL AUTO_INCREMENT,
  `VType_Name` varchar(100) NOT NULL,
  PRIMARY KEY (`idvehicle_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `vehicle_type`;
INSERT INTO `vehicle_type` (`idvehicle_type`, `VType_Name`) VALUES
(1,	'Car'),
(2,	'Jeep'),
(3,	'BUS');

-- 2023-06-05 06:10:27
