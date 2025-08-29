-- Adminer 5.2.1 MariaDB 11.7.2-MariaDB-ubu2404 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `clients` (`id`, `username`, `password`) VALUES
(1,	'sarthak',	'$2y$12$kkZXgox10ggOqiwdHe26qurm0p4rzy8djlh2VyyM4atPwPO4UFQ3q'),
(3,	'divash',	'$2y$12$QgaQbe0H80NYDrhXisQW1OhBfFJTK0Lwhe.FtyRYiwhlP8VaZq7DO'),
(14,	'flick',	'$2y$12$QawXY/XCDQBjhYbibmDFwePs0Yzwt8igGX2TjVBVxzf6XL81Ab2SO'),
(15,	'pratish',	'$2y$12$S.B3Hb0lruSUi84CV9rHiO7bzoW7Iegz1bqHyPD/nWKHRYilj1wtu')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `username` = VALUES(`username`), `password` = VALUES(`password`);

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lot_number` varchar(8) NOT NULL,
  `creator` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `date_of_creation` date NOT NULL,
  `description` longtext NOT NULL,
  `estimated_price` varchar(255) NOT NULL,
  `auction_date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `isArchived` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lot_number` (`lot_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `items` (`id`, `lot_number`, `creator`, `category`, `date_of_creation`, `description`, `estimated_price`, `auction_date`, `image`, `isArchived`) VALUES
(13,	'12345678',	'Vin Cenzo',	'Drawings',	'2018-01-08',	'The detailed black and white drawing centers on a realistic eye shedding a large tear, surrounded by swirling, organic patterns of leaves, vines, and butterflies. The intricate linework creates a sense of both delicate beauty and underlying sorrow, with textures ranging from the smooth surface of the tear to the detailed veins of the eye and the patterns on the foliage.',	'1200',	'2025-10-01',	'images/6820a5ea11577_68205e.png',	0),
(14,	'23456789',	'Chitra Chitrakar',	'Drawings',	'2020-06-09',	'This intricate black and white mandala drawing features a central Yin and Yang symbol, representing balance and duality. Surrounding it are concentric circles filled with detailed, repetitive patterns, characteristic of a mandala. The overall design creates a sense of harmony and meditative focus.',	'1000',	'2025-10-01',	'images/6820a62e14e06_681f73.png',	0),
(15,	'23235656',	'Ram Bahadur',	'Carvings',	'2004-08-18',	'This intricate carving is a traditional Newari wooden Kumari window, likely from Nepal. The dark wood is meticulously detailed with floral and geometric patterns, framing a pair of small doors that add depth and dimension to the piece. The window is set against a textured stone wall, highlighting the craftsmanship and cultural significance of the carving.',	'5000',	'2025-10-01',	'images/6820a68a97f9c_681f71.jpg',	0),
(16,	'22558800',	'Kaiju Ichi',	'Sculptures',	'2012-10-01',	'This is a depiction of Budai, often referred to as the Laughing Buddha. The figure is portrayed with a large belly, a jovial expression, and is adorned in a red and gold robe, seated on a colorful platform.',	'1800',	'2025-10-01',	'images/6820a6f79103a_681f73.jpg',	0),
(17,	'56784132',	'Car Stoph',	'Paintings',	'2020-03-03',	'This vibrant painting bursts with color, depicting a stylized tree with a thick, textured canopy of red, orange, blue, and purple hues. The artist used a splatter technique to create a dynamic and joyful effect, with colorful droplets extending onto the light gray background and reflecting on the ground beneath the tree.',	'1200',	'2025-10-01',	'images/6820a7416f659_a3e799.jpg',	0),
(18,	'78790673',	'Jonie Doe',	'Photographs',	'2022-06-14',	'This picturesque scene captures the \"Gurung Cottage\" in Ghandruk, Nepal, nestled amidst vibrant orange flowers and traditional stone architecture. In the breathtaking background, the majestic snow-capped Annapurna South Mountain rises under a partly cloudy sky, creating a stunning contrast between the cozy dwelling and the grandeur of the Himalayas.',	'2000',	'2025-10-01',	'images/6820a7abcc378_614d77.jpg',	0),
(19,	'19980234',	'Mai Dawgg',	'Photographs',	'2023-02-28',	'The duck!',	'200',	'2025-10-01',	'images/6820a7fb04df6_6820ee.png',	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `lot_number` = VALUES(`lot_number`), `creator` = VALUES(`creator`), `category` = VALUES(`category`), `date_of_creation` = VALUES(`date_of_creation`), `description` = VALUES(`description`), `estimated_price` = VALUES(`estimated_price`), `auction_date` = VALUES(`auction_date`), `image` = VALUES(`image`), `isArchived` = VALUES(`isArchived`);

-- 2025-05-12 13:03:11 UTC