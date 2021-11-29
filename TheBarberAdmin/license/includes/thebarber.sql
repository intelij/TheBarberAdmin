-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2021 at 07:51 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thebarber_multi_empty`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `street` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `let` text NOT NULL,
  `long` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `adminsetting`
--

CREATE TABLE `adminsetting` (
  `id` int(10) NOT NULL,
  `user_verify` tinyint(1) NOT NULL DEFAULT 1,
  `user_verify_sms` tinyint(1) NOT NULL DEFAULT 1,
  `user_verify_email` tinyint(1) NOT NULL DEFAULT 1,
  `currency` varchar(255) NOT NULL,
  `currency_symbol` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL DEFAULT 'English',
  `mapkey` text DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lang` varchar(255) DEFAULT NULL,
  `notification` tinyint(1) NOT NULL DEFAULT 1,
  `app_id` text DEFAULT NULL,
  `api_key` text DEFAULT NULL,
  `auth_key` text DEFAULT NULL,
  `project_no` text DEFAULT NULL,
  `owner_app_id` varchar(255) DEFAULT NULL,
  `owner_api_key` varchar(255) DEFAULT NULL,
  `owner_auth_key` varchar(255) DEFAULT NULL,
  `owner_project_no` varchar(255) DEFAULT NULL,
  `employee_app_id` varchar(255) DEFAULT NULL,
  `employee_api_key` varchar(255) DEFAULT NULL,
  `employee_auth_key` varchar(255) DEFAULT NULL,
  `employee_project_no` varchar(255) DEFAULT NULL,
  `mail` tinyint(1) NOT NULL DEFAULT 1,
  `mail_by` varchar(10) DEFAULT NULL,
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_encryption` varchar(255) DEFAULT NULL,
  `mail_port` varchar(255) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `sender_email` varchar(255) DEFAULT NULL,
  `mailgun_key` varchar(255) DEFAULT NULL,
  `mailgun_domain` varchar(255) DEFAULT NULL,
  `sms` tinyint(1) NOT NULL DEFAULT 1,
  `twilio_acc_id` varchar(255) DEFAULT NULL,
  `twilio_auth_token` varchar(255) DEFAULT NULL,
  `twilio_phone_no` varchar(255) DEFAULT NULL,
  `terms_conditions` longtext DEFAULT NULL,
  `privacy_policy` longtext DEFAULT NULL,
  `radius` int(10) NOT NULL,
  `commission_type` varchar(255) NOT NULL,
  `commission_amount` float NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `favicon` text NOT NULL,
  `black_logo` text NOT NULL,
  `white_logo` text NOT NULL,
  `app_version` text DEFAULT NULL,
  `footer1` text DEFAULT NULL,
  `footer2` text DEFAULT NULL,
  `bg_img` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `license_code` text DEFAULT NULL,
  `license_client_name` varchar(255) DEFAULT NULL,
  `license_status` tinyint(1) DEFAULT NULL,
  `shared_name` varchar(255) DEFAULT NULL,
  `shared_image` varchar(255) DEFAULT NULL,
  `shared_url` varchar(255) DEFAULT NULL,
  `play_store_link` varchar(255) DEFAULT NULL,
  `app_store_link` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adminsetting`
--

INSERT INTO `adminsetting` (`id`, `user_verify`, `user_verify_sms`, `user_verify_email`, `currency`, `currency_symbol`, `language`, `mapkey`, `lat`, `lang`, `notification`, `app_id`, `api_key`, `auth_key`, `project_no`, `owner_app_id`, `owner_api_key`, `owner_auth_key`, `owner_project_no`, `employee_app_id`, `employee_api_key`, `employee_auth_key`, `employee_project_no`, `mail`, `mail_by`, `mail_host`, `mail_encryption`, `mail_port`, `mail_username`, `mail_password`, `sender_email`, `mailgun_key`, `mailgun_domain`, `sms`, `twilio_acc_id`, `twilio_auth_token`, `twilio_phone_no`, `terms_conditions`, `privacy_policy`, `radius`, `commission_type`, `commission_amount`, `app_name`, `favicon`, `black_logo`, `white_logo`, `app_version`, `footer1`, `footer2`, `bg_img`, `color`, `license_code`, `license_client_name`, `license_status`, `shared_name`, `shared_image`, `shared_url`, `play_store_link`, `app_store_link`, `phone`, `address`, `email`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, 'USD', '$', 'English', NULL, '21.1702', '72.8311', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mailgun', NULL, NULL, NULL, NULL, NULL, NULL, '#', '#', 0, NULL, NULL, NULL, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.', 50, 'Percentage', 10, 'The Barber', 'favicon.png', 'black_logo.png', 'white_logo.png', 'Version 01.0.00', '©Thebarber 2020-21', 'All rights reserved', 'bg_img.jpg', '#e06287', NULL, NULL, 0, 'The Barber', 'shared_image.jpg', '#', '#', '#', '+912345678901', 'Testing Address, India', 'thebarber@gmail.com', '2020-08-14 05:37:51', '2021-05-05 11:17:14');

-- --------------------------------------------------------

--
-- Table structure for table `app_notification`
--

CREATE TABLE `app_notification` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `booking_id` int(10) NOT NULL,
  `salon_id` int(10) NOT NULL,
  `emp_id` varchar(20) DEFAULT NULL,
  `title` text CHARACTER SET utf8mb4 NOT NULL,
  `msg` text CHARACTER SET utf8mb4 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(255) NOT NULL,
  `salon_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `service_id` text NOT NULL,
  `coupon_id` int(10) DEFAULT NULL,
  `address_id` varchar(255) DEFAULT NULL,
  `discount` float DEFAULT 0,
  `payment` float NOT NULL,
  `date` date NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `payment_token` text DEFAULT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT 0,
  `booking_status` varchar(20) NOT NULL,
  `commission` float NOT NULL,
  `salon_income` float NOT NULL,
  `booking_at` varchar(20) DEFAULT NULL,
  `extra_charges` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'noimage.jpg',
  `banner` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` int(10) NOT NULL,
  `desc` text NOT NULL,
  `code` varchar(255) NOT NULL,
  `max_use` int(10) NOT NULL,
  `use_count` int(10) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL,
  `discount` float NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `symbol` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `country`, `currency`, `code`, `symbol`) VALUES
(1, 'Albania', 'Leke', 'ALL', 'Lek'),
(2, 'America', 'Dollars', 'USD', '$'),
(3, 'Afghanistan', 'Afghanis', 'AFN', '؋'),
(4, 'Argentina', 'Pesos', 'ARS', '$'),
(5, 'Aruba', 'Guilders', 'AWG', 'Afl'),
(6, 'Australia', 'Dollars', 'AUD', '$'),
(7, 'Azerbaijan', 'New Manats', 'AZN', '₼'),
(8, 'Bahamas', 'Dollars', 'BSD', '$'),
(9, 'Barbados', 'Dollars', 'BBD', '$'),
(10, 'Belarus', 'Rubles', 'BYR', 'p.'),
(11, 'Belgium', 'Euro', 'EUR', '€'),
(12, 'Beliz', 'Dollars', 'BZD', 'BZ$'),
(13, 'Bermuda', 'Dollars', 'BMD', '$'),
(14, 'Bolivia', 'Bolivianos', 'BOB', '$b'),
(15, 'Bosnia and Herzegovina', 'Convertible Marka', 'BAM', 'KM'),
(16, 'Botswana', 'Pula', 'BWP', 'P'),
(17, 'Bulgaria', 'Leva', 'BGN', 'Лв.'),
(18, 'Brazil', 'Reais', 'BRL', 'R$'),
(19, 'Britain (United Kingdom)', 'Pounds', 'GBP', '£\r\n'),
(20, 'Brunei Darussalam', 'Dollars', 'BND', '$'),
(21, 'Cambodia', 'Riels', 'KHR', '៛'),
(22, 'Canada', 'Dollars', 'CAD', '$'),
(23, 'Cayman Islands', 'Dollars', 'KYD', '$'),
(24, 'Chile', 'Pesos', 'CLP', '$'),
(25, 'China', 'Yuan Renminbi', 'CNY', '¥'),
(26, 'Colombia', 'Pesos', 'COP', '$'),
(27, 'Costa Rica', 'Colón', 'CRC', '₡'),
(28, 'Croatia', 'Kuna', 'HRK', 'kn'),
(29, 'Cuba', 'Pesos', 'CUP', '₱'),
(30, 'Cyprus', 'Euro', 'EUR', '€'),
(31, 'Czech Republic', 'Koruny', 'CZK', 'Kč'),
(32, 'Denmark', 'Kroner', 'DKK', 'kr'),
(33, 'Dominican Republic', 'Pesos', 'DOP', 'RD$'),
(34, 'East Caribbean', 'Dollars', 'XCD', '$'),
(35, 'Egypt', 'Pounds', 'EGP', '£'),
(36, 'El Salvador', 'Colones', 'SVC', '$'),
(37, 'England (United Kingdom)', 'Pounds', 'GBP', '£'),
(38, 'Euro', 'Euro', 'EUR', '€'),
(39, 'Falkland Islands', 'Pounds', 'FKP', '£'),
(40, 'Fiji', 'Dollars', 'FJD', '$'),
(41, 'France', 'Euro', 'EUR', '€'),
(42, 'Ghana', 'Cedis', 'GHC', 'GH₵'),
(43, 'Gibraltar', 'Pounds', 'GIP', '£'),
(44, 'Greece', 'Euro', 'EUR', '€'),
(45, 'Guatemala', 'Quetzales', 'GTQ', 'Q'),
(46, 'Guernsey', 'Pounds', 'GGP', '£'),
(47, 'Guyana', 'Dollars', 'GYD', '$'),
(48, 'Holland (Netherlands)', 'Euro', 'EUR', '€'),
(49, 'Honduras', 'Lempiras', 'HNL', 'L'),
(50, 'Hong Kong', 'Dollars', 'HKD', '$'),
(51, 'Hungary', 'Forint', 'HUF', 'Ft'),
(52, 'Iceland', 'Kronur', 'ISK', 'kr'),
(53, 'India', 'Rupees', 'INR', '₹'),
(54, 'Indonesia', 'Rupiahs', 'IDR', 'Rp'),
(55, 'Iran', 'Rials', 'IRR', '﷼'),
(56, 'Ireland', 'Euro', 'EUR', '€'),
(57, 'Isle of Man', 'Pounds', 'IMP', '£'),
(58, 'Israel', 'New Shekels', 'ILS', '₪'),
(59, 'Italy', 'Euro', 'EUR', '€'),
(60, 'Jamaica', 'Dollars', 'JMD', 'J$'),
(61, 'Japan', 'Yen', 'JPY', '¥'),
(62, 'Jersey', 'Pounds', 'JEP', '£'),
(63, 'Kazakhstan', 'Tenge', 'KZT', '₸'),
(64, 'Korea (North)', 'Won', 'KPW', '₩'),
(65, 'Korea (South)', 'Won', 'KRW', '₩'),
(66, 'Kyrgyzstan', 'Soms', 'KGS', 'Лв'),
(67, 'Laos', 'Kips', 'LAK', '	₭'),
(68, 'Latvia', 'Lati', 'LVL', 'Ls'),
(69, 'Lebanon', 'Pounds', 'LBP', '£'),
(70, 'Liberia', 'Dollars', 'LRD', '$'),
(71, 'Liechtenstein', 'Switzerland Francs', 'CHF', 'CHF'),
(72, 'Lithuania', 'Litai', 'LTL', 'Lt'),
(73, 'Luxembourg', 'Euro', 'EUR', '€'),
(74, 'Macedonia', 'Denars', 'MKD', 'Ден\r\n'),
(75, 'Malaysia', 'Ringgits', 'MYR', 'RM'),
(76, 'Malta', 'Euro', 'EUR', '€'),
(77, 'Mauritius', 'Rupees', 'MUR', '₹'),
(78, 'Mexico', 'Pesos', 'MXN', '$'),
(79, 'Mongolia', 'Tugriks', 'MNT', '₮'),
(80, 'Mozambique', 'Meticais', 'MZN', 'MT'),
(81, 'Namibia', 'Dollars', 'NAD', '$'),
(82, 'Nepal', 'Rupees', 'NPR', '₹'),
(83, 'Netherlands Antilles', 'Guilders', 'ANG', 'ƒ'),
(84, 'Netherlands', 'Euro', 'EUR', '€'),
(85, 'New Zealand', 'Dollars', 'NZD', '$'),
(86, 'Nicaragua', 'Cordobas', 'NIO', 'C$'),
(87, 'Nigeria', 'Nairas', 'NGN', '₦'),
(88, 'North Korea', 'Won', 'KPW', '₩'),
(89, 'Norway', 'Krone', 'NOK', 'kr'),
(90, 'Oman', 'Rials', 'OMR', '﷼'),
(91, 'Pakistan', 'Rupees', 'PKR', '₹'),
(92, 'Panama', 'Balboa', 'PAB', 'B/.'),
(93, 'Paraguay', 'Guarani', 'PYG', 'Gs'),
(94, 'Peru', 'Nuevos Soles', 'PEN', 'S/.'),
(95, 'Philippines', 'Pesos', 'PHP', 'Php'),
(96, 'Poland', 'Zlotych', 'PLN', 'zł'),
(97, 'Qatar', 'Rials', 'QAR', '﷼'),
(98, 'Romania', 'New Lei', 'RON', 'lei'),
(99, 'Russia', 'Rubles', 'RUB', '₽'),
(100, 'Saint Helena', 'Pounds', 'SHP', '£'),
(101, 'Saudi Arabia', 'Riyals', 'SAR', '﷼'),
(102, 'Serbia', 'Dinars', 'RSD', 'ع.د'),
(103, 'Seychelles', 'Rupees', 'SCR', '₹'),
(104, 'Singapore', 'Dollars', 'SGD', '$'),
(105, 'Slovenia', 'Euro', 'EUR', '€'),
(106, 'Solomon Islands', 'Dollars', 'SBD', '$'),
(107, 'Somalia', 'Shillings', 'SOS', 'S'),
(108, 'South Africa', 'Rand', 'ZAR', 'R'),
(109, 'South Korea', 'Won', 'KRW', '₩'),
(110, 'Spain', 'Euro', 'EUR', '€'),
(111, 'Sri Lanka', 'Rupees', 'LKR', '₹'),
(112, 'Sweden', 'Kronor', 'SEK', 'kr'),
(113, 'Switzerland', 'Francs', 'CHF', 'CHF'),
(114, 'Suriname', 'Dollars', 'SRD', '$'),
(115, 'Syria', 'Pounds', 'SYP', '£'),
(116, 'Taiwan', 'New Dollars', 'TWD', 'NT$'),
(117, 'Thailand', 'Baht', 'THB', '฿'),
(118, 'Trinidad and Tobago', 'Dollars', 'TTD', 'TT$'),
(119, 'Turkey', 'Lira', 'TRY', 'TL'),
(120, 'Turkey', 'Liras', 'TRL', '₺'),
(121, 'Tuvalu', 'Dollars', 'TVD', '$'),
(122, 'Ukraine', 'Hryvnia', 'UAH', '₴'),
(123, 'United Kingdom', 'Pounds', 'GBP', '£'),
(124, 'United States of America', 'Dollars', 'USD', '$'),
(125, 'Uruguay', 'Pesos', 'UYU', '$U'),
(126, 'Uzbekistan', 'Sums', 'UZS', 'so\'m'),
(127, 'Vatican City', 'Euro', 'EUR', '€'),
(128, 'Venezuela', 'Bolivares Fuertes', 'VEF', 'Bs'),
(129, 'Vietnam', 'Dong', 'VND', '₫'),
(130, 'Yemen', 'Rials', 'YER', '﷼'),
(131, 'Zimbabwe', 'Zimbabwe Dollars', 'ZWD', 'Z$');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(10) NOT NULL,
  `salon_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'noimage.jpg',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `give_service` varchar(20) DEFAULT NULL,
  `service_id` text NOT NULL,
  `sun` text DEFAULT NULL,
  `mon` text DEFAULT NULL,
  `tue` text DEFAULT NULL,
  `wed` text DEFAULT NULL,
  `thu` text DEFAULT NULL,
  `fri` text DEFAULT NULL,
  `sat` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `device_token` text DEFAULT NULL,
  `isdelete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gallery_id` int(10) NOT NULL,
  `salon_id` int(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `file`, `image`, `direction`, `status`, `created_at`, `updated_at`) VALUES
(1, 'English', 'English.json', 'English.jpg', 'ltr', 1, '2020-10-02 05:56:49', '2020-10-03 09:34:22'),
(2, 'Arabic', 'Arabic.json', 'Arabic.jpg', 'rtl', 1, '2020-10-02 06:04:41', '2021-04-13 07:29:54');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(10) NOT NULL,
  `module` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `booking_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `msg` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin', 'IZfEmfK4CgYBTqR9HOxuBNwM0mKjWSwyB60nztDp', NULL, 'http://localhost', 1, 0, 0, '2020-10-02 13:16:30', '2020-10-02 13:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-10-02 13:16:30', '2020-10-02 13:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `id` int(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `discount` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paymentsetting`
--

CREATE TABLE `paymentsetting` (
  `id` int(11) NOT NULL,
  `cod` tinyint(1) NOT NULL,
  `stripe` tinyint(1) NOT NULL,
  `stripe_public_key` text DEFAULT NULL,
  `stripe_secret_key` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paymentsetting`
--

INSERT INTO `paymentsetting` (`id`, `cod`, `stripe`, `stripe_public_key`, `stripe_secret_key`, `created_at`, `updated_at`) VALUES
(1, 1, 0, NULL, NULL, '2020-08-14 08:48:44', '2021-05-05 11:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `salon_id` int(10) NOT NULL,
  `booking_id` int(10) NOT NULL,
  `rate` int(5) NOT NULL,
  `message` text NOT NULL,
  `report` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salon`
--

CREATE TABLE `salon` (
  `salon_id` int(10) NOT NULL,
  `owner_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `gender` varchar(10) NOT NULL,
  `give_service` varchar(255) DEFAULT NULL,
  `home_charges` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` bigint(20) NOT NULL,
  `sun` text DEFAULT NULL,
  `mon` text DEFAULT NULL,
  `tue` text DEFAULT NULL,
  `wed` text DEFAULT NULL,
  `thu` text DEFAULT NULL,
  `fri` text DEFAULT NULL,
  `sat` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `salon_id` int(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `time` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `isdelete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `mail_content` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `msg_content` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `title`, `subject`, `mail_content`, `msg_content`, `created_at`, `updated_at`) VALUES
(1, 'User Verification', 'User Verification', '<table id=\"mainStructure\" class=\"full-width\" width=\"800\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #ffffff; max-width: 800px; outline: #efefef solid 1px; box-shadow: #e0e0e0 0px 0px 30px 5px; margin: 0px auto;\">\r\n      <!-- START LAYOUT-1 ( SET-1 )-->\r\n      <tbody>\r\n        <tr>\r\n          <td valign=\"top\" align=\"center\" style=\"background-color: #f85954;\" bgcolor=\"#f85954\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #f85954; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" class=\"full-width\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr><!-- END LAYOUT-1 ( SET-1 )-->\r\n        <!--START LAYOUT-2 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #ffffff;\" bgcolor=\"#ffffff\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr class=\"row\" style=\"display: flex; text-align: center;\">\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\">\r\n                                                        <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" data-filename=\"black_logo.png\" width=\"160\" style=\"max-width: 160px; height: auto; display: block !important; min-width: 100%;\" alt=\"logo-top\" border=\"0\" hspace=\"0\" vspace=\"0\" height=\"auto\">\r\n                                                      \r\n                                                      </a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important; margin: auto;\" class=\"full-block\">\r\n                                    <table width=\"20\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" class=\"full-width\" style=\"border-spacing: 0px; max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\" align=\"center\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.facebook.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-facebook2.png\" width=\"25\" alt=\"facebook\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.twitter.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-twitter2.png\" width=\"25\" alt=\"twitter\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.instagram.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-instagram2.png\" width=\"25\" alt=\"instagram\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-2 ( SET-1 )-->\r\n        <!--START LAYOUT-3 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\"><p><br></p><p>\r\n            </p><table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background:url(https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png);background-position: 0% 100%; background-size: auto; background-color: #6b7dfb; background-repeat: no-repeat; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\" background=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" height=\"0\">\r\n              <!--[if gte mso 9]>            \r\n  <tr><td valign=\"top\" align=\"center\">            \r\n  <v:image xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; width:450pt; height:0pt; background-repeat:no-repeat;\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" ></v:image>            \r\n  <v:rect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; position: absolute; width:450pt; height:0pt;  background-repeat:no-repeat;\">            \r\n  <v:fill type=\"frame\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" color=\"#6b7dfb\" ></v:fill>            \r\n  <![endif]-->\r\n              <!--[if gte mso 9]>            \r\n  </v:fill>            \r\n  </v:rect>            \r\n  </v:image>            \r\n  </td></tr>            \r\n  <![endif]-->\r\n            </table>\r\n          <p></p></td>\r\n        </tr>\r\n        <!--END LAYOUT-3 ( SET-1 )-->\r\n        <!--START LAYOUT-4 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td valign=\"top\">\r\n                                    <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td align=\"left\" style=\"font-size: 24px; color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; word-break: break-word; line-height: 110%;\">\r\n                                            <span style=\"font-weight: 400; color: rgb(136, 136, 136); font-style: normal; line-height: 24px; font-size: 16px; font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif;\">Hello\r\n                                              {{UserName}},</span><br><br><b>Verification Code</b></td>\r\n                                        </tr><!-- start space -->\r\n                                        <tr>\r\n                                          <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr><!-- end space -->\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </td>\r\n                                </tr>\r\n                                <tr>\r\n                                  <td align=\"left\" style=\"font-size: 14px; color: #888888; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">Your verification code is: {{OTP}}<br></td>\r\n                                </tr><!-- start space -->\r\n                                <tr>\r\n                                  <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                                </tr><!-- end space -->\r\n\r\n\r\n\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-4 ( SET-1 )-->\r\n        <!--START LAYOUT-5 ( serrated )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"560\" style=\"width: 560px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/divider-3.png\" width=\"560\" style=\"display: block !important; width: 100%; max-width: 560px; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\"></a> </td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-5 ( serrated )-->\r\n        <!--START LAYOUT-6 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-6 ( SET-1 )-->\r\n        <!--START LAYOUT-9 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" width=\"160\" style=\"max-width: 160px; width: 160px; height: auto; display: block !important; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\" height=\"auto\"></a> </td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-9 ( SET-1 )-->\r\n        <!--START LAYOUT-11 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #f1f1f1;\" bgcolor=\"#f1f1f1\">\r\n            <!-- start container -->\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #f1f1f1; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <!-- start space -->\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                        <tr>\r\n                          <td valign=\"middle\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" style=\"font-size: 14px; color: #888888; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">\r\n                                    <span style=\"color: #888888; text-decoration: none; font-style: normal; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;\">\r\n                                      © Copyright 2021&nbsp; {{AppName}} . All Rights Reserved </span></td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr><!-- start space -->\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table><!-- end container -->\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-11 ( SET-1 )-->\r\n      </tbody>\r\n    </table>', 'Dear {{UserName}},  Your Verification code is {{OTP}}. From {{AppName}}.', '2020-08-20 17:32:46', '2021-05-05 10:51:38'),
(2, 'Forgot Password', 'Forgot Password', '<table id=\"mainStructure\" class=\"full-width\" width=\"800\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #ffffff; max-width: 800px; outline: #efefef solid 1px; box-shadow: #e0e0e0 0px 0px 30px 5px; margin: 0px auto;\">\r\n      <!-- START LAYOUT-1 ( SET-1 )-->\r\n      <tbody>\r\n        <tr>\r\n          <td valign=\"top\" align=\"center\" style=\"background-color: #f85954;\" bgcolor=\"#f85954\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #f85954; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" class=\"full-width\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr><!-- END LAYOUT-1 ( SET-1 )-->\r\n        <!--START LAYOUT-2 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #ffffff;\" bgcolor=\"#ffffff\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr class=\"row\" style=\"display: flex; text-align: center;\">\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\">\r\n                                                        <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" data-filename=\"black_logo.png\" width=\"160\" style=\"max-width: 160px; height: auto; display: block !important; min-width: 100%;\" alt=\"logo-top\" border=\"0\" hspace=\"0\" vspace=\"0\" height=\"auto\">\r\n                                                      \r\n                                                      </a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important; margin: auto;\" class=\"full-block\">\r\n                                    <table width=\"20\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" class=\"full-width\" style=\"border-spacing: 0px; max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\" align=\"center\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.facebook.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-facebook2.png\" width=\"25\" alt=\"facebook\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.twitter.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-twitter2.png\" width=\"25\" alt=\"twitter\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.instagram.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-instagram2.png\" width=\"25\" alt=\"instagram\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-2 ( SET-1 )-->\r\n        <!--START LAYOUT-3 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\"><p><br></p><p>\r\n            </p><table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background:url(https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png);background-position: 0% 100%; background-size: auto; background-color: #6b7dfb; background-repeat: no-repeat; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\" background=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" height=\"0\">\r\n              <!--[if gte mso 9]>            \r\n  <tr><td valign=\"top\" align=\"center\">            \r\n  <v:image xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; width:450pt; height:0pt; background-repeat:no-repeat;\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" ></v:image>            \r\n  <v:rect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; position: absolute; width:450pt; height:0pt;  background-repeat:no-repeat;\">            \r\n  <v:fill type=\"frame\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" color=\"#6b7dfb\" ></v:fill>            \r\n  <![endif]-->\r\n              <!--[if gte mso 9]>            \r\n  </v:fill>            \r\n  </v:rect>            \r\n  </v:image>            \r\n  </td></tr>            \r\n  <![endif]-->\r\n            </table>\r\n          <p></p></td>\r\n        </tr>\r\n        <!--END LAYOUT-3 ( SET-1 )-->\r\n        <!--START LAYOUT-4 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td valign=\"top\">\r\n                                    <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td align=\"left\" style=\"font-size: 24px; color: #333333; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 110%;\">\r\n                                            <span style=\"color: #888888; font-style: normal; line-height: 24px; font-size: 16px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;\">Hello\r\n                                              {{UserName}},</span><br><br><span style=\"color: #333333; font-style: normal; line-height: 28px; font-size: 24px; font-weight: 700; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;\">New Password</span></td>\r\n                                        </tr><!-- start space -->\r\n                                        <tr>\r\n                                          <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr><!-- end space -->\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </td>\r\n                                </tr>\r\n                                <tr>\r\n                                  <td align=\"left\" style=\"font-size: 14px; color: #888888; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">\r\n                                    Your new password is: {{NewPassword}} </td>\r\n                                </tr><!-- start space -->\r\n                                <tr>\r\n                                  <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                                </tr><!-- end space -->\r\n\r\n\r\n\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-4 ( SET-1 )-->\r\n        <!--START LAYOUT-5 ( serrated )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"560\" style=\"width: 560px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/divider-3.png\" width=\"560\" style=\"display: block !important; width: 100%; max-width: 560px; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\"></a> </td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-5 ( serrated )-->\r\n        <!--START LAYOUT-6 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-6 ( SET-1 )-->\r\n        <!--START LAYOUT-9 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" width=\"160\" style=\"max-width: 160px; width: 160px; height: auto; display: block !important; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\" height=\"auto\"></a> </td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-9 ( SET-1 )-->\r\n        <!--START LAYOUT-11 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #f1f1f1;\" bgcolor=\"#f1f1f1\">\r\n            <!-- start container -->\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #f1f1f1; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <!-- start space -->\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                        <tr>\r\n                          <td valign=\"middle\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" style=\"font-size: 14px; color: #888888; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">\r\n                                    <span style=\"color: #888888; text-decoration: none; font-style: normal; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;\">\r\n                                      © Copyright 2021&nbsp; {{AppName}} . All Rights Reserved </span></td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr><!-- start space -->\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table><!-- end container -->\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-11 ( SET-1 )-->\r\n      </tbody>\r\n    </table>', 'Dear {{UserName}}, Your new password is {{NewPassword}}. Thank you. From {{AppName}}.', '2020-08-20 17:32:47', '2021-05-05 10:52:04');
INSERT INTO `template` (`id`, `title`, `subject`, `mail_content`, `msg_content`, `created_at`, `updated_at`) VALUES
(3, 'Booking status', 'Booking status', '<table id=\"mainStructure\" class=\"full-width\" width=\"800\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #ffffff; max-width: 800px; outline: #efefef solid 1px; box-shadow: #e0e0e0 0px 0px 30px 5px; margin: 0px auto;\">\r\n      <!-- START LAYOUT-1 ( SET-1 )-->\r\n      <tbody>\r\n        <tr>\r\n          <td valign=\"top\" align=\"center\" style=\"background-color: #f85954;\" bgcolor=\"#f85954\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #f85954; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" class=\"full-width\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr><!-- END LAYOUT-1 ( SET-1 )-->\r\n        <!--START LAYOUT-2 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #ffffff;\" bgcolor=\"#ffffff\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr class=\"row\" style=\"display: flex; text-align: center;\">\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\">\r\n                                                        <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" data-filename=\"black_logo.png\" width=\"160\" style=\"max-width: 160px; height: auto; display: block !important; min-width: 100%;\" alt=\"logo-top\" border=\"0\" hspace=\"0\" vspace=\"0\" height=\"auto\">\r\n                                                      \r\n                                                      </a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important; margin: auto;\" class=\"full-block\">\r\n                                    <table width=\"20\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" class=\"full-width\" style=\"border-spacing: 0px; max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\" align=\"center\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.facebook.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-facebook2.png\" width=\"25\" alt=\"facebook\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.twitter.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-twitter2.png\" width=\"25\" alt=\"twitter\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.instagram.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-instagram2.png\" width=\"25\" alt=\"instagram\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-2 ( SET-1 )-->\r\n        <!--START LAYOUT-3 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\"><p><br></p><p>\r\n            </p><table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background:url(https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png);background-position: 0% 100%; background-size: auto; background-color: #6b7dfb; background-repeat: no-repeat; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\" background=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" height=\"0\">\r\n              <!--[if gte mso 9]>            \r\n  <tr><td valign=\"top\" align=\"center\">            \r\n  <v:image xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; width:450pt; height:0pt; background-repeat:no-repeat;\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" ></v:image>            \r\n  <v:rect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; position: absolute; width:450pt; height:0pt;  background-repeat:no-repeat;\">            \r\n  <v:fill type=\"frame\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" color=\"#6b7dfb\" ></v:fill>            \r\n  <![endif]-->\r\n              <!--[if gte mso 9]>            \r\n  </v:fill>            \r\n  </v:rect>            \r\n  </v:image>            \r\n  </td></tr>            \r\n  <![endif]-->\r\n            </table>\r\n          <p></p></td>\r\n        </tr>\r\n        <!--END LAYOUT-3 ( SET-1 )-->\r\n        <!--START LAYOUT-4 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td valign=\"top\">\r\n                                    <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td align=\"left\" style=\"word-break: break-word; line-height: 110%;\">\r\n                                            <span style=\"color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; font-size: 16px; font-weight: 400; font-style: normal; line-height: 24px;\">Hello\r\n                                              {{UserName}},</span><br><br><b style=\"color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; font-size: 24px;\">Booking&nbsp;</b><font color=\"#333333\" face=\"Open Sans, Arial, Helvetica, sans-serif\"><span style=\"font-size: 24px;\"><b>{{BookingStatus}}</b></span></font></td>\r\n                                        </tr><!-- start space -->\r\n                                        <tr>\r\n                                          <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr><!-- end space -->\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </td>\r\n                                </tr>\r\n                                <tr>\r\n                                  <td align=\"left\" style=\"font-size: 14px; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\"><span style=\"font-weight: normal;\"> Thank you for availing services with {{AppName}}.<br><br>Your appointment on {{Date}} at {{Time}} in </span><b>{{SalonName}}</b> is now&nbsp;<b>{{BookingStatus}}</b>. <br><br>Your booking id is&nbsp;<b>{{BookingId}}</b>.</td>\r\n                                </tr><!-- start space -->\r\n                                <tr>\r\n                                  <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;fd</td>\r\n                                </tr><!-- end space -->\r\n\r\n\r\n\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-4 ( SET-1 )-->\r\n        <!--START LAYOUT-5 ( serrated )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"560\" style=\"width: 560px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/divider-3.png\" width=\"560\" style=\"display: block !important; width: 100%; max-width: 560px; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\"></a> </td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-5 ( serrated )-->\r\n        <!--START LAYOUT-6 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-6 ( SET-1 )-->\r\n        <!--START LAYOUT-9 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" width=\"160\" style=\"max-width: 160px; width: 160px; height: auto; display: block !important; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\" height=\"auto\"></a> </td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-9 ( SET-1 )-->\r\n        <!--START LAYOUT-11 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #f1f1f1;\" bgcolor=\"#f1f1f1\">\r\n            <!-- start container -->\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #f1f1f1; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <!-- start space -->\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                        <tr>\r\n                          <td valign=\"middle\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" style=\"font-size: 14px; color: #888888; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">\r\n                                    <span style=\"color: #888888; text-decoration: none; font-style: normal; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;\">\r\n                                      © Copyright 2021&nbsp; {{AppName}} . All Rights Reserved </span></td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr><!-- start space -->\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table><!-- end container -->\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-11 ( SET-1 )-->\r\n      </tbody>\r\n    </table>', 'Dear {{UserName}}, Your appointment on {{Date}} at {{Time}} in {{SalonName}} is now {{BookingStatus}}. Your booking id is {{BookingId}}. Thank you.', '2020-08-20 17:34:50', '2021-05-05 10:52:30'),
(4, 'Welcome', 'Welcome', '<table id=\"mainStructure\" class=\"full-width\" width=\"800\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #ffffff; max-width: 800px; outline: #efefef solid 1px; box-shadow: #e0e0e0 0px 0px 30px 5px; margin: 0px auto;\">\r\n      <!-- START LAYOUT-1 ( SET-1 )-->\r\n      <tbody>\r\n        <tr>\r\n          <td valign=\"top\" align=\"center\" style=\"background-color: #f85954;\" bgcolor=\"#f85954\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #f85954; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" class=\"full-width\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr><!-- END LAYOUT-1 ( SET-1 )-->\r\n        <!--START LAYOUT-2 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #ffffff;\" bgcolor=\"#ffffff\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr class=\"row\" style=\"display: flex; text-align: center;\">\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\">\r\n                                                        <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" data-filename=\"black_logo.png\" width=\"160\" style=\"max-width: 160px; height: auto; display: block !important; min-width: 100%;\" alt=\"logo-top\" border=\"0\" hspace=\"0\" vspace=\"0\" height=\"auto\">\r\n                                                      \r\n                                                      </a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important; margin: auto;\" class=\"full-block\">\r\n                                    <table width=\"20\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" class=\"full-width\" style=\"border-spacing: 0px; max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\" align=\"center\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.facebook.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-facebook2.png\" width=\"25\" alt=\"facebook\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.twitter.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-twitter2.png\" width=\"25\" alt=\"twitter\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.instagram.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-instagram2.png\" width=\"25\" alt=\"instagram\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-2 ( SET-1 )-->\r\n        <!--START LAYOUT-3 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\"><p><br></p><p>\r\n            </p><table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background:url(https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png);background-position: 0% 100%; background-size: auto; background-color: #6b7dfb; background-repeat: no-repeat; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\" background=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" height=\"0\">\r\n              <!--[if gte mso 9]>            \r\n  <tr><td valign=\"top\" align=\"center\">            \r\n  <v:image xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; width:450pt; height:0pt; background-repeat:no-repeat;\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" ></v:image>            \r\n  <v:rect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; position: absolute; width:450pt; height:0pt;  background-repeat:no-repeat;\">            \r\n  <v:fill type=\"frame\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" color=\"#6b7dfb\" ></v:fill>            \r\n  <![endif]-->\r\n              <!--[if gte mso 9]>            \r\n  </v:fill>            \r\n  </v:rect>            \r\n  </v:image>            \r\n  </td></tr>            \r\n  <![endif]-->\r\n            </table>\r\n          <p></p></td>\r\n        </tr>\r\n        <!--END LAYOUT-3 ( SET-1 )-->\r\n        <!--START LAYOUT-4 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td valign=\"top\">\r\n                                    <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td align=\"left\" style=\"word-break: break-word; line-height: 110%;\"><br><b style=\"color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; font-size: 24px;\">Welcome,&nbsp;</b><font color=\"#333333\" face=\"Open Sans, Arial, Helvetica, sans-serif\"><span style=\"font-size: 24px;\"><b>{{UserName}}!</b></span></font></td>\r\n                                        </tr><!-- start space -->\r\n                                        <tr>\r\n                                          <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr><!-- end space -->\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </td>\r\n                                </tr>\r\n                                <tr>\r\n                                  <td align=\"left\" style=\"word-break: break-word; line-height: 140%;\"><font color=\"#888888\" face=\"Open Sans, Arial, Helvetica, sans-serif\"><span style=\"font-size: 14px;\">Thank you for joining {{AppName}}.</span></font><br><br><font color=\"#888888\" face=\"Open Sans, Arial, Helvetica, sans-serif\"><span style=\"font-size: 14px;\">You are in good hands now. Enjoy our unlimited service of appointment scheduling and booking. Book your frequent appointments and get started with us.</span></font><br><br><font color=\"#888888\" face=\"Open Sans, Arial, Helvetica, sans-serif\"><span style=\"font-size: 14px;\">Start your appointment booking and scheduling now by exploring the nearest salon to you.</span></font><br></td>\r\n                                </tr><!-- start space -->\r\n                                <tr>\r\n                                  <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;fd</td>\r\n                                </tr><!-- end space -->\r\n\r\n\r\n\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-4 ( SET-1 )-->\r\n        <!--START LAYOUT-5 ( serrated )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"560\" style=\"width: 560px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/divider-3.png\" width=\"560\" style=\"display: block !important; width: 100%; max-width: 560px; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\"></a> </td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-5 ( serrated )-->\r\n        <!--START LAYOUT-6 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-6 ( SET-1 )-->\r\n        <!--START LAYOUT-9 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" width=\"160\" style=\"max-width: 160px; width: 160px; height: auto; display: block !important; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\" height=\"auto\"></a> </td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-9 ( SET-1 )-->\r\n        <!--START LAYOUT-11 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #f1f1f1;\" bgcolor=\"#f1f1f1\">\r\n            <!-- start container -->\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #f1f1f1; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <!-- start space -->\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                        <tr>\r\n                          <td valign=\"middle\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" style=\"font-size: 14px; color: #888888; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">\r\n                                    <span style=\"color: #888888; text-decoration: none; font-style: normal; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;\">\r\n                                      © Copyright 2021&nbsp; {{AppName}} . All Rights Reserved </span></td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr><!-- start space -->\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table><!-- end container -->\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-11 ( SET-1 )-->\r\n      </tbody>\r\n    </table>', 'Not required', '2020-08-20 17:35:02', '2021-05-05 10:53:01');
INSERT INTO `template` (`id`, `title`, `subject`, `mail_content`, `msg_content`, `created_at`, `updated_at`) VALUES
(5, 'Create Appointment', 'Appointment Created', '<table id=\"mainStructure\" class=\"full-width\" width=\"800\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #ffffff; max-width: 800px; outline: #efefef solid 1px; box-shadow: #e0e0e0 0px 0px 30px 5px; margin: 0px auto;\">\r\n      <!-- START LAYOUT-1 ( SET-1 )-->\r\n      <tbody>\r\n        <tr>\r\n          <td valign=\"top\" align=\"center\" style=\"background-color: #f85954;\" bgcolor=\"#f85954\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #f85954; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" class=\"full-width\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr><!-- END LAYOUT-1 ( SET-1 )-->\r\n        <!--START LAYOUT-2 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #ffffff;\" bgcolor=\"#ffffff\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr class=\"row\" style=\"display: flex; text-align: center;\">\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\">\r\n                                                        <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" data-filename=\"black_logo.png\" width=\"160\" style=\"max-width: 160px; height: auto; display: block !important; min-width: 100%;\" alt=\"logo-top\" border=\"0\" hspace=\"0\" vspace=\"0\" height=\"auto\">\r\n                                                      \r\n                                                      </a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important; margin: auto;\" class=\"full-block\">\r\n                                    <table width=\"20\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" class=\"full-width\" style=\"border-spacing: 0px; max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\" align=\"center\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.facebook.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-facebook2.png\" width=\"25\" alt=\"facebook\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.twitter.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-twitter2.png\" width=\"25\" alt=\"twitter\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.instagram.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-instagram2.png\" width=\"25\" alt=\"instagram\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-2 ( SET-1 )-->\r\n        <!--START LAYOUT-3 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\"><p><br></p><p>\r\n            </p><table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background:url(https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png);background-position: 0% 100%; background-size: auto; background-color: #6b7dfb; background-repeat: no-repeat; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\" background=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" height=\"0\">\r\n              <!--[if gte mso 9]>            \r\n  <tr><td valign=\"top\" align=\"center\">            \r\n  <v:image xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; width:450pt; height:0pt; background-repeat:no-repeat;\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" ></v:image>            \r\n  <v:rect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; position: absolute; width:450pt; height:0pt;  background-repeat:no-repeat;\">            \r\n  <v:fill type=\"frame\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" color=\"#6b7dfb\" ></v:fill>            \r\n  <![endif]-->\r\n              <!--[if gte mso 9]>            \r\n  </v:fill>            \r\n  </v:rect>            \r\n  </v:image>            \r\n  </td></tr>            \r\n  <![endif]-->\r\n            </table>\r\n          <p></p></td>\r\n        </tr>\r\n        <!--END LAYOUT-3 ( SET-1 )-->\r\n        <!--START LAYOUT-4 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td valign=\"top\">\r\n                                    <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td align=\"left\" style=\"word-break: break-word; line-height: 110%;\">\r\n                                            <span style=\"color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; font-size: 16px; font-weight: 400; font-style: normal; line-height: 24px;\">Hello\r\n                                              {{UserName}},</span><br><br><font color=\"#333333\" face=\"Open Sans, Arial, Helvetica, sans-serif\"><span style=\"font-size: 24px;\"><b>Appointment Created</b></span></font></td>\r\n                                        </tr><!-- start space -->\r\n                                        <tr>\r\n                                          <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr><!-- end space -->\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </td>\r\n                                </tr>\r\n                                <tr>\r\n                                  <td align=\"left\" style=\"font-size: 14px; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">Your appointment is successfully booked on {{Date}} at {{Time}} by {{EmployeeName}} with {{SalonName}}. Booking id is {{BookingId}}.<br> We hope that you enjoy the best services with {{AppName}}! <br><br>Thank you for booking an appointment with us.<br>Experience the best services by {{AppName}}!</td>\r\n                                </tr><!-- start space -->\r\n                                <tr>\r\n                                  <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;fd</td>\r\n                                </tr><!-- end space -->\r\n\r\n\r\n\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-4 ( SET-1 )-->\r\n        <!--START LAYOUT-5 ( serrated )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"560\" style=\"width: 560px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/divider-3.png\" width=\"560\" style=\"display: block !important; width: 100%; max-width: 560px; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\"></a> </td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-5 ( serrated )-->\r\n        <!--START LAYOUT-6 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-6 ( SET-1 )-->\r\n        <!--START LAYOUT-9 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" width=\"160\" style=\"max-width: 160px; width: 160px; height: auto; display: block !important; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\" height=\"auto\"></a> </td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-9 ( SET-1 )-->\r\n        <!--START LAYOUT-11 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #f1f1f1;\" bgcolor=\"#f1f1f1\">\r\n            <!-- start container -->\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #f1f1f1; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <!-- start space -->\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                        <tr>\r\n                          <td valign=\"middle\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" style=\"font-size: 14px; color: #888888; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">\r\n                                    <span style=\"color: #888888; text-decoration: none; font-style: normal; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;\">\r\n                                      © Copyright 2021&nbsp; {{AppName}} . All Rights Reserved </span></td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr><!-- start space -->\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table><!-- end container -->\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-11 ( SET-1 )-->\r\n      </tbody>\r\n    </table>', 'Dear {{UserName}}, Your appointment is successfully created on {{Date}} at {{Time}} in {{SalonName}} at {{BookingAt}}. Your booking id is {{BookingId}}. Thank you.', '2020-08-21 16:46:46', '2021-05-05 10:53:24'),
(6, 'App Create Appointment', 'Appointment Created', '<table id=\"mainStructure\" class=\"full-width\" width=\"800\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #ffffff; max-width: 800px; outline: #efefef solid 1px; box-shadow: #e0e0e0 0px 0px 30px 5px; margin: 0px auto;\">\r\n      <!-- START LAYOUT-1 ( SET-1 )-->\r\n      <tbody>\r\n        <tr>\r\n          <td valign=\"top\" align=\"center\" style=\"background-color: #f85954;\" bgcolor=\"#f85954\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #f85954; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" class=\"full-width\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr><!-- END LAYOUT-1 ( SET-1 )-->\r\n        <!--START LAYOUT-2 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #ffffff;\" bgcolor=\"#ffffff\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr class=\"row\" style=\"display: flex; text-align: center;\">\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\">\r\n                                                        <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" data-filename=\"black_logo.png\" width=\"160\" style=\"max-width: 160px; height: auto; display: block !important; min-width: 100%;\" alt=\"logo-top\" border=\"0\" hspace=\"0\" vspace=\"0\" height=\"auto\">\r\n                                                      \r\n                                                      </a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important; margin: auto;\" class=\"full-block\">\r\n                                    <table width=\"20\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" class=\"full-width\" style=\"border-spacing: 0px; max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\" align=\"center\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.facebook.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-facebook2.png\" width=\"25\" alt=\"facebook\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.twitter.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-twitter2.png\" width=\"25\" alt=\"twitter\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.instagram.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-instagram2.png\" width=\"25\" alt=\"instagram\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-2 ( SET-1 )-->\r\n        <!--START LAYOUT-3 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\"><p><br></p><p>\r\n            </p><table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background:url(https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png);background-position: 0% 100%; background-size: auto; background-color: #6b7dfb; background-repeat: no-repeat; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\" background=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" height=\"0\">\r\n              <!--[if gte mso 9]>            \r\n  <tr><td valign=\"top\" align=\"center\">            \r\n  <v:image xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; width:450pt; height:0pt; background-repeat:no-repeat;\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" ></v:image>            \r\n  <v:rect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; position: absolute; width:450pt; height:0pt;  background-repeat:no-repeat;\">            \r\n  <v:fill type=\"frame\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" color=\"#6b7dfb\" ></v:fill>            \r\n  <![endif]-->\r\n              <!--[if gte mso 9]>            \r\n  </v:fill>            \r\n  </v:rect>            \r\n  </v:image>            \r\n  </td></tr>            \r\n  <![endif]-->\r\n            </table>\r\n          <p></p></td>\r\n        </tr>\r\n        <!--END LAYOUT-3 ( SET-1 )-->\r\n        <!--START LAYOUT-4 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td valign=\"top\">\r\n                                    <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td align=\"left\" style=\"word-break: break-word; line-height: 110%;\">\r\n                                            <span style=\"color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; font-size: 16px; font-weight: 400; font-style: normal; line-height: 24px;\">Hello\r\n                                              {{SalonOwner}},</span><br><br><font color=\"#333333\" face=\"Open Sans, Arial, Helvetica, sans-serif\"><span style=\"font-size: 24px;\"><b>Appointment Created</b></span></font></td>\r\n                                        </tr><!-- start space -->\r\n                                        <tr>\r\n                                          <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr><!-- end space -->\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </td>\r\n                                </tr>\r\n                                <tr>\r\n                                  <td align=\"left\" style=\"font-size: 14px; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">An appointment is booked by {{UserName}} on {{Date}} at {{Time}} by {{EmployeeName}} with {{SalonName}}. <br>Booking id is {{BookingId}}.<br><br>Thank you for register your salon with us.<br>From {{AppName}}</td>\r\n                                </tr><!-- start space -->\r\n                                <tr>\r\n                                  <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;fd</td>\r\n                                </tr><!-- end space -->\r\n\r\n\r\n\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-4 ( SET-1 )-->\r\n        <!--START LAYOUT-5 ( serrated )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"560\" style=\"width: 560px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/divider-3.png\" width=\"560\" style=\"display: block !important; width: 100%; max-width: 560px; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\"></a> </td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-5 ( serrated )-->\r\n        <!--START LAYOUT-6 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-6 ( SET-1 )-->\r\n        <!--START LAYOUT-9 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" width=\"160\" style=\"max-width: 160px; width: 160px; height: auto; display: block !important; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\" height=\"auto\"></a> </td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-9 ( SET-1 )-->\r\n        <!--START LAYOUT-11 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #f1f1f1;\" bgcolor=\"#f1f1f1\">\r\n            <!-- start container -->\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #f1f1f1; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <!-- start space -->\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                        <tr>\r\n                          <td valign=\"middle\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" style=\"font-size: 14px; color: #888888; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">\r\n                                    <span style=\"color: #888888; text-decoration: none; font-style: normal; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;\">\r\n                                      © Copyright 2021&nbsp; {{AppName}} . All Rights Reserved </span></td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr><!-- start space -->\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table><!-- end container -->\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-11 ( SET-1 )-->\r\n      </tbody>\r\n    </table>', 'Dear {{SalonOwner}}, An Appointment is created by {{UserName}} at {{Date}}, {{Time}} in {{SalonName}} at {{BookingAt}}. Service by {{EmployeeName}}.  Booking id is {{BookingId}}. from {{AppName}}', '2020-09-11 06:30:13', '2021-05-05 10:53:47');
INSERT INTO `template` (`id`, `title`, `subject`, `mail_content`, `msg_content`, `created_at`, `updated_at`) VALUES
(7, 'Employee Appointment', 'Appointment Created', '<table id=\"mainStructure\" class=\"full-width\" width=\"800\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #ffffff; max-width: 800px; outline: #efefef solid 1px; box-shadow: #e0e0e0 0px 0px 30px 5px; margin: 0px auto;\">\r\n      <!-- START LAYOUT-1 ( SET-1 )-->\r\n      <tbody>\r\n        <tr>\r\n          <td valign=\"top\" align=\"center\" style=\"background-color: #f85954;\" bgcolor=\"#f85954\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #f85954; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" class=\"full-width\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr><!-- END LAYOUT-1 ( SET-1 )-->\r\n        <!--START LAYOUT-2 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #ffffff;\" bgcolor=\"#ffffff\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr class=\"row\" style=\"display: flex; text-align: center;\">\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\">\r\n                                                        <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" data-filename=\"black_logo.png\" width=\"160\" style=\"max-width: 160px; height: auto; display: block !important; min-width: 100%;\" alt=\"logo-top\" border=\"0\" hspace=\"0\" vspace=\"0\" height=\"auto\">\r\n                                                      \r\n                                                      </a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important; margin: auto;\" class=\"full-block\">\r\n                                    <table width=\"20\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" class=\"full-width\" style=\"border-spacing: 0px; max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\" align=\"center\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.facebook.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-facebook2.png\" width=\"25\" alt=\"facebook\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.twitter.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-twitter2.png\" width=\"25\" alt=\"twitter\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.instagram.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-instagram2.png\" width=\"25\" alt=\"instagram\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-2 ( SET-1 )-->\r\n        <!--START LAYOUT-3 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\"><p><br></p><p>\r\n            </p><table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background:url(https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png);background-position: 0% 100%; background-size: auto; background-color: #6b7dfb; background-repeat: no-repeat; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\" background=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" height=\"0\">\r\n              <!--[if gte mso 9]>            \r\n  <tr><td valign=\"top\" align=\"center\">            \r\n  <v:image xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; width:450pt; height:0pt; background-repeat:no-repeat;\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" ></v:image>            \r\n  <v:rect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; position: absolute; width:450pt; height:0pt;  background-repeat:no-repeat;\">            \r\n  <v:fill type=\"frame\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" color=\"#6b7dfb\" ></v:fill>            \r\n  <![endif]-->\r\n              <!--[if gte mso 9]>            \r\n  </v:fill>            \r\n  </v:rect>            \r\n  </v:image>            \r\n  </td></tr>            \r\n  <![endif]-->\r\n            </table>\r\n          <p></p></td>\r\n        </tr>\r\n        <!--END LAYOUT-3 ( SET-1 )-->\r\n        <!--START LAYOUT-4 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td valign=\"top\">\r\n                                    <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td align=\"left\" style=\"word-break: break-word; line-height: 110%;\">\r\n                                            <span style=\"color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; font-size: 16px; font-weight: 400; font-style: normal; line-height: 24px;\">Hello {{EmployeeName}},</span><br><br><font color=\"#333333\" face=\"Open Sans, Arial, Helvetica, sans-serif\"><span style=\"font-size: 24px;\"><b>Appointment Created</b></span></font></td>\r\n                                        </tr><!-- start space -->\r\n                                        <tr>\r\n                                          <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr><!-- end space -->\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </td>\r\n                                </tr>\r\n                                <tr>\r\n                                  <td align=\"left\" style=\"font-size: 14px; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">An appointment is booked by {{UserName}} on {{Date}} at {{Time}}&nbsp; with {{SalonName}}. <br>Booking id is {{BookingId}}.<br><br>From {{AppName}}</td>\r\n                                </tr><!-- start space -->\r\n                                <tr>\r\n                                  <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;fd</td>\r\n                                </tr><!-- end space -->\r\n\r\n\r\n\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-4 ( SET-1 )-->\r\n        <!--START LAYOUT-5 ( serrated )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"560\" style=\"width: 560px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/divider-3.png\" width=\"560\" style=\"display: block !important; width: 100%; max-width: 560px; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\"></a> </td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-5 ( serrated )-->\r\n        <!--START LAYOUT-6 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-6 ( SET-1 )-->\r\n        <!--START LAYOUT-9 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" width=\"160\" style=\"max-width: 160px; width: 160px; height: auto; display: block !important; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\" height=\"auto\"></a> </td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-9 ( SET-1 )-->\r\n        <!--START LAYOUT-11 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #f1f1f1;\" bgcolor=\"#f1f1f1\">\r\n            <!-- start container -->\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #f1f1f1; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <!-- start space -->\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                        <tr>\r\n                          <td valign=\"middle\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" style=\"font-size: 14px; color: #888888; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">\r\n                                    <span style=\"color: #888888; text-decoration: none; font-style: normal; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;\">\r\n                                      © Copyright 2021&nbsp; {{AppName}} . All Rights Reserved </span></td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr><!-- start space -->\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table><!-- end container -->\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-11 ( SET-1 )-->\r\n      </tbody>\r\n    </table>', 'Dear {{EmployeeName}}, An Appointment is created by {{UserName}} at {{Date}}, {{Time}} in {{SalonName}} at {{BookingAt}}.  Booking id is {{BookingId}}. from {{AppName}}', '2020-12-21 03:51:21', '2021-05-05 10:54:09'),
(8, 'Employee booking status', 'Employee booking status', '<table id=\"mainStructure\" class=\"full-width\" width=\"800\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #ffffff; max-width: 800px; outline: #efefef solid 1px; box-shadow: #e0e0e0 0px 0px 30px 5px; margin: 0px auto;\">\r\n      <!-- START LAYOUT-1 ( SET-1 )-->\r\n      <tbody>\r\n        <tr>\r\n          <td valign=\"top\" align=\"center\" style=\"background-color: #f85954;\" bgcolor=\"#f85954\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color: #f85954; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" class=\"full-width\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr><!-- END LAYOUT-1 ( SET-1 )-->\r\n        <!--START LAYOUT-2 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #ffffff;\" bgcolor=\"#ffffff\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr class=\"row\" style=\"display: flex; text-align: center;\">\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\">\r\n                                                        <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" data-filename=\"black_logo.png\" width=\"160\" style=\"max-width: 160px; height: auto; display: block !important; min-width: 100%;\" alt=\"logo-top\" border=\"0\" hspace=\"0\" vspace=\"0\" height=\"auto\">\r\n                                                      \r\n                                                      </a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important; margin: auto;\" class=\"full-block\">\r\n                                    <table width=\"20\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" class=\"full-width\" style=\"border-spacing: 0px; max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\" align=\"center\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                  <th valign=\"middle\" align=\"center\" style=\"display: inline !important;\" class=\"full-block\">\r\n                                    <table width=\"auto\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"full-width\" style=\"max-width: 100%; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td valign=\"top\">\r\n                                            <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                                              <tbody>\r\n                                                <tr>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.facebook.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-facebook2.png\" width=\"25\" alt=\"facebook\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.twitter.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-twitter2.png\" width=\"25\" alt=\"twitter\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                  <td align=\"center\" valign=\"middle\" style=\"padding-left: 3px; padding-right: 3px; width: 25px; line-height: 0px;\" width=\"25\"> <a href=\"https://www.instagram.com/\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/icon-instagram2.png\" width=\"25\" alt=\"instagram\" style=\"max-width: 25px; display: block !important;\"></a> </td>\r\n                                                </tr>\r\n                                              </tbody>\r\n                                            </table>\r\n                                          </td>\r\n                                        </tr>\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </th>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-2 ( SET-1 )-->\r\n        <!--START LAYOUT-3 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\"><p><br></p><p>\r\n            </p><table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background:url(https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png);background-position: 0% 100%; background-size: auto; background-color: #6b7dfb; background-repeat: no-repeat; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\" background=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" height=\"0\">\r\n              <!--[if gte mso 9]>            \r\n  <tr><td valign=\"top\" align=\"center\">            \r\n  <v:image xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; width:450pt; height:0pt; background-repeat:no-repeat;\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" ></v:image>            \r\n  <v:rect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" fill=\"true\" stroke=\"false\" style=\"border: 0; display: inline-block; position: absolute; width:450pt; height:0pt;  background-repeat:no-repeat;\">            \r\n  <v:fill type=\"frame\" src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/bg1.png\" color=\"#6b7dfb\" ></v:fill>            \r\n  <![endif]-->\r\n              <!--[if gte mso 9]>            \r\n  </v:fill>            \r\n  </v:rect>            \r\n  </v:image>            \r\n  </td></tr>            \r\n  <![endif]-->\r\n            </table>\r\n          <p></p></td>\r\n        </tr>\r\n        <!--END LAYOUT-3 ( SET-1 )-->\r\n        <!--START LAYOUT-4 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td valign=\"top\">\r\n                                    <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto; min-width: 100%;\" role=\"presentation\">\r\n                                      <tbody>\r\n                                        <tr>\r\n                                          <td align=\"left\" style=\"word-break: break-word; line-height: 110%;\">\r\n                                            <span style=\"color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; font-size: 16px; font-weight: 400; font-style: normal; line-height: 24px;\">Hello\r\n                                              {{EmployeeName}},</span><br><br><b style=\"color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; font-size: 24px;\">Booking&nbsp;</b><font color=\"#333333\" face=\"Open Sans, Arial, Helvetica, sans-serif\"><span style=\"font-size: 24px;\"><b>{{BookingStatus}}</b></span></font></td>\r\n                                        </tr><!-- start space -->\r\n                                        <tr>\r\n                                          <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">\r\n                                            &nbsp;</td>\r\n                                        </tr><!-- end space -->\r\n                                      </tbody>\r\n                                    </table>\r\n                                  </td>\r\n                                </tr>\r\n                                <tr>\r\n                                  <td align=\"left\" style=\"font-size: 14px; color: rgb(136, 136, 136); font-family: &quot;Open Sans&quot;, Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\"><span style=\"font-weight: normal;\">An appointment of </span><b>{{UserName}}</b><span style=\"font-weight: normal;\"> on {{Date}} at {{Time}} in </span><b>{{SalonName}}</b> is now&nbsp;<b>{{BookingStatus}}</b>. <br><br>Booking id is&nbsp;<b>{{BookingId}}</b>.</td>\r\n                                </tr><!-- start space -->\r\n                                <tr>\r\n                                  <td valign=\"top\" height=\"20\" style=\"height: 20px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;fd</td>\r\n                                </tr><!-- end space -->\r\n\r\n\r\n\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-4 ( SET-1 )-->\r\n        <!--START LAYOUT-5 ( serrated )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"560\" style=\"width: 560px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://gallery.mailbuild.app/item/ZnfnzacG/images/divider-3.png\" width=\"560\" style=\"display: block !important; width: 100%; max-width: 560px; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\"></a> </td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-5 ( serrated )-->\r\n        <!--START LAYOUT-6 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\"></table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-6 ( SET-1 )-->\r\n        <!--START LAYOUT-9 ( SET-1 ) -->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color:#f1f1f1; \" bgcolor=\"#f1f1f1\">\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" valign=\"top\" class=\"image-full-width\" width=\"160\" style=\"width: 160px; line-height: 0px;\"> <a href=\"#\" style=\"text-decoration: none !important; font-size: inherit; border-style: none;\" border=\"0\"> <img src=\"https://saasmonks.in/App-Demo/thebarber-V2/public/storage/images/app/black_logo.png\" width=\"160\" style=\"max-width: 160px; width: 160px; height: auto; display: block !important; min-width: 100%;\" vspace=\"0\" hspace=\"0\" alt=\"image\" height=\"auto\"></a> </td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"50\" style=\"height: 50px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr>\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table>\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-9 ( SET-1 )-->\r\n        <!--START LAYOUT-11 ( SET-1 )-->\r\n        <tr>\r\n          <td align=\"center\" valign=\"top\" style=\"background-color: #f1f1f1;\" bgcolor=\"#f1f1f1\">\r\n            <!-- start container -->\r\n            <table width=\"600\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"full-width\" style=\"background-color: #f1f1f1; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;\" role=\"presentation\">\r\n              <tbody>\r\n                <tr>\r\n                  <td valign=\"top\">\r\n                    <table width=\"560\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"full-width\" style=\"margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;\" role=\"presentation\">\r\n                      <!-- start space -->\r\n                      <tbody>\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                        <tr>\r\n                          <td valign=\"middle\">\r\n                            <table width=\"auto\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;\" role=\"presentation\">\r\n                              <tbody>\r\n                                <tr>\r\n                                  <td align=\"center\" style=\"font-size: 14px; color: #888888; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 140%;\">\r\n                                    <span style=\"color: #888888; text-decoration: none; font-style: normal; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;\">\r\n                                      © Copyright 2021&nbsp; {{AppName}} . All Rights Reserved </span></td>\r\n                                </tr>\r\n                              </tbody>\r\n                            </table>\r\n                          </td>\r\n                        </tr><!-- start space -->\r\n                        <tr>\r\n                          <td valign=\"top\" height=\"25\" style=\"height: 25px; font-size: 0px; line-height: 0;\" aria-hidden=\"true\">&nbsp;</td>\r\n                        </tr><!-- end space -->\r\n                      </tbody>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </tbody>\r\n            </table><!-- end container -->\r\n          </td>\r\n        </tr>\r\n        <!--END LAYOUT-11 ( SET-1 )-->\r\n      </tbody>\r\n    </table>', 'Dear {{EmployeeName}}, An appointment of {{UserName}} on {{Date}} at {{Time}} in {{SalonName}} in {{BookingAt}} is now {{BookingStatus}}. Booking id is {{BookingId}}.  Thank you. From {{AppName}}.', '2020-12-21 06:03:42', '2021-05-05 10:54:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'noimage.jpg',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` mediumint(9) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `role` tinyint(4) NOT NULL DEFAULT 3,
  `verify` tinyint(1) NOT NULL DEFAULT 0,
  `device_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'English',
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification` tinyint(1) NOT NULL DEFAULT 1,
  `mail` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `image`, `email`, `otp`, `added_by`, `email_verified_at`, `password`, `code`, `phone`, `status`, `role`, `verify`, `device_token`, `language`, `provider`, `provider_token`, `notification`, `mail`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Main Admin', 'noimage.jpg', 'admin@gmail.com', NULL, NULL, NULL, '$2y$10$xY6Ejw1d68yqkWSZZadnQu6YppZZpQAjibZH16L7QW8AaqTYvpAJy', '+91', '0918273626', 1, 1, 1, NULL, 'English', '', NULL, 1, 1, NULL, '2021-05-06 05:04:23', '2021-05-06 05:04:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `adminsetting`
--
ALTER TABLE `adminsetting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_notification`
--
ALTER TABLE `app_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gallery_id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `paymentsetting`
--
ALTER TABLE `paymentsetting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `salon`
--
ALTER TABLE `salon`
  ADD PRIMARY KEY (`salon_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adminsetting`
--
ALTER TABLE `adminsetting`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_notification`
--
ALTER TABLE `app_notification`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `coupon_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gallery_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paymentsetting`
--
ALTER TABLE `paymentsetting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salon`
--
ALTER TABLE `salon`
  MODIFY `salon_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
