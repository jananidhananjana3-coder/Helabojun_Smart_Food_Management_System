-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2026 at 09:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
(5, 2, 2, 'String hoppers', 'Counter NO 2 , 3 4', 1.00, 'foods/shPRbDZ3G0x26GWMAvyofgpelIcTLS89ePNH01BV.jpg', 0, '2026-07-19 10:03:04', '2026-08-11 03:15:00'),
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

-- --------------------------------------------------------

--
-- Table structure for table `kitchen_tickets`
--

CREATE TABLE `kitchen_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `chef_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('waiting','cooking','completed') NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(35, '2026_08_18_061148_add_accepted_order_status', 15);

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
(2, 'Helabojun', 'Peradeniya', '09865443', NULL, 'active', '2026-07-16 03:07:46', '2026-07-16 03:11:39');

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
  `queue_number` int(11) NOT NULL,
  `status` enum('waiting','served') NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(5, 'Janani', 'admin@gmail.com', NULL, '2026-07-31 16:22:20', '$2y$12$kxm9YK2K6GNF82dSiSkvOe0y1aP3OArqgzZWaC/H35xTx09UF4E7m', 'WMbZw6UIck3h8VFupMLbm9DplMyVPmPbcgd46Rh2ffSV535V9kT7hbvLjKPv', '2026-07-31 15:40:24', '2026-08-07 02:58:34', '0770010102', '19909999888', NULL, 'Gannoruwa, Peradeniya', NULL, 'profile_images/1786090822.png', 'admin', NULL, NULL, NULL, NULL),
(9, 'Amaya Ratnakayake', 'a@gmail.com', NULL, '2026-08-07 05:14:19', '$2y$12$hTfb8OhP3AWn.QvrwbgxTOvVW.s9YD45fCLwfxDVD9Kjo8A2CJpGe', '5uk2JFHRHrXD2NLvUfSfZGakD1xPlbAwpCjgTCXzsx7rK2YmZq2WVK3gdOWB', '2026-08-07 05:13:29', '2026-08-07 05:14:19', '0710010101', '199754354353', '1997-12-31', 'Gannoruwa, Peradeniya', '2026-07-01', 'profile_images/1786099409.png', 'admin', NULL, NULL, NULL, NULL),
(15, 'Manisha Krishani', 'mk@gmail.com', NULL, '2026-08-15 09:57:17', '$2y$12$pTCSP7Hw2pecEfyyYE0rPe22BMfX/CB8aPB4qkUSr2qvx43NJtqf6', 'hNvBAlenWy6oHrZqINUUcKf5TFzRcyjA0Hr7GrzXKKvIGVGdtCEGBcguE3ai', '2026-08-15 09:23:38', '2026-08-15 09:59:44', '0771212121', '200423232323', NULL, 'Peradeniya', NULL, 'profile_images/1786805617.jpeg', 'cashier', 2, NULL, NULL, NULL),
(16, 'Himasha Ratnayake', 'hr@gmail.com', '789483', '2026-08-15 09:33:02', '$2y$12$QMSVF95PhLSueFkqGs5fvOYWXpVOCzlwui4b.fsO1Krl6JWCABM7K', NULL, '2026-08-15 09:33:02', '2026-08-15 09:33:02', '0770010101', '199754354353', NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL),
(17, 'Himasha Ratnayake', 'hh@gmail.com', NULL, '2026-08-17 03:21:41', '$2y$12$6whkEK3UnRgS149dSWvOPO0xayvCGpaICs9GHJvxGAbhVxCn2ZrP2', NULL, '2026-08-17 03:20:46', '2026-08-17 03:21:41', '0770010101', '200423232323', NULL, 'Kandy', NULL, 'profile_images/1786956645.jpg', 'chef', 2, 1, '2025.01.31 - 2025.08.01', 'beverage.(watermelon juice, papaya juice, avacado juice)');

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
  ADD KEY `queue_displays_order_id_foreign` (`order_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kitchen_tickets`
--
ALTER TABLE `kitchen_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `outlets`
--
ALTER TABLE `outlets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue_displays`
--
ALTER TABLE `queue_displays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
