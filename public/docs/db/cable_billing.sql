-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 25, 2023 at 08:54 AM
-- Server version: 5.7.33
-- PHP Version: 8.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cable_billing`
--

-- --------------------------------------------------------

--
-- Table structure for table `advances`
--

CREATE TABLE `advances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 or 1',
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advances`
--

INSERT INTO `advances` (`id`, `date`, `amount`, `employee_id`, `cash_id`, `payment_type`, `is_paid`, `note`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '2023-03-13', '10000.00', 2, 1, 'cash', 1, NULL, NULL, '2023-04-05 02:19:38', '2023-04-05 02:27:12'),
(2, '2023-03-13', '2000.00', 2, 1, 'cash', 1, NULL, NULL, '2023-04-05 02:19:55', '2023-04-05 02:27:12'),
(3, '2023-04-05', '12000.00', 2, 1, 'cash', 0, NULL, '2023-04-05 02:23:55', '2023-04-05 02:20:35', '2023-04-05 02:23:55'),
(4, '2023-04-05', '7000.00', 3, 1, 'cash', 0, NULL, '2023-04-05 02:38:01', '2023-04-05 02:37:47', '2023-04-05 02:38:01'),
(5, '2023-04-05', '7000.00', 3, 1, 'cash', 0, NULL, '2023-04-05 02:41:53', '2023-04-05 02:40:51', '2023-04-05 02:41:53'),
(6, '2023-04-05', '7000.00', 3, 1, 'cash', 0, NULL, '2023-04-05 02:45:29', '2023-04-05 02:45:17', '2023-04-05 02:45:29'),
(7, '2023-04-05', '12000.00', 2, 1, 'cash', 1, NULL, NULL, '2023-04-05 03:10:50', '2023-04-05 03:12:13'),
(8, '2023-04-01', '5000.00', 3, 1, 'cash', 1, NULL, NULL, '2023-04-08 22:27:08', '2023-04-09 01:22:30'),
(9, '2023-04-09', '2000.00', 3, 1, 'cash', 1, NULL, NULL, '2023-04-08 22:27:36', '2023-04-09 01:22:30'),
(10, '2023-04-09', '5000.00', 2, 1, 'cash', 1, NULL, NULL, '2023-04-09 00:04:50', '2023-04-09 01:13:48'),
(11, '2023-04-09', '5000.00', 2, 1, 'cash', 1, NULL, NULL, '2023-04-09 00:29:20', '2023-04-09 01:13:48'),
(12, '2023-04-09', '2000.00', 2, 1, 'cash', 1, NULL, NULL, '2023-04-09 00:31:26', '2023-04-09 01:13:48');

-- --------------------------------------------------------

--
-- Table structure for table `advance_paids`
--

CREATE TABLE `advance_paids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `salary_id` bigint(20) UNSIGNED NOT NULL,
  `advance_id` bigint(20) UNSIGNED NOT NULL,
  `advance_paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advance_paids`
--

INSERT INTO `advance_paids` (`id`, `salary_id`, `advance_id`, `advance_paid_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '10000.00', '2023-04-05 02:27:12', '2023-04-05 02:27:12'),
(2, 1, 2, '2000.00', '2023-04-05 02:27:12', '2023-04-05 02:27:12'),
(3, 3, 7, '12000.00', '2023-04-05 03:12:13', '2023-04-05 03:12:13'),
(4, 4, 10, '5000.00', '2023-04-09 01:13:48', '2023-04-09 01:13:48'),
(5, 4, 11, '5000.00', '2023-04-09 01:13:48', '2023-04-09 01:13:48'),
(6, 4, 12, '2000.00', '2023-04-09 01:13:48', '2023-04-09 01:13:48'),
(7, 5, 8, '5000.00', '2023-04-09 01:22:30', '2023-04-09 01:22:30'),
(8, 5, 9, '2000.00', '2023-04-09 01:22:30', '2023-04-09 01:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 'পূর্ব উৎরাইল', NULL, NULL, '2023-02-07 19:45:03', '2023-02-11 15:22:50'),
(5, 'পশ্চিম উৎরাইল', NULL, NULL, '2023-02-07 19:45:13', '2023-02-11 15:23:07'),
(6, 'বিরিশিরি', NULL, NULL, '2023-02-07 19:45:28', '2023-02-11 15:23:18'),
(7, 'ঘোরাইত', NULL, NULL, '2023-02-07 19:45:41', '2023-02-11 15:23:51'),
(8, 'তেলুঞ্জিয়া', NULL, NULL, '2023-02-07 19:45:59', '2023-02-11 15:24:24'),
(9, 'পূর্ব কানিয়াল', NULL, NULL, '2023-02-07 19:46:12', '2023-02-11 15:24:53'),
(10, 'পশ্চিম কানিয়াল', NULL, NULL, '2023-02-07 19:46:31', '2023-02-11 15:25:24'),
(11, 'সাগরদিঘী', NULL, NULL, '2023-02-07 19:46:55', '2023-02-11 15:25:38'),
(12, 'পূর্ব দাখিনাইল', NULL, NULL, '2023-02-07 19:47:14', '2023-02-11 15:25:57'),
(13, 'পশ্চিম দাখিনাইল', NULL, NULL, '2023-02-07 19:47:33', '2023-02-11 15:26:29'),
(14, 'গুলপারা', NULL, NULL, '2023-02-07 19:47:58', '2023-02-11 15:26:51'),
(15, 'নাথ পাড়া', NULL, NULL, '2023-02-07 19:48:09', '2023-02-11 15:27:21'),
(16, 'পূর্ব শিমুলতলী', NULL, NULL, '2023-02-07 19:48:41', '2023-02-11 15:27:37'),
(17, 'পশ্চিম শিমুলতলী', NULL, NULL, '2023-02-07 19:48:51', '2023-02-11 15:27:51'),
(18, 'পলাশকান্দি', NULL, NULL, '2023-02-07 19:49:03', '2023-02-11 15:28:05'),
(19, 'গোয়ালিদেও', NULL, NULL, '2023-02-07 19:49:19', '2023-02-11 15:29:24'),
(20, 'একাডেমি', NULL, NULL, '2023-02-07 19:49:43', '2023-02-11 15:29:37'),
(21, 'ভুলিগাও', NULL, NULL, '2023-02-07 19:49:57', '2023-02-11 15:30:03'),
(22, 'পূর্ব নোয়াপাড়া (Re)', NULL, NULL, '2023-02-07 19:50:23', '2023-02-11 15:30:23'),
(23, 'পশ্চিম নোয়াপাড়া (Re)', NULL, NULL, '2023-02-07 19:50:42', '2023-02-11 15:30:40'),
(24, 'GBC', NULL, NULL, '2023-02-11 15:00:22', '2023-02-11 15:00:22'),
(25, 'পূর্ব  সর্পকরুনিয়া', NULL, NULL, '2023-02-11 15:32:40', '2023-02-11 15:32:40'),
(26, 'পশ্চিম সর্পকরুনিয়া', NULL, NULL, '2023-02-11 15:32:50', '2023-02-11 15:32:50'),
(27, 'Durgapur Sujon', NULL, NULL, '2023-03-06 13:30:14', '2023-03-06 13:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `cashes`
--

CREATE TABLE `cashes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cash_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cashes`
--

INSERT INTO `cashes` (`id`, `cash_name`, `balance`, `note`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Main cash', '5500.00', 'n/a', NULL, '2022-09-28 22:10:41', '2023-04-17 03:55:26');

-- --------------------------------------------------------

--
-- Table structure for table `closing_balances`
--

CREATE TABLE `closing_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `balance` decimal(14,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `mobile_no`, `area_id`, `balance`, `address`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Mahmudur Rahman', '01971072007', 24, '0.00', NULL, NULL, NULL, '2023-03-14 00:57:37', '2023-03-14 00:57:37'),
(2, 'Allahma Iqbal', '01767046942', 24, '0.00', NULL, NULL, NULL, '2023-03-14 00:58:31', '2023-03-14 00:58:31'),
(3, 'test', '01975454574', 24, '0.00', NULL, NULL, NULL, '2023-04-04 21:32:46', '2023-04-04 21:32:46'),
(4, 'Mahmudur Rahman', '01971072007', 20, '0.00', NULL, NULL, NULL, '2023-04-04 21:50:27', '2023-04-04 21:50:27'),
(5, 'Shibbir vai', '01911111111', 14, '0.00', NULL, NULL, NULL, '2023-04-17 03:19:29', '2023-04-17 03:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `customer_due_manages`
--

CREATE TABLE `customer_due_manages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'positive amount ii received & negetive amount is paid',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `adjustment` decimal(12,2) NOT NULL DEFAULT '0.00',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_salary` decimal(8,2) DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `mobile`, `image`, `nid_number`, `basic_salary`, `address`, `note`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Md. Sujon Bepari', '01915416184', 'images/employee_images/2cay1eLMoMh26wzkt96PUZ3YrpwoOdXhGeFddAmy.jpg', NULL, '12000.00', NULL, NULL, NULL, '2023-02-07 19:52:39', '2023-02-07 19:52:39'),
(3, 'Md. Mizan Sheikh', '01827115426', NULL, NULL, '7000.00', NULL, NULL, NULL, '2023-02-07 19:53:32', '2023-02-07 19:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `expense_category_id` bigint(20) UNSIGNED NOT NULL,
  `expense_subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `name`, `note`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'Monthly Cost', NULL, NULL, '2023-02-07 19:56:18', '2023-02-07 19:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `expense_subcategories`
--

CREATE TABLE `expense_subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_subcategories`
--

INSERT INTO `expense_subcategories` (`id`, `expense_category_id`, `name`, `note`, `deleted_at`, `created_at`, `updated_at`) VALUES
(5, 3, 'Room Rent', NULL, NULL, '2023-02-07 19:56:43', '2023-02-07 19:56:43'),
(6, 3, 'Current Bill', NULL, NULL, '2023-02-07 19:56:55', '2023-02-07 19:56:55'),
(7, 3, 'Night Guard', NULL, NULL, '2023-02-07 19:57:16', '2023-02-07 19:57:16'),
(8, 3, 'Extra Cost', NULL, NULL, '2023-02-07 19:57:40', '2023-02-07 19:57:40'),
(9, 3, 'Mobile Bill', NULL, NULL, '2023-02-07 19:58:06', '2023-02-07 19:58:06');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `expire_date` date NOT NULL,
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_installments`
--

CREATE TABLE `loan_installments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_05_29_072643_create_permission_tables', 1),
(6, '2022_06_02_041935_create_profiles_table', 1),
(7, '2022_09_22_093521_create_areas_table', 2),
(9, '2022_09_22_104949_create_packages_table', 3),
(11, '2022_09_25_051843_create_products_table', 4),
(13, '2022_09_29_033737_create_cashes_table', 6),
(33, '2022_10_12_055748_create_expense_categories_table', 8),
(34, '2022_10_12_091722_create_expense_subcategories_table', 8),
(35, '2022_10_12_091939_create_expenses_table', 8),
(36, '2022_10_12_110613_create_employees_table', 9),
(58, '2022_10_26_053149_create_advances_table', 11),
(59, '2022_10_27_054714_create_loans_table', 12),
(60, '2022_10_27_065215_create_loan_installments_table', 13),
(65, '2022_10_31_055253_create_salaries_table', 14),
(66, '2022_10_31_055514_create_salary_details_table', 14),
(67, '2022_10_31_073335_create_advance_paids_table', 14),
(73, '2022_11_06_103100_create_suppliers_table', 16),
(81, '2022_09_25_054815_create_customers_table', 17),
(85, '2022_09_29_060038_create_sales_table', 18),
(86, '2022_09_29_064605_create_product_sale_table', 18),
(87, '2022_11_07_041621_create_purchases_table', 19),
(88, '2022_11_15_035207_create_product_purchase_table', 20),
(89, '2022_11_16_042346_create_stocks_table', 21),
(90, '2022_11_17_071520_create_supplier_due_manages_table', 22),
(91, '2022_11_17_071758_create_customer_due_manages_table', 22),
(93, '2022_11_27_091022_create_closing_balances_table', 23),
(94, '2022_12_15_101834_create_monthly_recharges_table', 24),
(95, '2023_03_14_033046_create_sms_templates_table', 25);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 14),
(1, 'App\\Models\\User', 15),
(1, 'App\\Models\\User', 16);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_recharges`
--

CREATE TABLE `monthly_recharges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `expire_date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monthly_recharges`
--

INSERT INTO `monthly_recharges` (`id`, `customer_id`, `sale_id`, `date`, `expire_date`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2023-03-14', '2023-05-12', '300.00', '2023-03-14 01:37:59', '2023-03-14 01:37:59'),
(2, 2, NULL, '2023-03-14', '2023-04-12', '300.00', '2023-03-14 01:40:13', '2023-03-14 01:40:13'),
(3, 2, NULL, '2023-03-14', '2023-04-12', '300.00', '2023-03-14 01:45:59', '2023-03-14 01:45:59'),
(4, 2, NULL, '2023-03-14', '2023-04-12', '300.00', '2023-03-14 01:48:55', '2023-03-14 01:48:55'),
(5, 2, NULL, '2023-03-14', '2023-04-12', '300.00', '2023-03-14 01:49:29', '2023-03-14 01:49:29'),
(6, 1, NULL, '2023-03-14', '2023-05-12', '300.00', '2023-03-14 01:52:30', '2023-03-14 01:52:30'),
(7, 1, NULL, '2023-03-14', '2023-05-12', '300.00', '2023-03-14 01:54:23', '2023-03-14 01:54:23'),
(9, 1, NULL, '2023-03-14', '2023-04-14', '300.00', '2023-03-14 02:03:20', '2023-03-14 02:03:20'),
(10, 1, NULL, '2023-03-14', '2023-05-15', '600.00', '2023-03-14 02:05:34', '2023-03-14 02:05:34'),
(11, 1, NULL, '2023-04-05', '2023-05-04', '150.00', '2023-04-05 01:25:37', '2023-04-05 01:25:37'),
(12, 1, NULL, '2023-04-09', '2023-07-15', '900.00', '2023-04-08 22:09:00', '2023-04-08 22:09:00'),
(13, 2, 2, '2023-04-17', '2023-05-16', '300.00', '2023-04-17 03:43:34', '2023-04-17 03:43:34'),
(14, 3, 3, '2023-04-17', '2023-05-10', '100.00', '2023-04-17 03:51:23', '2023-04-17 03:51:23'),
(15, 3, 3, '2023-04-17', '2023-05-15', '100.00', '2023-04-17 03:55:26', '2023-04-17 03:55:26');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `price`, `cost`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Platinum', '300.00', '100.00', NULL, NULL, '2023-02-07 19:43:00', '2023-02-07 19:43:00'),
(3, 'Reseller', '150.00', '100.00', NULL, NULL, '2023-02-07 19:44:21', '2023-02-07 19:44:21'),
(4, 'Easy', '100.00', '100.00', NULL, NULL, '2023-02-10 17:03:32', '2023-02-10 17:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin@maxsop.com', '$2y$10$VY.pCPmGfnLhiL9t69AM6OuycWgb0KjMjuQ5cHz9Cm8UYpeNYXdfq', '2022-07-23 02:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'monthly-recharge.index', 'web', '2023-02-10 17:12:42', '2023-02-10 17:12:42'),
(2, 'monthly-recharge.active', 'web', '2023-02-10 17:12:42', '2023-02-10 17:12:42'),
(3, 'ledger.customer-ledger', 'web', '2023-02-10 17:12:42', '2023-02-10 17:12:42'),
(4, 'ledger.supplier-ledger', 'web', '2023-02-10 17:12:42', '2023-02-10 17:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `previous_purchase_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock_alert` decimal(10,2) NOT NULL DEFAULT '0.00',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `model`, `purchase_price`, `previous_purchase_price`, `sale_price`, `stock_alert`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Fiber Cable', 'BRB 4Core', '13.00', '0.00', '15.00', '0.00', NULL, NULL, '2023-02-07 20:25:43', '2023-02-07 20:25:43'),
(3, 'RJ6', 'DLink', '13.00', '0.00', '16.00', '0.00', NULL, NULL, '2023-02-07 20:27:04', '2023-02-07 20:27:04'),
(4, 'Node Machin', '-16DBM', '1750.00', '0.00', '1900.00', '10.00', NULL, NULL, '2023-02-07 20:28:24', '2023-02-07 20:44:55'),
(5, 'Coupler', '4Y', '100.00', '0.00', '120.00', '10.00', NULL, NULL, '2023-02-07 20:29:14', '2023-02-07 20:45:04'),
(6, 'RJ6 Connector', 'MX6', '12.00', '0.00', '15.00', '10.00', NULL, NULL, '2023-02-07 20:29:54', '2023-02-07 20:45:16'),
(7, 'Set top Box', 'Black', '1900.00', '0.00', '2000.00', '0.00', NULL, NULL, '2023-02-07 20:31:06', '2023-02-07 20:31:06'),
(8, 'Set top Box', 'Black', '1900.00', '0.00', '2000.00', '10.00', NULL, NULL, '2023-02-07 20:31:10', '2023-02-07 20:43:01'),
(9, 'Set top Box', 'White', '2100.00', '0.00', '2200.00', '10.00', NULL, NULL, '2023-02-07 20:31:36', '2023-02-07 20:42:43'),
(10, 'Remote Control', 'Black / White', '220.00', '0.00', '350.00', '10.00', NULL, NULL, '2023-02-07 20:42:22', '2023-02-07 20:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase`
--

CREATE TABLE `product_purchase` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(8,2) NOT NULL DEFAULT '1.00',
  `qty_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sale`
--

CREATE TABLE `product_sale` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(8,2) NOT NULL DEFAULT '1.00',
  `qty_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Others') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `voucher_no` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_paid` decimal(12,2) NOT NULL DEFAULT '0.00',
  `due` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `previous_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_permanent` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `is_permanent`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'web', 1, '2022-07-05 23:34:33', '2022-07-05 23:34:33'),
(2, 'Manager', 'web', 1, '2022-07-05 23:34:33', '2022-07-05 23:34:33'),
(3, 'Operator', 'web', 1, '2022-07-05 23:34:33', '2022-07-05 23:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 3),
(2, 3),
(3, 3),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `salary_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `given_date` date NOT NULL COMMENT 'salary given date',
  `salary_month` date NOT NULL COMMENT 'month of salary',
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`id`, `employee_id`, `salary_no`, `given_date`, `salary_month`, `cash_id`, `payment_type`, `note`, `created_at`, `updated_at`) VALUES
(1, 2, '00000001', '2023-04-05', '2023-03-01', 1, 'cash', NULL, '2023-04-05 02:27:12', '2023-04-05 02:27:12'),
(2, 3, '00000002', '2023-04-05', '2023-03-01', 1, 'cash', NULL, '2023-04-05 02:31:27', '2023-04-05 02:31:27'),
(3, 2, '00000003', '2023-04-05', '2023-05-01', 1, 'cash', NULL, '2023-04-05 03:12:13', '2023-04-05 03:12:13'),
(4, 2, '00000004', '2023-04-09', '2023-12-01', 1, 'cash', NULL, '2023-04-09 01:13:48', '2023-04-09 01:13:48'),
(5, 3, '00000005', '2023-04-09', '2023-09-01', 1, 'cash', NULL, '2023-04-09 01:22:30', '2023-04-09 01:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `salary_details`
--

CREATE TABLE `salary_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `salary_id` bigint(20) UNSIGNED NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'the purpose of salary amount',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_details`
--

INSERT INTO `salary_details` (`id`, `salary_id`, `purpose`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'basic_salary', '12000.00', '2023-04-05 02:27:12', '2023-04-05 02:27:12'),
(2, 2, 'basic_salary', '7000.00', '2023-04-05 02:31:27', '2023-04-05 02:31:27'),
(3, 2, 'bonus', '5000.00', '2023-04-05 02:31:27', '2023-04-05 02:31:27'),
(4, 2, 'deduction', '1000.00', '2023-04-05 02:31:27', '2023-04-05 02:31:27'),
(5, 3, 'basic_salary', '12000.00', '2023-04-05 03:12:13', '2023-04-05 03:12:13'),
(6, 4, 'basic_salary', '12000.00', '2023-04-09 01:13:48', '2023-04-09 01:13:48'),
(7, 5, 'basic_salary', '7000.00', '2023-04-09 01:22:30', '2023-04-09 01:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `invoice_no` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cable_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `active_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_paid` decimal(12,2) NOT NULL DEFAULT '0.00',
  `due` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `previous_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `date`, `invoice_no`, `cable_id`, `package_id`, `active_date`, `expire_date`, `subtotal`, `discount`, `discount_type`, `total_paid`, `due`, `payment_type`, `cash_id`, `previous_balance`, `status`, `user_id`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-03-14', NULL, '007', 2, '2023-04-09', '2023-07-15', '0.00', '0.00', NULL, '0.00', '0.00', NULL, NULL, '0.00', 'active', 15, NULL, '2023-03-14 00:57:37', '2023-04-08 22:09:00'),
(2, 2, '2023-03-14', NULL, '001', 2, '2023-04-17', '2023-05-16', '0.00', '0.00', NULL, '0.00', '0.00', NULL, NULL, '0.00', 'active', 15, NULL, '2023-03-14 00:58:31', '2023-04-17 03:43:34'),
(3, 3, '2023-03-01', NULL, '52454', 4, '2023-04-17', '2023-05-15', '0.00', '0.00', NULL, '0.00', '0.00', NULL, NULL, '0.00', 'active', 15, NULL, '2023-04-04 21:32:46', '2023-04-17 03:55:26'),
(4, 4, '2023-04-05', NULL, '1242', 2, '2023-04-05', '2023-05-05', '0.00', '0.00', NULL, '0.00', '0.00', NULL, NULL, '0.00', 'active', 15, NULL, '2023-04-04 21:50:27', '2023-04-04 21:50:27'),
(5, 1, '2023-04-05', 'Invoice-00000005', '644', 3, '2023-04-05', '2023-05-04', '300.00', '0.00', 'flat', '300.00', '0.00', 'cash', 1, '0.00', 'active', 15, NULL, '2023-04-04 21:52:11', '2023-04-05 01:25:37'),
(6, 5, '2023-02-01', NULL, '123123', 4, '2023-02-01', '2023-03-01', '0.00', '0.00', NULL, '0.00', '0.00', NULL, NULL, '0.00', 'inactive', 15, NULL, '2023-04-17 03:19:29', '2023-04-17 03:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `sms_templates`
--

CREATE TABLE `sms_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_templates`
--

INSERT INTO `sms_templates` (`id`, `title`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Eid mubarak', 'Eid mubarak', NULL, '2023-04-04 23:52:41', '2023-04-04 23:52:41'),
(2, 'রমজান মোবারক', 'পবিত্র মাহে রমজানের শুভেচ্ছা।', NULL, '2023-04-05 01:08:29', '2023-04-05 01:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `quantity`, `purchase_price`, `created_at`, `updated_at`) VALUES
(2, 2, '0', '13.00', '2023-02-07 20:25:43', '2023-02-07 20:25:43'),
(3, 3, '0', '13.00', '2023-02-07 20:27:04', '2023-02-07 20:27:04'),
(4, 4, '0', '1750.00', '2023-02-07 20:28:24', '2023-02-07 20:28:24'),
(5, 5, '0', '100.00', '2023-02-07 20:29:14', '2023-02-07 20:29:14'),
(6, 6, '0', '12.00', '2023-02-07 20:29:54', '2023-02-07 20:29:54'),
(7, 7, '0', '1900.00', '2023-02-07 20:31:06', '2023-02-07 20:31:06'),
(8, 8, '0', '1900.00', '2023-02-07 20:31:10', '2023-02-07 20:31:10'),
(9, 9, '0', '2100.00', '2023-02-07 20:31:36', '2023-02-07 20:31:36'),
(10, 10, '0', '220.00', '2023-02-07 20:42:22', '2023-02-07 20:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `mobile_no`, `balance`, `address`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'FCN', '01863760853', '15000.00', 'Netrakona', NULL, NULL, '2023-02-07 20:02:43', '2023-03-13 11:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_due_manages`
--

CREATE TABLE `supplier_due_manages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'positive amount ii received & negetive amount is paid',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `adjustment` decimal(12,2) NOT NULL DEFAULT '0.00',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_due_manages`
--

INSERT INTO `supplier_due_manages` (`id`, `supplier_id`, `date`, `amount`, `payment_type`, `cash_id`, `adjustment`, `user_id`, `note`, `created_at`, `updated_at`) VALUES
(2, 3, '2023-03-13', '-15000.00', 'cash', 1, '0.00', NULL, '1-5-10 March', '2023-03-13 11:54:26', '2023-03-13 11:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `phone_verified_at`, `password`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'administrator@maxsop.com', '01234567890', '2022-07-05 23:34:33', '2022-07-05 23:34:33', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OWyUidpkqGPvAUoaHxS8YrnZxoxK7svARsIc1DC9cbjP1iesKdWEnnoknAUG', NULL, '2022-07-05 23:34:33', '2022-07-05 23:34:33'),
(15, 'Maxsop', 'admin@maxsop.com', '01971072007', NULL, NULL, '$2y$10$Hjc7gGxUFAfqGNqWqM7pZODGgbLJlkzTKkrzfSfqReTNzKB64dxDu', NULL, NULL, '2023-02-13 11:55:42', '2023-02-13 11:55:42'),
(16, 'Fiber Orbit', 'admin@fiberorbit.com', '12345', NULL, NULL, '$2y$10$8zwlgZnzb/F2ro/79a5Ojuhbg5xJ7cR1BprWTpYxUm7iqgmupzz4u', NULL, NULL, '2023-02-13 11:56:31', '2023-02-13 11:56:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advances`
--
ALTER TABLE `advances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advances_employee_id_foreign` (`employee_id`),
  ADD KEY `advances_cash_id_foreign` (`cash_id`);

--
-- Indexes for table `advance_paids`
--
ALTER TABLE `advance_paids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advance_paids_salary_id_foreign` (`salary_id`),
  ADD KEY `advance_paids_advance_id_foreign` (`advance_id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashes`
--
ALTER TABLE `cashes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closing_balances`
--
ALTER TABLE `closing_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_area_id_foreign` (`area_id`);

--
-- Indexes for table `customer_due_manages`
--
ALTER TABLE `customer_due_manages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_due_manages_customer_id_foreign` (`customer_id`),
  ADD KEY `customer_due_manages_cash_id_foreign` (`cash_id`),
  ADD KEY `customer_due_manages_user_id_foreign` (`user_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_expense_category_id_foreign` (`expense_category_id`),
  ADD KEY `expenses_expense_subcategory_id_foreign` (`expense_subcategory_id`),
  ADD KEY `expenses_cash_id_foreign` (`cash_id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_subcategories`
--
ALTER TABLE `expense_subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_subcategories_expense_category_id_foreign` (`expense_category_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_employee_id_foreign` (`employee_id`),
  ADD KEY `loans_cash_id_foreign` (`cash_id`);

--
-- Indexes for table `loan_installments`
--
ALTER TABLE `loan_installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_installments_loan_id_foreign` (`loan_id`),
  ADD KEY `loan_installments_cash_id_foreign` (`cash_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `monthly_recharges`
--
ALTER TABLE `monthly_recharges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monthly_recharges_customer_id_foreign` (`customer_id`),
  ADD KEY `monthly_recharges_sale_id_foreign` (`sale_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_purchase`
--
ALTER TABLE `product_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_purchase_purchase_id_foreign` (`purchase_id`),
  ADD KEY `product_purchase_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_sale`
--
ALTER TABLE `product_sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sale_sale_id_foreign` (`sale_id`),
  ADD KEY `product_sale_product_id_foreign` (`product_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchases_cash_id_foreign` (`cash_id`),
  ADD KEY `purchases_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salaries_employee_id_foreign` (`employee_id`),
  ADD KEY `salaries_cash_id_foreign` (`cash_id`);

--
-- Indexes for table `salary_details`
--
ALTER TABLE `salary_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_details_salary_id_foreign` (`salary_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_cable_id_unique` (`cable_id`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_package_id_foreign` (`package_id`),
  ADD KEY `sales_cash_id_foreign` (`cash_id`),
  ADD KEY `sales_user_id_foreign` (`user_id`);

--
-- Indexes for table `sms_templates`
--
ALTER TABLE `sms_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_product_id_foreign` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_mobile_no_unique` (`mobile_no`);

--
-- Indexes for table `supplier_due_manages`
--
ALTER TABLE `supplier_due_manages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_due_manages_supplier_id_foreign` (`supplier_id`),
  ADD KEY `supplier_due_manages_cash_id_foreign` (`cash_id`),
  ADD KEY `supplier_due_manages_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advances`
--
ALTER TABLE `advances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `advance_paids`
--
ALTER TABLE `advance_paids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cashes`
--
ALTER TABLE `cashes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `closing_balances`
--
ALTER TABLE `closing_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer_due_manages`
--
ALTER TABLE `customer_due_manages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expense_subcategories`
--
ALTER TABLE `expense_subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_installments`
--
ALTER TABLE `loan_installments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `monthly_recharges`
--
ALTER TABLE `monthly_recharges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_purchase`
--
ALTER TABLE `product_purchase`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sale`
--
ALTER TABLE `product_sale`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `salary_details`
--
ALTER TABLE `salary_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sms_templates`
--
ALTER TABLE `sms_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier_due_manages`
--
ALTER TABLE `supplier_due_manages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advances`
--
ALTER TABLE `advances`
  ADD CONSTRAINT `advances_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `advances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `advance_paids`
--
ALTER TABLE `advance_paids`
  ADD CONSTRAINT `advance_paids_advance_id_foreign` FOREIGN KEY (`advance_id`) REFERENCES `advances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `advance_paids_salary_id_foreign` FOREIGN KEY (`salary_id`) REFERENCES `salaries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `customer_due_manages`
--
ALTER TABLE `customer_due_manages`
  ADD CONSTRAINT `customer_due_manages_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_due_manages_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_due_manages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_expense_category_id_foreign` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_expense_subcategory_id_foreign` FOREIGN KEY (`expense_subcategory_id`) REFERENCES `expense_subcategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expense_subcategories`
--
ALTER TABLE `expense_subcategories`
  ADD CONSTRAINT `expense_subcategories_expense_category_id_foreign` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `loans_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loan_installments`
--
ALTER TABLE `loan_installments`
  ADD CONSTRAINT `loan_installments_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `loan_installments_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `monthly_recharges`
--
ALTER TABLE `monthly_recharges`
  ADD CONSTRAINT `monthly_recharges_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `monthly_recharges_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_purchase`
--
ALTER TABLE `product_purchase`
  ADD CONSTRAINT `product_purchase_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_purchase_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_sale`
--
ALTER TABLE `product_sale`
  ADD CONSTRAINT `product_sale_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_sale_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `salaries_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salary_details`
--
ALTER TABLE `salary_details`
  ADD CONSTRAINT `salary_details_salary_id_foreign` FOREIGN KEY (`salary_id`) REFERENCES `salaries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supplier_due_manages`
--
ALTER TABLE `supplier_due_manages`
  ADD CONSTRAINT `supplier_due_manages_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cashes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `supplier_due_manages_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `supplier_due_manages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
