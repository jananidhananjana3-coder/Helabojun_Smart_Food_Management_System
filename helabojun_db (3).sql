-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2026 at 09:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helabojun_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_query`
--

CREATE TABLE `ai_query` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `query` text NOT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Traditional Foods', 'Sri Lankan traditional food items', '2026-07-16 01:00:33', '2026-07-16 01:00:33'),
(3, 'Beverages', 'Fresh juices and drinks', '2026-08-07 04:23:18', '2026-08-07 04:23:18'),
(4, 'Rice & Meals', 'Rice based meals', '2026-08-07 04:23:18', '2026-08-07 04:23:18'),
(5, 'Hoppers & Breakfast', 'Hoppers, String hoppers, Dosa, Idli', '2026-08-07 04:23:18', '2026-08-07 04:23:18'),
(6, 'Healthy Foods', 'Fruit salad and healthy items', '2026-08-07 04:23:18', '2026-08-07 04:23:18'),
(7, 'Traditional Sweets', 'Sri Lankan sweets', '2026-08-07 04:23:18', '2026-08-07 04:23:18'),
(8, 'Desserts', 'Ice cream and desserts', '2026-08-07 04:23:18', '2026-08-07 04:23:18'),
(9, 'Snacks', 'Short eats and snacks', '2026-08-07 04:23:18', '2026-08-07 04:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `counters`
--

CREATE TABLE `counters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `counter_name` varchar(255) NOT NULL,
  `counter_number` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `counters`
--

INSERT INTO `counters` (`id`, `outlet_id`, `counter_name`, `counter_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Counter 1', '1', 'active', NULL, NULL),
(2, 2, 'Counter 2', '2', 'active', NULL, NULL),
(3, 2, 'Counter 3', '3', 'active', NULL, NULL),
(4, 2, 'Counter 4', '4', 'active', NULL, NULL),
(5, 2, 'Counter 5', '5', 'active', NULL, NULL),
(6, 2, 'Counter 6', '6', 'active', NULL, NULL),
(7, 2, 'Counter 7', '7', 'active', NULL, NULL),
(8, 2, 'Counter 8', '8', 'active', NULL, NULL),
(9, 2, 'Counter 9', '9', 'active', NULL, NULL),
(11, 2, 'Counter 10', '10', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `available_quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `category_id`, `outlet_id`, `food_name`, `description`, `price`, `image`, `available_quantity`, `created_at`, `updated_at`) VALUES
(5, 2, 2, 'String hoppers', 'Counter NO 2 , 3 4', 20.00, 'foods/shPRbDZ3G0x26GWMAvyofgpelIcTLS89ePNH01BV.jpg', 0, '2026-07-19 10:03:04', '2026-08-19 23:08:30'),
(6, 2, 2, 'Hoppers', NULL, 20.00, 'foods/XtfhYnktgV072NBWJ1pSEIcC1gs64dwVJQfPnbjH.jpg', 10, '2026-08-05 04:39:34', '2026-08-05 04:39:34'),
(13, 3, 2, 'Avacado Juice', NULL, 80.00, 'foods/2hztvOpy6rX9eNChY60rMokAqwIOMmgMOjEan6gb.jpg', 1, '2026-08-06 23:00:06', '2026-08-07 00:07:01'),
(15, 4, 2, 'Rice and Curry', NULL, 350.00, 'foods/smqhj7Jj20A4odH6QO6vtG07sjo5JCCuhVik6S7q.jpg', 12, '2026-08-07 00:04:53', '2026-08-07 00:04:53'),
(16, 7, 2, 'Udu walalu', NULL, 50.00, 'foods/XpUnWEW4h8MTNG0A39HOk0v51IBZMY3kWVcVhhfN.jpg', 3, '2026-08-07 00:05:36', '2026-08-07 00:05:36'),
(17, 7, 2, 'Halapa', NULL, 60.00, 'foods/s5LaA0mvFuTZWxsevEmszyT9kr4fyz05xPpzqPPK.jpg', 2, '2026-08-07 00:06:35', '2026-08-07 00:06:35'),
(18, 3, 2, 'Mango Juice', NULL, 80.00, 'foods/TReaT8o2jiDDzussQmzMejwqMF66HrPWnvzuDtfw.jpg', 2, '2026-08-07 00:07:20', '2026-08-07 00:07:35'),
(19, 3, 2, 'Watermelon Juice', NULL, 80.00, 'foods/PmFHE3dRlBDS1t3bkmcH8rOx1yjp0PLzaYrWNggy.jpg', 2, '2026-08-07 00:08:01', '2026-08-07 03:46:56'),
(20, 2, 2, 'Pittu', NULL, 60.00, 'foods/PlVWgA2TS1ExrcjE3co27ouUD4GZ7w6ExOGckis3.jpg', 6, '2026-08-07 00:08:40', '2026-08-07 00:08:40'),
(21, 7, 2, 'Aggala', NULL, 50.00, 'foods/NLCvUjUjISYdAd7YaKKc04IEg96lHRHZLvXaucog.jpg', 4, '2026-08-07 00:10:02', '2026-08-07 00:10:02'),
(22, 4, 2, 'Kiribath', NULL, 25.00, 'foods/45YLo43jVdZiHfOegGxe7DB4lj5LrhThstz5L6Fn.jpg', 1, '2026-08-07 00:10:48', '2026-08-07 00:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `food_counter`
--

CREATE TABLE `food_counter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `food_id` bigint(20) UNSIGNED NOT NULL,
  `counter_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food_counter`
--

INSERT INTO `food_counter` (`id`, `food_id`, `counter_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 19, 1, 4, '2026-08-19 23:02:21', '2026-08-21 04:16:17'),
(2, 18, 1, 10, '2026-08-19 23:02:34', '2026-08-21 02:27:42'),
(3, 13, 1, 10, '2026-08-19 23:02:44', '2026-08-21 02:27:38'),
(4, 22, 2, 14, '2026-08-19 23:08:02', '2026-08-20 02:27:32'),
(5, 5, 2, 16, '2026-08-19 23:08:30', '2026-08-20 02:27:58'),
(6, 21, 2, 5, '2026-08-19 23:08:41', '2026-08-20 02:26:52'),
(7, 21, 3, 10, '2026-08-19 23:13:11', '2026-08-21 03:25:43'),
(8, 20, 3, 17, '2026-08-19 23:13:20', '2026-08-20 04:13:05'),
(9, 16, 3, 6, '2026-08-19 23:13:33', '2026-08-21 03:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `kitchen_tickets`
--

CREATE TABLE `kitchen_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `counter_id` bigint(20) UNSIGNED NOT NULL,
  `chef_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('waiting','cooking','completed') NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kitchen_tickets`
--

INSERT INTO `kitchen_tickets` (`id`, `order_id`, `counter_id`, `chef_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 3, 1, 18, 'completed', '2026-08-20 00:42:48', '2026-08-20 11:37:35'),
(3, 4, 1, 18, 'completed', '2026-08-20 00:44:13', '2026-08-20 11:37:35'),
(4, 5, 1, 18, 'completed', '2026-08-20 00:45:42', '2026-08-20 11:37:35'),
(7, 8, 0, NULL, 'waiting', '2026-08-20 03:55:59', '2026-08-20 03:55:59'),
(8, 9, 0, NULL, 'waiting', '2026-08-20 04:27:57', '2026-08-20 04:27:57'),
(9, 10, 0, NULL, 'waiting', '2026-08-20 04:30:07', '2026-08-20 04:30:07'),
(10, 11, 1, 18, 'completed', '2026-08-20 04:41:25', '2026-08-20 11:37:35'),
(11, 12, 2, 19, 'completed', '2026-08-20 05:05:35', '2026-08-20 11:37:35'),
(12, 13, 2, 19, 'completed', '2026-08-20 09:48:44', '2026-08-20 13:30:30'),
(16, 15, 1, 18, 'completed', '2026-08-20 13:10:40', '2026-08-20 13:11:21'),
(20, 17, 1, 18, 'cooking', '2026-08-21 03:10:12', '2026-08-21 03:11:15'),
(21, 18, 1, NULL, 'waiting', '2026-08-21 03:22:13', '2026-08-21 03:22:13'),
(22, 18, 2, 19, 'cooking', '2026-08-21 03:22:13', '2026-08-21 03:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_07_07_044805_add_phone_and_role_to_users_table', 1),
(6, '2026_07_07_060946_create_outlets_table', 1),
(7, '2026_07_07_061430_create_categories_table', 1),
(8, '2026_07_07_061650_create_foods_table', 1),
(9, '2026_07_07_061930_create_orders_table', 1),
(10, '2026_07_07_062149_create_order_items_table', 1),
(11, '2026_07_07_063852_create_kitchen_tickets_table', 1),
(12, '2026_07_07_083225_create_counters_table', 1),
(13, '2026_07_07_083414_create_payments_table', 1),
(14, '2026_07_07_083647_create_queue_displays_table', 1),
(15, '2026_07_07_083953_create_ai_query_table', 1),
(16, '2026_07_07_084157_create_notifications_table', 1),
(17, '2026_07_14_033402_add_outlet_id_to_users_table', 2),
(18, '2026_07_16_033044_add_outlet_id_to_foods_table', 3),
(19, '2026_07_20_062205_add_counter_number_to_counters_table', 4),
(23, '2026_07_20_062447_add_counter_id_to_users_table', 5),
(24, '2026_07_31_204113_add_verification_code_to_users_table', 5),
(25, '2026_08_03_055749_add_counter_id_to_orders_table', 5),
(26, '2026_08_05_054118_add_cash_received_and_change_amount_to_payments_table', 6),
(27, '2026_08_07_060944_add_profile_image_to_users_table', 7),
(28, '2026_08_07_061436_add_nic_number_and_join_date_to_users_table', 8),
(29, '2026_08_11_043851_add_counter_id_to_order_items_table', 9),
(30, '2026_08_11_061031_create_food_counter_table', 10),
(31, '2026_08_11_070613_add_chef_profile_fields_to_users_table', 11),
(32, '2026_08_15_115137_add_counter_and_order_fields_to_orders_table', 12),
(33, '2026_08_18_055923_add_google_maps_to_outlets_table', 13),
(34, '2026_08_18_060636_add_qr_payment_method', 14),
(35, '2026_08_18_061148_add_accepted_order_status', 15),
(36, '2026_08_20_164747_add_counter_id_to_queue_displays_table', 16),
(37, '2026_08_20_193127_add_kitchen_ticket_and_counter_to_queue_displays_table', 17),
(38, '2026_08_21_065046_update_queue_displays_status_enum', 18);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` bigint(20) UNSIGNED NOT NULL,
  `counter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_type` enum('dine_in','take_away') NOT NULL DEFAULT 'dine_in',
  `token_number` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','accepted','preparing','ready','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','paid') NOT NULL DEFAULT 'paid',
  `payment_method` varchar(255) DEFAULT NULL,
  `cash_received` decimal(10,2) NOT NULL DEFAULT 0.00,
  `change_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `outlet_id`, `counter_id`, `order_type`, `token_number`, `total_amount`, `discount`, `grand_total`, `status`, `payment_status`, `payment_method`, `cash_received`, `change_amount`, `created_at`, `updated_at`) VALUES
(3, 21, 2, 1, 'dine_in', 'HB-0001', 320.00, 0.00, 320.00, 'completed', 'paid', 'cash', 1000.03, 680.03, '2026-08-20 00:42:48', '2026-08-20 04:06:36'),
(4, 21, 2, 1, 'dine_in', 'HB-0004', 240.00, 0.00, 240.00, 'completed', 'paid', 'card', 240.00, 0.00, '2026-08-20 00:44:13', '2026-08-20 04:05:57'),
(5, 21, 2, 1, 'dine_in', 'HB-0005', 320.00, 0.00, 320.00, 'completed', 'paid', 'cash', 1000.00, 680.00, '2026-08-20 00:45:42', '2026-08-20 04:43:33'),
(8, 21, 2, NULL, 'dine_in', 'HB-0006', 515.00, 0.00, 515.00, 'pending', 'paid', 'cash', 1000.00, 485.00, '2026-08-20 03:55:59', '2026-08-20 03:55:59'),
(9, 21, 2, NULL, 'dine_in', 'HB-0009', 605.00, 0.00, 605.00, 'pending', 'paid', 'cash', 1000.00, 395.00, '2026-08-20 04:27:57', '2026-08-20 04:27:57'),
(10, 21, 2, NULL, 'dine_in', 'HB-0010', 930.00, 0.00, 930.00, 'pending', 'paid', 'cash', 1000.00, 70.00, '2026-08-20 04:30:07', '2026-08-20 04:30:07'),
(11, 21, 2, 1, 'dine_in', 'HB-0011', 340.00, 0.00, 340.00, 'completed', 'paid', 'cash', 500.00, 160.00, '2026-08-20 04:41:25', '2026-08-20 05:00:54'),
(12, 21, 2, 2, 'dine_in', 'HB-0012', 390.00, 0.00, 390.00, 'completed', 'paid', 'cash', 1000.00, 610.00, '2026-08-20 05:05:35', '2026-08-20 09:51:05'),
(13, 21, 2, 2, 'dine_in', 'HB-0013', 390.00, 0.00, 390.00, 'ready', 'paid', 'cash', 1000.00, 610.00, '2026-08-20 09:48:44', '2026-08-20 13:30:30'),
(15, 21, 2, 1, 'dine_in', 'HB-0015', 480.00, 0.00, 480.00, 'ready', 'paid', 'cash', 1000.00, 520.00, '2026-08-20 13:10:40', '2026-08-20 13:11:21'),
(17, 21, 2, 1, 'dine_in', 'HB-0016', 160.00, 0.00, 160.00, 'preparing', 'paid', 'cash', 200.00, 40.00, '2026-08-21 03:10:12', '2026-08-21 03:11:15'),
(18, 21, 2, 1, 'dine_in', 'HB-0018', 130.00, 0.00, 130.00, 'preparing', 'paid', 'cash', 159.00, 29.00, '2026-08-21 03:22:13', '2026-08-21 03:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `food_id` bigint(20) UNSIGNED NOT NULL,
  `counter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `food_id`, `counter_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(3, 3, 13, 1, 1, 80.00, '2026-08-20 00:42:48', '2026-08-20 00:42:48'),
(4, 3, 18, 1, 1, 80.00, '2026-08-20 00:42:48', '2026-08-20 00:42:48'),
(5, 3, 19, 1, 2, 80.00, '2026-08-20 00:42:48', '2026-08-20 00:42:48'),
(6, 4, 13, 1, 1, 80.00, '2026-08-20 00:44:13', '2026-08-20 00:44:13'),
(7, 4, 18, 1, 1, 80.00, '2026-08-20 00:44:13', '2026-08-20 00:44:13'),
(8, 4, 19, 1, 1, 80.00, '2026-08-20 00:44:13', '2026-08-20 00:44:13'),
(9, 5, 13, 1, 2, 80.00, '2026-08-20 00:45:42', '2026-08-20 00:45:42'),
(10, 5, 18, 1, 2, 80.00, '2026-08-20 00:45:42', '2026-08-20 00:45:42'),
(19, 8, 19, 1, 2, 80.00, '2026-08-20 03:55:59', '2026-08-20 03:55:59'),
(20, 8, 22, 2, 1, 25.00, '2026-08-20 03:55:59', '2026-08-20 03:55:59'),
(21, 8, 21, 2, 5, 50.00, '2026-08-20 03:55:59', '2026-08-20 03:55:59'),
(22, 8, 18, 1, 1, 80.00, '2026-08-20 03:55:59', '2026-08-20 03:55:59'),
(23, 9, 18, 1, 2, 80.00, '2026-08-20 04:27:57', '2026-08-20 04:27:57'),
(24, 9, 22, 2, 1, 25.00, '2026-08-20 04:27:57', '2026-08-20 04:27:57'),
(25, 9, 16, 3, 2, 50.00, '2026-08-20 04:27:57', '2026-08-20 04:27:57'),
(26, 9, 13, 1, 4, 80.00, '2026-08-20 04:27:57', '2026-08-20 04:27:57'),
(27, 10, 19, 1, 2, 80.00, '2026-08-20 04:30:07', '2026-08-20 04:30:07'),
(28, 10, 18, 1, 4, 80.00, '2026-08-20 04:30:07', '2026-08-20 04:30:07'),
(29, 10, 16, 3, 5, 50.00, '2026-08-20 04:30:07', '2026-08-20 04:30:07'),
(30, 10, 21, 2, 4, 50.00, '2026-08-20 04:30:07', '2026-08-20 04:30:07'),
(31, 11, 19, 1, 3, 80.00, '2026-08-20 04:41:25', '2026-08-20 04:41:25'),
(32, 11, 21, 2, 2, 50.00, '2026-08-20 04:41:25', '2026-08-20 04:41:25'),
(33, 12, 5, 2, 1, 20.00, '2026-08-20 05:05:35', '2026-08-20 05:05:35'),
(34, 12, 20, 3, 2, 60.00, '2026-08-20 05:05:35', '2026-08-20 05:05:35'),
(35, 12, 21, 2, 5, 50.00, '2026-08-20 05:05:35', '2026-08-20 05:05:35'),
(36, 13, 21, 2, 3, 50.00, '2026-08-20 09:48:44', '2026-08-20 09:48:44'),
(37, 13, 19, 1, 1, 80.00, '2026-08-20 09:48:44', '2026-08-20 09:48:44'),
(38, 13, 18, 1, 1, 80.00, '2026-08-20 09:48:44', '2026-08-20 09:48:44'),
(39, 13, 13, 1, 1, 80.00, '2026-08-20 09:48:44', '2026-08-20 09:48:44'),
(47, 15, 19, 1, 6, 80.00, '2026-08-20 13:10:40', '2026-08-20 13:10:40'),
(55, 17, 19, 1, 2, 80.00, '2026-08-21 03:10:12', '2026-08-21 03:10:12'),
(56, 18, 19, 1, 1, 80.00, '2026-08-21 03:22:13', '2026-08-21 03:22:13'),
(57, 18, 22, 2, 2, 25.00, '2026-08-21 03:22:13', '2026-08-21 03:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `outlets`
--

CREATE TABLE `outlets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `outlet_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `google_maps_url` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outlets`
--

INSERT INTO `outlets` (`id`, `outlet_name`, `location`, `contact_number`, `google_maps_url`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Helabojun', 'Peradeniya', '081222222', NULL, 'active', '2026-07-16 03:07:46', '2026-08-19 13:55:16');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','card','qr') NOT NULL DEFAULT 'cash',
  `payment_status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `cash_received` decimal(10,2) NOT NULL DEFAULT 0.00,
  `change_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `amount`, `payment_method`, `payment_status`, `cash_received`, `change_amount`, `created_at`, `updated_at`) VALUES
(3, 3, 320.00, 'cash', 'paid', 1000.03, 680.03, '2026-08-20 00:42:48', '2026-08-20 00:42:48'),
(4, 4, 240.00, 'card', 'paid', 240.00, 0.00, '2026-08-20 00:44:13', '2026-08-20 00:44:13'),
(5, 5, 320.00, 'cash', 'paid', 1000.00, 680.00, '2026-08-20 00:45:42', '2026-08-20 00:45:42'),
(8, 8, 515.00, 'cash', 'paid', 1000.00, 485.00, '2026-08-20 03:55:59', '2026-08-20 03:55:59'),
(9, 9, 605.00, 'cash', 'paid', 1000.00, 395.00, '2026-08-20 04:27:57', '2026-08-20 04:27:57'),
(10, 10, 930.00, 'cash', 'paid', 1000.00, 70.00, '2026-08-20 04:30:07', '2026-08-20 04:30:07'),
(11, 11, 340.00, 'cash', 'paid', 500.00, 160.00, '2026-08-20 04:41:25', '2026-08-20 04:41:25'),
(12, 12, 390.00, 'cash', 'paid', 1000.00, 610.00, '2026-08-20 05:05:35', '2026-08-20 05:05:35'),
(13, 13, 390.00, 'cash', 'paid', 1000.00, 610.00, '2026-08-20 09:48:44', '2026-08-20 09:48:44'),
(15, 15, 480.00, 'cash', 'paid', 1000.00, 520.00, '2026-08-20 13:10:40', '2026-08-20 13:10:40'),
(17, 17, 160.00, 'cash', 'paid', 200.00, 40.00, '2026-08-21 03:10:12', '2026-08-21 03:10:12'),
(18, 18, 130.00, 'cash', 'paid', 159.00, 29.00, '2026-08-21 03:22:13', '2026-08-21 03:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queue_displays`
--

CREATE TABLE `queue_displays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `kitchen_ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `counter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `queue_number` int(11) NOT NULL,
  `status` enum('waiting','ready','served') NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `queue_displays`
--

INSERT INTO `queue_displays` (`id`, `order_id`, `kitchen_ticket_id`, `counter_id`, `queue_number`, `status`, `created_at`, `updated_at`) VALUES
(7, 8, NULL, NULL, 4, 'waiting', '2026-08-20 03:55:59', '2026-08-20 03:55:59'),
(8, 9, NULL, NULL, 5, 'waiting', '2026-08-20 04:27:57', '2026-08-20 04:27:57'),
(9, 10, NULL, NULL, 6, 'waiting', '2026-08-20 04:30:07', '2026-08-20 04:30:07'),
(12, 13, NULL, NULL, 8, 'served', '2026-08-20 09:48:44', '2026-08-20 13:30:49'),
(14, 15, NULL, NULL, 10, 'served', '2026-08-20 13:10:40', '2026-08-20 13:26:50'),
(16, 17, NULL, NULL, 1, 'waiting', '2026-08-21 03:10:12', '2026-08-21 03:10:12'),
(17, 18, NULL, NULL, 2, 'waiting', '2026-08-21 03:22:13', '2026-08-21 03:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `nic_number` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `role` enum('admin','manager','cashier','chef') NOT NULL DEFAULT 'cashier',
  `outlet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `counter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `training_period` varchar(255) DEFAULT NULL,
  `food_specialties` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `verification_code`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `nic_number`, `birthday`, `address`, `join_date`, `profile_image`, `role`, `outlet_id`, `counter_id`, `training_period`, `food_specialties`) VALUES
(5, 'Janani', 'admin@gmail.com', NULL, '2026-07-31 16:22:20', '$2y$12$kxm9YK2K6GNF82dSiSkvOe0y1aP3OArqgzZWaC/H35xTx09UF4E7m', 'o58xr1vuQhu3poE5f8gnejO3fse27KW0RIOR9llOfWa5ovTv6HNCcu2s0pbm', '2026-07-31 15:40:24', '2026-08-07 02:58:34', '0770010102', '19909999888', NULL, 'Gannoruwa, Peradeniya', NULL, 'profile_images/1786090822.png', 'admin', NULL, NULL, NULL, NULL),
(9, 'Amaya Ratnakayake', 'a@gmail.com', NULL, '2026-08-07 05:14:19', '$2y$12$hTfb8OhP3AWn.QvrwbgxTOvVW.s9YD45fCLwfxDVD9Kjo8A2CJpGe', '5uk2JFHRHrXD2NLvUfSfZGakD1xPlbAwpCjgTCXzsx7rK2YmZq2WVK3gdOWB', '2026-08-07 05:13:29', '2026-08-07 05:14:19', '0710010101', '199754354353', '1997-12-31', 'Gannoruwa, Peradeniya', '2026-07-01', 'profile_images/1786099409.png', 'admin', NULL, NULL, NULL, NULL),
(16, 'Himasha Ratnayake', 'hr@gmail.com', '789483', '2026-08-15 09:33:02', '$2y$12$QMSVF95PhLSueFkqGs5fvOYWXpVOCzlwui4b.fsO1Krl6JWCABM7K', NULL, '2026-08-15 09:33:02', '2026-08-15 09:33:02', '0770010101', '199754354353', NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL),
(18, 'Chamodya Thennakoon', 'chamo@gamil.com', NULL, '2026-08-19 23:21:52', '$2y$12$uLdD23i0NiomAcLIdMchJOggPZoWJ3291M0bJWlumqFyKR272oXcy', 'Y6ovgqGAkf4O39TltEm6IF8ERv3BNC1VmL1WMzo7wsL2zspcIQh6nczUkhLR', '2026-08-19 23:01:43', '2026-08-19 23:21:52', '0751111111', '200080808080', '2000-04-14', 'Rajapihilla Mawatha, Kandy', '2026-02-24', 'profile_images/1787200303.jpg', 'chef', 2, 1, '2025.07.01 - 2026.02.01', 'Fruit Juice'),
(19, 'Avishka Herath', 'avi@gmail.com', NULL, '2026-08-20 02:25:31', '$2y$12$XeCgshK2tJgq721rveo3hu1tKnkcz73I0FYJldem01bBNY2Pgo/W2', NULL, '2026-08-19 23:07:40', '2026-08-20 02:25:31', '0761111111', '199787878787', '1997-12-31', 'Embilmeegama, Pilimatalawa', '2025-08-04', 'profile_images/1787200659.jpg', 'chef', 2, 2, '2024.12.25 - 2025.05.30', 'String Hoppers, Kiribath, Aggala'),
(20, 'Kavindi Fernando', 'kavi@gmail.com', NULL, '2026-08-20 04:12:30', '$2y$12$wMx6p0O7O1ACwHoRu.i/E.y3FoAGDq20Nay555enJebOcNV/VDamG', NULL, '2026-08-19 23:12:53', '2026-08-20 04:12:30', NULL, '199909090909', '2026-08-26', 'Mulgampola, Kandy', '2024-01-01', 'profile_images/1787200973.jpg', 'chef', 2, 3, '2023.07.03 - 2023.12.29', 'Aggala, Pittu, Unduwal'),
(21, 'Chamani Abeykoon', 'chami@gmail.com', NULL, '2026-08-19 23:56:22', '$2y$12$lAGIR/ZuOBzoReJ6rjFGseh4o2vYwjzyB0wBgFsZyP.bnd4XovYEi', 'fZHpa8vbzLZq7nYyCq1TJFkxmVKeQsmjKZrG5k9QAfIt0lOmmhqoW1Gadpu8', '2026-08-19 23:17:42', '2026-08-19 23:56:22', '0774545454', '19909999888', '1990-08-10', 'Gannoruwa, Peradeniya', '2023-01-02', 'profile_images/1787201262.jpg', 'cashier', 2, NULL, NULL, NULL),
(22, 'Kavishka Chamilini', 'kk@gmail.com', NULL, NULL, '$2y$12$Zh8uNgQ95K68ee.vY2Fd8usO1yDf61rMDiLqs9JyZ/BLg9mempF0C', NULL, '2026-08-19 23:20:02', '2026-08-19 23:20:18', '0707676767', '199509090909', NULL, 'Thennekumbura, Kandy', NULL, 'profile_images/1787201418.jpg', 'cashier', 2, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_query`
--
ALTER TABLE `ai_query`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ai_query_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counters`
--
ALTER TABLE `counters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `counters_outlet_id_foreign` (`outlet_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foods_category_id_foreign` (`category_id`),
  ADD KEY `foods_outlet_id_foreign` (`outlet_id`);

--
-- Indexes for table `food_counter`
--
ALTER TABLE `food_counter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `food_counter_food_id_counter_id_unique` (`food_id`,`counter_id`),
  ADD KEY `food_counter_counter_id_foreign` (`counter_id`);

--
-- Indexes for table `kitchen_tickets`
--
ALTER TABLE `kitchen_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kitchen_tickets_order_id_foreign` (`order_id`),
  ADD KEY `kitchen_tickets_chef_id_foreign` (`chef_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_outlet_id_foreign` (`outlet_id`),
  ADD KEY `orders_counter_id_foreign` (`counter_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_food_id_foreign` (`food_id`),
  ADD KEY `order_items_counter_id_foreign` (`counter_id`);

--
-- Indexes for table `outlets`
--
ALTER TABLE `outlets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `queue_displays`
--
ALTER TABLE `queue_displays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `queue_displays_order_id_foreign` (`order_id`),
  ADD KEY `queue_displays_counter_id_foreign` (`counter_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_outlet_id_foreign` (`outlet_id`),
  ADD KEY `users_counter_id_foreign` (`counter_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_query`
--
ALTER TABLE `ai_query`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `counters`
--
ALTER TABLE `counters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `food_counter`
--
ALTER TABLE `food_counter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kitchen_tickets`
--
ALTER TABLE `kitchen_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `outlets`
--
ALTER TABLE `outlets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue_displays`
--
ALTER TABLE `queue_displays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ai_query`
--
ALTER TABLE `ai_query`
  ADD CONSTRAINT `ai_query_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `counters`
--
ALTER TABLE `counters`
  ADD CONSTRAINT `counters_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `foods_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `food_counter`
--
ALTER TABLE `food_counter`
  ADD CONSTRAINT `food_counter_counter_id_foreign` FOREIGN KEY (`counter_id`) REFERENCES `counters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `food_counter_food_id_foreign` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kitchen_tickets`
--
ALTER TABLE `kitchen_tickets`
  ADD CONSTRAINT `kitchen_tickets_chef_id_foreign` FOREIGN KEY (`chef_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kitchen_tickets_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_counter_id_foreign` FOREIGN KEY (`counter_id`) REFERENCES `counters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_counter_id_foreign` FOREIGN KEY (`counter_id`) REFERENCES `counters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_food_id_foreign` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `queue_displays`
--
ALTER TABLE `queue_displays`
  ADD CONSTRAINT `queue_displays_counter_id_foreign` FOREIGN KEY (`counter_id`) REFERENCES `counters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `queue_displays_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_counter_id_foreign` FOREIGN KEY (`counter_id`) REFERENCES `counters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlets` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
