-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 06, 2015 at 12:14 PM
-- Server version: 5.5.42-37.1-log
-- PHP Version: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `foodandm_foodandmenu`
--

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_menu_subcategory`
--

DROP TABLE IF EXISTS `restaurant_menu_subcategory`;
CREATE TABLE IF NOT EXISTS `restaurant_menu_subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `restaurant_id` varchar(255) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `subcategory_desc` longtext NOT NULL,
  `show_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=246 ;

--
-- Dumping data for table `restaurant_menu_subcategory`
--

INSERT INTO `restaurant_menu_subcategory` (`id`, `category_id`, `restaurant_id`, `subcategory_name`, `subcategory_desc`, `show_order`) VALUES
(87, 17, '1194,363,105144,105150', 'Chicken Noodle Soup (Pho)', '', 10),
(75, 17, '1194,105144,105150', 'Starters', '', 1),
(91, 9, '1194,105144,105150', 'Sushi & Sashimi', '', 13),
(77, 17, '1194,363,105144,105150', 'Vermicelli Bowls', '', 3),
(78, 17, '1194,105144,105150', 'Rice Plates', '', 4),
(79, 17, '1194,105144,105150', 'Special Dishes', '', 5),
(89, 17, '1194,105144,105150', 'Asian Cuisine', '', 11),
(81, 17, '1194,105144,105150', 'Noodle Bowls', '', 7),
(90, 9, '1194,105144,105150', 'Starters', '', 12),
(86, 17, '1194,105144,105150', 'Beef Noodle Soup (Pho)', '', 9),
(92, 9, '1194,105144,105150', 'Sushi Rolls', '', 14),
(98, 18, '1194,105144,105150', 'Beverages', '', 16),
(97, 19, '1194,105144,105150', 'Desserts', '', 15),
(99, 20, '1194,105144,105150', 'Kids Meal', '', 17),
(101, 21, '1194,105144,105150', 'Side Order', '', 18),
(102, 23, '781', 'Baked-To-Order Flat Breads', '', 19),
(103, 23, '781', 'Starters', '', 20),
(104, 23, '781', 'Salads', '', 21),
(105, 23, '781', 'American-Italian Style Dinners', '', 22),
(106, 23, '781', 'Authentic Italian Style Pasta Dinners', '', 23),
(107, 23, '781', 'Pizza', '', 24),
(127, 24, '105059', 'Fried Rice', '', 32),
(120, 24, '105059', 'Appetizers', '', 25),
(121, 24, '105059', 'Salads', '', 26),
(122, 24, '105059', 'Soups', '', 27),
(123, 24, '105059', 'Noodle Soups', '', 28),
(124, 24, '105059', 'Noodles', '', 29),
(125, 24, '105059', 'Curry', '', 30),
(126, 24, '105059', 'Stir-Fried', '', 31),
(128, 24, '105059', 'Chef''s Special', '', 33),
(129, 24, '105059', 'Vegetarian''s Specials', '', 34),
(130, 24, '105059', 'Desserts', '', 35),
(131, 24, '105059', 'Drinks', '', 36),
(132, 25, '105058', 'Appetizers', '', 37),
(133, 25, '105058', 'South Indian Specials', '', 38),
(134, 25, '105058', 'Tandoori Specials', '', 39),
(135, 25, '105058', 'Tandoori Bread / Nan', '', 40),
(136, 25, '105058', 'Vegetables', '', 41),
(137, 25, '105058', 'Chicken Entrees', '', 42),
(138, 25, '105058', 'Lamb Entrees', '', 43),
(139, 25, '105058', 'Seafood Entries', '', 44),
(140, 25, '105058', 'Asiana special platters', '', 45),
(141, 25, '105058', 'Combination Meals', '', 46),
(142, 25, '105058', 'Rice and Briyani', '', 47),
(143, 25, '105058', 'Indo Chinese Specialities', '', 48),
(144, 25, '105058', 'Desserts', '', 49),
(145, 25, '105058', 'Side Orders', '', 50),
(146, 26, '105061', 'Appetizers', '', 51),
(147, 26, '105061', 'Soups', '', 52),
(149, 26, '105061', 'Chef Special', '', 55),
(150, 26, '105061', 'Family Dinners', '', 56),
(151, 26, '105061', 'Sides', '', 57),
(152, 26, '105061', 'Beverages', '', 58),
(153, 26, '105061', 'Desserts', '', 59),
(155, 27, '105061', 'Panda Favorites', '', 60),
(156, 27, '105061', 'Chef Special', '', 61),
(157, 26, '105061', 'Panda Favorites', '', 54),
(158, 28, '105069', 'Appetizers', '', 62),
(159, 28, '105069', 'Soups', '', 63),
(160, 28, '105069', 'Kidâ€™s Menu ', '', 64),
(161, 28, '105069', 'Salads and Fruit', '', 65),
(162, 28, '105069', 'Chicken Wings ', '', 66),
(163, 28, '105069', 'Noodles and Fried Rice Bowls', '', 67),
(164, 28, '105069', 'Chef''s Specials', '', 68),
(165, 28, '105069', 'Signature Dishes', '', 69),
(166, 28, '105069', 'Desserts', '', 70),
(167, 29, '105069', 'Lunch Specials', '', 71),
(168, 30, '105127', 'Po-Boys', '', 72),
(169, 30, '105127', 'Seafood Platters', '', 73),
(170, 30, '105127', 'Combos', '', 74),
(171, 30, '105127', 'Seafood Tacos', '', 75),
(172, 30, '105127', 'Baskets', '', 76),
(173, 30, '105127', 'Side Items', '', 77),
(174, 30, '105127', 'Drinks', '', 79),
(175, 17, '1194,105144,105150', 'Salads', '', 78),
(176, 31, '105143', 'SALADS', '', 80),
(177, 31, '105143', 'SANDWICHES', '', 81),
(178, 31, '105143', 'DESSERTS', '', 82),
(179, 31, '105143', 'BREAKFAST at OPERA', '', 83),
(180, 31, '105143', 'BREAKFAST', '', 84),
(181, 31, '105143', 'HOT COFFEE', '', 85),
(182, 31, '105143', 'COLD COFFEE', '', 86),
(183, 31, '105143', 'TEA', '', 87),
(184, 31, '105143', 'HOT CHOCOLATE', '', 88),
(185, 31, '105143', 'JUICES', '', 89),
(186, 31, '105143', 'SODA', '', 90),
(187, 31, '105143', 'BOTTLED WATER', '', 91),
(188, 31, '105143', 'ICE CREAM SHAKES', '', 92),
(189, 32, '105151', 'Appetizers', '', 93),
(190, 32, '105151', 'Lunch Specials', '', 94),
(191, 32, '105151', 'Dinners', '', 95),
(192, 32, '105151', 'House Specials', '', 96),
(193, 32, '105151', 'Kids Menu', '', 97),
(194, 32, '105151', 'Dessert', '', 98),
(195, 32, '105151', 'A la Carte', '', 99),
(196, 33, '77198', 'Appetizers', '', 100),
(197, 33, '77198', 'Poboys', '', 101),
(198, 33, '77198', 'Cajun Entrees', '', 102),
(199, 33, '77198', 'Platters', '', 103),
(200, 33, '77198', 'Hot From The Pot', '', 104),
(201, 33, '77198', 'Extras', '', 105),
(202, 33, '77198', 'Salads', '', 106),
(203, 33, '77198', 'Dessert', '', 107),
(204, 33, '77198', 'Soda and Tea', '', 108),
(205, 33, '77198', 'Kids Menu', '', 109),
(206, 34, '105152', 'Appetizers', '', 110),
(207, 34, '105152', 'Seafood Appetizers', '', 111),
(208, 34, '105152', 'Don Botanas', '', 112),
(209, 34, '105152', 'Kids Menu', '', 113),
(210, 34, '105152', 'Kids Breakfast', '', 114),
(211, 34, '105152', 'Burritos', '', 115),
(212, 34, '105152', 'Soups', '', 116),
(213, 34, '105152', 'Darios Plattillos Especiales', '', 117),
(214, 34, '105152', 'Taco Plate', '', 118),
(215, 34, '105152', 'Tacos A La Carte', '', 119),
(216, 34, '105152', 'Chalupas', '', 120),
(217, 34, '105152', 'Enchiladas A La Carte', '', 121),
(218, 34, '105152', 'Steak Plates', '', 122),
(219, 34, '105152', 'Darios Seafood Platter', '', 123),
(220, 34, '105152', 'Hamburgers', '', 124),
(221, 34, '105152', 'Flacas', '', 125),
(222, 34, '105152', 'Dressing', '', 126),
(223, 34, '105152', 'Mexican Cuisine', '', 127),
(224, 34, '105152', 'Sides', '', 128),
(225, 34, '105152', 'Breakfast', '', 129),
(226, 34, '105152', 'Omelets', '', 130),
(227, 34, '105152', 'Don King Of Austin Tacos', '', 131),
(228, 34, '105152', 'Taquitos', '', 132),
(229, 34, '105152', 'Drinks', '', 133),
(230, 35, '310', 'Appetizers', '', 134),
(231, 35, '310', 'Soup', '', 135),
(232, 35, '310', 'Fried Rice', '', 136),
(233, 35, '310', 'Noodles - Pasta', '', 137),
(234, 35, '310', 'Salads', '', 138),
(235, 35, '310', 'Curry', '', 139),
(236, 35, '310', 'Thai Passion Specials', '', 140),
(237, 35, '310', 'Stir Fries', '', 141),
(238, 35, '310', 'Side Orders', '', 142),
(239, 35, '310', 'Beverages', '', 143),
(240, 36, '310', 'Testing', '', 144),
(241, 37, '1194', 'Beer', '', 145),
(242, 37, '1194', 'Wine', '', 146),
(243, 37, '1194', 'Sake', '', 147),
(244, 38, '1194', 'Lunch Specials', '', 148),
(245, 39, '1194', 'Starters', '', 149);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
