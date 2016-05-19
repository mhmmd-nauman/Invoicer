-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2015 at 12:58 AM
-- Server version: 5.5.45-MariaDB
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `invoiced_invoiced`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE IF NOT EXISTS `application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastcron` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`id`, `lastcron`) VALUES
(1, 1439784003);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_contact` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `client_phone` varchar(255) NOT NULL,
  `client_fax` varchar(255) NOT NULL,
  `client_website` varchar(255) NOT NULL,
  `client_address` text NOT NULL,
  `client_additionalInfo` text NOT NULL,
  `client_notes` text NOT NULL,
  `client_default_currency` varchar(3) NOT NULL DEFAULT 'USD',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `user_id`, `client_name`, `client_contact`, `client_email`, `client_phone`, `client_fax`, `client_website`, `client_address`, `client_additionalInfo`, `client_notes`, `client_default_currency`) VALUES
(9, 1, 'Doe Company Limited', 'John Doe', 'john@doe.com', '0123456789', '0123456789', 'http://doe.com', 'Somewhere Street 321\r\nSomewhere Town\r\nSome Country', '<b>VAT</b>: 7898661', '', 'USD'),
(10, 1, 'Rise and Shine', 'Jasper Oakland', 'jasper@riseandshine.com', '0123456789', '0123456789', '', '', '<b>VAT</b>: 7898661', '', 'USD'),
(11, 1, 'Machine Marketing and Advertising', 'Marcus O''Brien', 'mobrien@machine.com', '0123456789', '0123456789', 'http://machine.com', 'Somewhere Street 123\r\nSomewhere Town 9090\r\nSome Country', '<b>VAT</b>: 7898661', '', 'USD'),
(12, 1, 'Drill It Now', 'Lisa Davids', 'lisa@drilldrill.com', '0123456789', '0123456789', 'http://drilldrill.com', 'Somewhere Street 123\r\nSomewhere Town 9090\r\nSome Country', '<b>VAT</b>: 7898661', '', 'USD'),
(13, 1, 'Naus Co', 'Matt Naus', 'matt@naus.com', '0123456789', '0123456789', 'http://naus.co', 'Somewhere Street 123\r\nSomewhere Town 8989\r\nSome Country', '<b>VAT</b>: 7898661', '', 'USD'),
(14, 1, 'Whoosh Advertising', 'Jamie Oliver', 'jamieoliver@whoosh.com', '0123456789', '0123456789', 'http://whoosh.com', 'Somewhere Street 123\r\nSomewhere Town 6767\r\nSome Country', '<b>VAT</b>: 7898661', '', 'USD'),
(15, 1, 'BigBird Inland Flights', 'Jona Morasa', 'jona_morasa@bigbird.com', '0123456789', '0123456789', 'http://bigbird.com', 'Somewhere Street 123\r\nSomewhere Town 7878\r\nSome Country', '<b>VAT</b>: 7898661', '', 'USD'),
(16, 1, 'Kyocera North America', 'John James', 'j_james@kyocera.com', '01234567890', '01234567890', 'http://kyocera.com', 'Somewhere Street 123\r\nSomewhere Town 6767\r\nUnited States', '<b>VAT</b>: 7898661', '', 'USD');


-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `company_phone` varchar(255) NOT NULL,
  `company_fax` varchar(255) NOT NULL,
  `company_address` text NOT NULL,
  `company_additionalinfo` text NOT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `company_name`, `company_logo`, `company_phone`, `company_fax`, `company_address`, `company_additionalinfo`) VALUES
(1, 'Chilly Orange Co., Ltd.', 'uploads/1_logo.png', '0123456789', '0123456789', '325/6 Moo 4 Soi Mooban Chadkaew\r\nTambon Kuanlang Ampher Hatyai\r\nSongkhla 90110\r\nThailand', '<b>VAT Number</b>: 123456');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `invoice_nr_counter` int(11) NOT NULL,
  `paypal_email` varchar(255) NOT NULL,
  `stripe_secret` varchar(255) NOT NULL,
  `stripe_public` varchar(255) NOT NULL,
  `api` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`config_id`, `user_id`, `invoice_nr_counter`, `paypal_email`, `stripe_secret`, `stripe_public`, `api`) VALUES
(2, 1, 102, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_shortname` varchar(20) NOT NULL,
  `currency_fullname` varchar(255) NOT NULL,
  `currency_sign` varchar(10) NOT NULL,
  PRIMARY KEY (`currency_id`),
  UNIQUE KEY `currency_shortname` (`currency_shortname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=113 ;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`currency_id`, `currency_shortname`, `currency_fullname`, `currency_sign`) VALUES
(1, 'USD', 'United States', '$'),
(2, 'EUR', 'Euro', '€'),
(3, 'GBP', 'United Kingdom', '£'),
(4, 'AUD', 'Australia', '$'),
(5, 'CNY', 'China', '¥'),
(6, 'DKK', 'Denmark', 'kr'),
(7, 'HKD', 'Hong Kong', '$'),
(8, 'INR', 'India', '₹'),
(9, 'JPY', 'Japan', '¥'),
(10, 'KRW', 'South Korea', '₩'),
(11, 'NZD', 'New Zealand', '$'),
(12, 'NOK', 'Norway', 'kr'),
(13, 'RUB', 'Russia', 'руб'),
(14, 'SGD', 'Singapore', '$'),
(15, 'ZAR', 'South Africa', 'S'),
(16, 'SEK', 'Sweden', 'kr'),
(17, 'CHF', 'Switzerland', 'CHF'),
(18, 'TWD', 'Taiwan', 'NT$'),
(19, 'THB', 'Thailand', '฿'),
(20, 'TRL', 'Turkey', '₤'),
(21, 'BRL', 'Brazil', 'R$'),
(22, 'ALL', 'Albania', 'Lek'),
(23, 'AFN', 'Afghanistan', '؋'),
(24, 'ARS', 'Argentina', '$'),
(25, 'AWG', 'Aruba', 'ƒ'),
(26, 'AZN', 'Azerbaijan', 'ман'),
(27, 'BSD', 'Bahamas', '$'),
(28, 'BBD', 'Barbados', '$'),
(29, 'BYR', 'Belarus', 'p.'),
(30, 'BZD', 'Belize', 'BZ$'),
(31, 'BMD', 'Bermuda', '$'),
(32, 'BOB', 'Bolivia', '$b'),
(33, 'BAM', 'Bosnia and Herzegovina', 'KM'),
(34, 'BWP', 'Botswana', 'P'),
(35, 'BGN', 'Bulgaria', 'лв'),
(36, 'BND', 'Brunei', '$'),
(37, 'KHR', 'Cambodia', '៛'),
(38, 'CAD', 'Canada', '$'),
(39, 'KYD', 'Cayman', '$'),
(40, 'CLP', 'Chile', '$'),
(41, 'COP', 'Colombia', '$'),
(42, 'CRC', 'Costa Rica', '₡'),
(43, 'HRK', 'Croatia', 'kn'),
(44, 'CUP', 'Cuba', '₱'),
(45, 'CZK', 'Czech Republic', 'Kč'),
(46, 'DOP', 'Dominican Republic', 'RD$'),
(47, 'XCD', 'East Caribbean', '$'),
(48, 'EGP', 'Egypt', '£'),
(49, 'SVC', 'El Salvador', '$'),
(50, 'EEK', 'Estonia', 'kr'),
(51, 'FKP', 'Falkland Islands', '£'),
(52, 'FJD', 'Fiji', '$'),
(53, 'GHC', 'Ghana', '¢'),
(54, 'GIP', 'Gibraltar', '£'),
(55, 'GTQ', 'Guatemala', 'Q'),
(56, 'GGP', 'Guernsey', '£'),
(57, 'GYD', 'Guyana', '$'),
(58, 'HNL', 'Honduras', 'L'),
(59, 'HUF', 'Hungary', 'Ft'),
(60, 'ISK', 'Iceland', 'kr'),
(61, 'IDR', 'Indonesia', 'Rp'),
(62, 'IRR', 'Iran', '﷼'),
(63, 'IMP', 'Isle Of Man', '£'),
(64, 'ILS', 'Israel', '₪'),
(65, 'JMD', 'Jamaica', '$'),
(66, 'JEP', 'Jersey', '£'),
(67, 'KZT', 'Kazakhstan', 'лв'),
(68, 'KPW', 'North Korea', '₩'),
(69, 'KGS', 'Kyrgyzstan', 'лв'),
(70, 'LAK', 'Laos', '₭'),
(71, 'LVL', 'Latvia', 'Ls'),
(72, 'LBP', 'Lebanon', '£'),
(73, 'LRD', 'Liberia', '$'),
(74, 'LTL', 'Lithuania', 'Lt'),
(75, 'MKD', 'Macedonia', 'ден'),
(76, 'MYR', 'Malaysia', 'RM'),
(77, 'MUR', 'Mauritius', 'Rs'),
(78, 'MXN', 'Mexico', '$'),
(79, 'MNT', 'Mongolia', '₮'),
(80, 'MZN', 'Mozambique', 'MT'),
(81, 'NAD', 'Namibia', '$'),
(82, 'NPR', 'Nepal', '₨'),
(83, 'ANG', 'Netherlands', 'ƒ'),
(84, 'NIO', 'Nicaragua', 'C$'),
(85, 'NGN', 'Nigeria', '₦'),
(86, 'OMR', 'Oman', '﷼'),
(87, 'PKR', 'Pakistan', '₨'),
(88, 'PAB', 'Panama', 'B/.'),
(89, 'PYG', 'Paraguay', 'Gs'),
(90, 'PEN', 'Peru', 'S/.'),
(91, 'PHP', 'Philippines', '₱'),
(92, 'PLN', 'Poland', 'zł'),
(93, 'QAR', 'Qatar', '﷼'),
(94, 'RON', 'Romania', 'lei'),
(95, 'SHP', 'Saint Helena', '£'),
(96, 'SAR', 'Saudi Arabia', '﷼'),
(97, 'RSD', 'Serbia', 'Дин.'),
(98, 'SCR', 'Seychelles', '₨'),
(99, 'SBD', 'Solomon Islands', '$'),
(100, 'SOS', 'Somalia', 'S'),
(101, 'LKR', 'Sri Lanka', '₨'),
(102, 'SRD', 'Suriname', '$'),
(103, 'SYP', 'Syria', '£'),
(104, 'TTD', 'Trinidad and Tobago', 'TT$'),
(105, 'TVD', 'Tuvalu', '$'),
(106, 'UAH', 'Ukraine', '₴'),
(107, 'UYU', 'Uruguay', '$U'),
(108, 'UZS', 'Uzbekistan', 'лв'),
(109, 'VEF', 'Venezuela', 'Bs'),
(110, 'VND', 'Vietnam', '₫'),
(111, 'YER', 'Yemen', '﷼'),
(112, 'ZWD', 'Zimbabwe', 'Z$');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');



-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `date_created`) VALUES
(2, 1, 'ccbd961a9a83ac4c1469485f074e4274', 0, 0, 0),
(3, 1, 'efd027afbe2e4b4b1b4233f5feca035d', 0, 0, 0),
(8, 1, '9c89a407789dd7acc0e50e7db1fdc5c7', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `payment_amount` decimal(11,2) NOT NULL DEFAULT '0.00',
  `payment_date` int(11) NOT NULL,
  `payment_proof` varchar(255) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `payment_active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=159 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `invoice_id`, `payment_amount`, `payment_date`, `payment_proof`, `payment_type`, `payment_active`) VALUES
(83, 1, '8050.00', 1389571200, '', 1, 1),
(84, 5, '690.00', 1391731200, '', 2, 1),
(85, 6, '2875.00', 1393545600, '', 3, 1),
(86, 7, '1150.00', 1393459200, '', 2, 1),
(87, 8, '690.00', 1393804800, '', 3, 1),
(88, 9, '11500.00', 1395792000, '', 1, 1),
(89, 10, '3162.50', 1395705600, '', 2, 1),
(91, 11, '690.00', 1397001600, '', 3, 1),
(93, 12, '9775.00', 1398729600, '', 1, 1),
(95, 13, '690.00', 1399852800, '', 3, 1),
(97, 14, '1725.00', 1401062400, '', 2, 1),
(98, 15, '2185.00', 1401062400, '', 2, 1),
(99, 16, '3450.00', 1401667200, '', 2, 1),
(103, 18, '5002.50', 1403481600, '', 3, 1),
(104, 19, '690.00', 1402272000, '', 2, 1),
(105, 20, '690.00', 1404864000, '', 3, 1),
(108, 21, '10000.00', 1404864000, '', 1, 1),
(109, 21, '9837.50', 1406764800, '', 1, 1),
(111, 22, '690.00', 1407110400, '', 2, 1),
(112, 17, '3450.00', 1402876800, '', 2, 1),
(116, 23, '3450.00', 1409270400, '', 3, 1),
(119, 25, '690.00', 1410134400, '', 3, 1),
(120, 24, '5175.00', 1409270400, '', 2, 1),
(122, 26, '8625.00', 1410480000, '', 1, 1),
(123, 27, '1150.00', 1411603200, '', 3, 1),
(124, 28, '690.00', 1412553600, '', 2, 1),
(127, 29, '10000.00', 1412726400, '', 1, 1),
(128, 29, '5525.00', 1414713600, '', 2, 1),
(130, 30, '690.00', 1415059200, '', 3, 1),
(132, 31, '4600.00', 1416182400, '', 2, 1),
(134, 32, '5750.00', 1417132800, '', 2, 1),
(135, 33, '690.00', 1417996800, '', 3, 1),
(136, 34, '13225.00', 1419552000, '', 1, 1),
(139, 2, '1150.00', 1421366400, '', 2, 1),
(141, 3, '2300.00', 1421971200, '', 2, 1),
(142, 4, '3105.00', 1422576000, '', 1, 1),
(143, 35, '690.00', 1423440000, '', 2, 1),
(144, 36, '10350.00', 1424044800, '', 1, 1),
(145, 37, '8625.00', 1424995200, '', 3, 1),
(146, 38, '690.00', 1425859200, '', 2, 1),
(147, 39, '10000.00', 1425859200, '', 1, 1),
(148, 39, '11850.00', 1427068800, '', 1, 1),
(149, 40, '690.00', 1428278400, '', 2, 1),
(150, 41, '8337.50', 1429488000, '', 3, 1),
(151, 42, '690.00', 1430697600, '', 2, 1),
(152, 43, '3450.00', 1432857600, '', 3, 1),
(154, 45, '690.00', 1433721600, '', 2, 1),
(156, 46, '8625.00', 1435536000, '', 1, 1),
(157, 48, '5750.00', 1437955200, '', 2, 1),
(158, 50, '8050.00', 1439164800, '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE IF NOT EXISTS `payment_types` (
  `payment_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(255) NOT NULL,
  `payment_requires_proof` int(1) DEFAULT '0',
  PRIMARY KEY (`payment_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`payment_type_id`, `payment_type`, `payment_requires_proof`) VALUES
(1, 'Bank', 1),
(2, 'Stripe', 0),
(3, 'Paypal', 0),
(4, 'Other', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `report_title` varchar(255) NOT NULL,
  `report_date` int(11) NOT NULL,
  `report_from` int(11) NOT NULL,
  `report_untill` int(11) NOT NULL,
  `report_included_paid` int(1) NOT NULL,
  `report_included_due` int(1) NOT NULL,
  `report_included_pastdue` int(1) NOT NULL,
  `report_currency` varchar(3) NOT NULL DEFAULT 'USD',
  `report_paid` decimal(11,2) NOT NULL,
  `report_balance` decimal(11,2) NOT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `reports_clients`
--

CREATE TABLE IF NOT EXISTS `reports_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `reports_clients`
--

INSERT INTO `reports_clients` (`id`, `report_id`, `client_id`) VALUES
(3, 3, 3),
(4, 3, 4),
(5, 3, 7),
(6, 3, 5),
(7, 3, 6),
(8, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `reports_invoices`
--

CREATE TABLE IF NOT EXISTS `reports_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `reports_invoices`
--

INSERT INTO `reports_invoices` (`id`, `report_id`, `invoice_id`) VALUES
(2, 3, 5),
(3, 3, 6),
(4, 3, 4),
(5, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '1',
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, 1, '127.0.0.1', 'administrator', '$2y$08$r7HRVnYJQocObNtMpeBdmO6cOtkrDhd3CDMf/eieOleaQSiwQMp7.', '', 'admin@admin.com', '', '5aRq-QQgEeIYC1aQkCg9ie73d0393f47159d26e8', 1430541837, '5pQ/AVBPm8GYCqU6lfrzYe', 1268889823, 1439867437, 1, 'Mattijss', 'Naus', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
