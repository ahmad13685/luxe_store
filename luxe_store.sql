-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2026 at 09:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luxe_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'shipping',
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_line` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Pakistan',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `type`, `full_name`, `phone`, `address_line`, `city`, `state`, `postal_code`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(3, 3, 'shipping', 'AYAN IMRAN', '03192347309', '221B Baker Street', 'Karachi', 'Sindh', '75500', 'Pakistan', 1, '2026-08-18 12:51:36', '2026-08-18 12:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `password`, `profile_photo`, `created_at`, `updated_at`) VALUES
(3, 'AYAN IMRAN', 'shiknanfight@gmail.com', '03192347309', '$2y$12$/M2hhNn2qCDD0iwLUo89.ORjy5kGtcEk/7k.bGk27zqbEscSQlsEm', 'ae2af030-5ab6-4db9-8464-23070f3c4f4b.webp', '2026-08-08 13:27:29', '2026-08-18 12:33:00'),
(4, 'Ahmad Malik', 'malikahmad34018@gmail.com', NULL, '$2y$12$cs8bGy8Y.abauGSCHckRHON2j5nAnp3Vej.vNeZoBJgNyjrpgjxpu', NULL, '2026-08-13 01:27:52', '2026-08-16 13:36:54'),
(5, 'John Carter', 'john@example.com', '+92 300 1234567', '$2y$12$OMw4nbMhP.EcifcgGsHziOEyKO0Z.cGt/RC91i0J2GAljui9cuxoi', NULL, '2026-08-18 12:51:35', '2026-08-18 12:51:35'),
(6, 'Sarah Malik', 'sarah@example.com', '+92 301 7654321', '$2y$12$JEFPNjOKAXtqnEtLxBWZyesicL8IgAamczCMRf1veiUwfrB2qwMvi', NULL, '2026-08-18 12:51:36', '2026-08-18 12:51:36');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_customers_table', 1),
(5, '2024_01_01_000002_create_addresses_table', 1),
(6, '2024_01_01_000003_create_orders_table', 1),
(7, '2024_01_01_000004_create_order_items_table', 1),
(8, '2024_01_01_000005_create_wishlists_table', 1),
(9, '2026_08_11_000006_add_checkout_fields_to_orders', 2),
(10, '2026_08_12_000001_add_shipping_address_to_orders_table', 3),
(11, '2026_08_13_120000_add_payment_details_to_orders_table', 3),
(12, '2026_08_14_174604_create_products_table', 4),
(13, '2026_08_14_181457_create_product_images_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(16) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `payment_method` varchar(255) NOT NULL DEFAULT 'Cash on Delivery',
  `card_last4` varchar(4) DEFAULT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `delivery_type` varchar(20) NOT NULL DEFAULT 'standard',
  `payment_status` varchar(30) NOT NULL DEFAULT 'Pending',
  `payment_reference` varchar(255) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_name` varchar(255) DEFAULT NULL,
  `shipping_phone` varchar(255) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `billing_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_number`, `status`, `payment_method`, `card_last4`, `cheque_number`, `delivery_type`, `payment_status`, `payment_reference`, `subtotal`, `shipping_fee`, `total_amount`, `shipping_name`, `shipping_phone`, `shipping_address`, `shipping_address_id`, `billing_address_id`, `created_at`, `updated_at`) VALUES
(23, 3, '3456049284076739', 'Pending', 'VPP / Pay on Delivery', NULL, NULL, 'standard', 'Pending', NULL, 56.00, 8.00, 64.00, NULL, NULL, 'Korangi Industrial Area\r\n33E R221', NULL, NULL, '2026-08-19 13:24:47', '2026-08-19 13:24:47'),
(24, 3, '4062021474538791', 'Pending', 'Credit / Debit Card', '3222', NULL, 'standard', 'Pending', NULL, 520.00, 0.00, 520.00, NULL, NULL, 'CROSSING Karachi\r\n34B R256', NULL, NULL, '2026-08-20 02:19:59', '2026-08-20 02:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_reference` varchar(7) DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `product_image`, `product_reference`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES
(38, 23, 'Round Frame Sunglasses', 'http://localhost:8000/pic/p9.webp', NULL, 1, 56.00, 56.00, '2026-08-19 13:24:47', '2026-08-19 13:24:47'),
(39, 24, 'Tailored Wool Coat', 'http://localhost:8000/pic/p1.webp', NULL, 1, 498.00, 498.00, '2026-08-20 02:19:59', '2026-08-20 02:19:59'),
(40, 24, 'Matte Velvet Lipstick', 'http://localhost:8000/pic/p5.webp', NULL, 1, 22.00, 22.00, '2026-08-20 02:19:59', '2026-08-20 02:19:59');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `category` varchar(255) DEFAULT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `image`, `price`, `category`, `stock`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Printed Silk Scarf', 'printed-silk-scarf', 'Elegant printed silk scarf with a premium soft finish, finished with hand-rolled edges.', 'pic/scarf.webp', 45.00, 'Fashion', 30, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(2, 'Structured Leather Tote', 'structured-leather-tote', 'Premium structured leather tote designed for everyday elegance and durability.', 'pic/bag.webp', 210.00, 'Bags', 15, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(3, 'Minimal Steel Watch', 'minimal-steel-watch', 'Minimal luxury steel watch with a timeless design, on sale for a limited time.', 'pic/p10.webp', 499.00, 'Watches', 12, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(4, 'Suede Loafers', 'suede-loafers', 'Soft suede loafers built for all-day comfort with a refined silhouette.', 'pic/p11.webp', 168.00, 'Shoes', 18, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(5, 'Tailored Wool Coat', 'tailored-wool-coat', 'A tailored wool coat cut for a sharp, structured silhouette in colder months.', 'pic/p1.webp', 498.00, 'Fashion', 10, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(6, 'Gold Hoop Earrings', 'gold-hoop-earrings', '18k gold-plated hoop earrings with a lightweight, comfortable fit.', 'pic/p2.webp', 642.00, 'Accessories', 40, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(7, 'Sculpted Ceramic Vase', 'sculpted-ceramic-vase', 'A hand-sculpted ceramic vase that brings a modern, minimal accent to any room.', 'pic/p3.webp', 74.00, 'Home Decor', 22, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(8, 'Radiance Face Serum', 'radiance-face-serum', 'A lightweight radiance serum formulated to brighten and hydrate the skin.', 'pic/p4.webp', 38.00, 'Beauty', 50, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(9, 'Leather Bound Journal', 'leather-bound-journal', 'A premium leather-bound journal with thick, smooth pages for everyday writing.', 'pic/p5.webp', 32.00, 'Stationery', 35, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(10, 'Canvas Travel Backpack', 'canvas-travel-backpack', 'A durable canvas travel backpack with padded compartments for everyday carry.', 'pic/p6.webp', 139.00, 'Bags', 20, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(11, 'Classic Chelsea Boots', 'classic-chelsea-boots', 'Classic Chelsea boots crafted from premium leather with an elastic side panel.', 'pic/p7.webp', 189.00, 'Shoes', 16, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(12, 'Signature Eau de Parfum', 'signature-eau-de-parfum', 'A signature eau de parfum with warm, lingering notes for everyday wear.', 'pic/p8.webp', 95.00, 'Beauty', 28, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(13, 'Linen Throw Cushion', 'linen-throw-cushion', 'A soft linen throw cushion that adds texture and comfort to any living space.', 'pic/p9.webp', 29.00, 'Home Decor', 45, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(14, 'Oversized Linen Shirt', 'oversized-linen-shirt', 'A relaxed, oversized linen shirt perfect for warm-weather layering.', 'pic/p1.webp', 68.00, 'Fashion', 26, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(15, 'Leather Ankle Boots', 'leather-ankle-boots', 'Leather ankle boots with a sturdy sole, built for everyday wear.', 'pic/p2.webp', 175.00, 'Shoes', 14, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(16, 'Chronograph Steel Watch', 'chronograph-steel-watch', 'A chronograph steel watch with a precise movement and durable steel band.', 'pic/p4.webp', 289.00, 'Watches', 6, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(17, 'Matte Velvet Lipstick', 'matte-velvet-lipstick', 'A long-wearing matte velvet lipstick with rich, full-coverage pigment.', 'pic/p5.webp', 22.00, 'Beauty', 60, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(18, 'Classic Silk Tie', 'classic-silk-tie', 'A classic silk tie with a fine weave, suited for formal occasions.', 'pic/p6.webp', 42.00, 'Accessories', 33, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(19, 'Ceramic Table Lamp', 'ceramic-table-lamp', 'A ceramic table lamp with a soft, warm glow that suits any interior style.', 'pic/p7.webp', 88.00, 'Home Decor', 19, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(20, 'Kraft Notebook Set', 'kraft-notebook-set', 'A set of kraft-cover notebooks with recycled, lined pages for daily notes.', 'pic/p8.webp', 18.00, 'Stationery', 55, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(21, 'Round Frame Sunglasses', 'round-frame-sunglasses', 'Round frame sunglasses with UV-protective lenses and a lightweight frame.', 'pic/p9.webp', 56.00, 'Accessories', 24, 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'pic/scarf.webp', 0, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(2, 1, 'pic/scarf2.webp', 1, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(3, 1, 'pic/scarf3.webp', 2, '2026-08-18 12:53:44', '2026-08-18 12:53:44'),
(4, 1, 'pic/scarf4.webp', 3, '2026-08-18 12:53:44', '2026-08-18 12:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AR8lUKYO5cTn2A9B5sBFfmrTNSOpkIV3T23okxmY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUjJRc0gyUGxNSm5zZ0VOTk1GV2RiYmhGOUVqYVA3Rm5STU9TdnhSRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jdXN0b21lci9sb2dpbiI7czo1OiJyb3V0ZSI7czoxNDoiY3VzdG9tZXIubG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1786386017),
('UTrms0sEERfABCQpWe1ki0Q7OT7s60kQ7ZRouAtl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMWtXdGVJVVBVQnRLWmlQZ3Q1QmxDdlhtMU10S3lwMnp0NlRmR1FqYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zaG9wIjtzOjU6InJvdXRlIjtzOjQ6InNob3AiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjExOiJjdXN0b21lcl9pZCI7aTozO30=', 1786387086);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `customer_id`, `product_name`, `product_image`, `price`, `created_at`, `updated_at`) VALUES
(34, 3, 'Gold Hoop Earrings', 'p2.webp', 642.00, '2026-08-20 01:14:07', '2026-08-20 01:14:07'),
(35, 3, 'Radiance Face Serum', 'p4.webp', 38.00, '2026-08-20 01:14:10', '2026-08-20 01:14:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_shipping_address_id_foreign` (`shipping_address_id`),
  ADD KEY `orders_billing_address_id_foreign` (`billing_address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_sort_order_index` (`product_id`,`sort_order`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_customer_id_foreign` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_billing_address_id_foreign` FOREIGN KEY (`billing_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
