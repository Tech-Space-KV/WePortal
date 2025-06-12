-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 15, 2025 at 12:12 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pseudoteam`
--

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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `cart_order_no` varchar(255) DEFAULT NULL,
  `cart_hw_id` bigint(20) UNSIGNED NOT NULL,
  `cart_qty` int(11) NOT NULL,
  `cart_customer_id` varchar(400) NOT NULL,
  `cart_hw_amt` decimal(10,2) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `hardwares`
--

CREATE TABLE `hardwares` (
  `hrdws_id` bigint(20) NOT NULL,
  `hrdws_serial_number` varchar(255) NOT NULL,
  `hrdws_hw_identifier` varchar(255) NOT NULL,
  `hrdws_model_number` varchar(255) NOT NULL,
  `hrdws_model_description` text NOT NULL,
  `hrdws_qty` int(11) NOT NULL,
  `hrdws_family` varchar(255) NOT NULL,
  `hrdws_city` varchar(255) NOT NULL,
  `hrdws_state` varchar(255) NOT NULL,
  `hrdws_price` decimal(10,2) NOT NULL,
  `hrdws_sp_email` varchar(255) DEFAULT NULL,
  `hrdws_sp_id` varchar(255) DEFAULT NULL,
  `hrdws_hw_status` varchar(255) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `ntfn_id` bigint(20) UNSIGNED NOT NULL,
  `ntfn_notification` varchar(255) NOT NULL,
  `ntfn_hyperlink` varchar(255) DEFAULT NULL,
  `ntfn_readflag` tinyint(1) NOT NULL DEFAULT 0,
  `ntfn_project_id` varchar(400) NOT NULL,
  `ntfn_forUserId` varchar(400) DEFAULT NULL,
  `ntfn_date_time` varchar(400) NOT NULL,
  `ntfn_type` varchar(400) NOT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_placed`
--

CREATE TABLE `orders_placed` (
  `ordplcd_id` bigint(20) UNSIGNED NOT NULL,
  `ordplcd_hw_id` varchar(255) NOT NULL,
  `ordplcd_customer_id` varchar(255) NOT NULL,
  `ordplcd_address` varchar(255) DEFAULT NULL,
  `ordplcd_qty_placed` int(11) NOT NULL,
  `ordplcd_no_of_items` int(11) NOT NULL,
  `ordplcd_order_no` varchar(255) NOT NULL,
  `ordplcd_amt` decimal(10,2) NOT NULL,
  `ordplcd_status` varchar(255) NOT NULL,
  `ordplcd_delivery_date` varchar(20) DEFAULT NULL,
  `ordplcd_order_date` varchar(255) NOT NULL,
  `ordplcd_sp_id` varchar(255) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_addresses`
--

CREATE TABLE `order_addresses` (
  `ordradrs_id` bigint(20) UNSIGNED NOT NULL,
  `ordradrs_projectowner_id` bigint(20) UNSIGNED NOT NULL,
  `ordradrs_address` text NOT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `project_conversation`
--

CREATE TABLE `project_conversation` (
  `pconv_id` bigint(20) UNSIGNED NOT NULL,
  `pconv_task_id` bigint(20) UNSIGNED NOT NULL,
  `pconv_msg_by` bigint(20) UNSIGNED NOT NULL,
  `pconv_msg_body` text NOT NULL,
  `pconv_msg_date_time` datetime NOT NULL,
  `pconv_attachments` varchar(255) DEFAULT NULL,
  `pconv_read_flag` tinyint(1) NOT NULL DEFAULT 0,
  `pconv_project_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `plist_id` bigint(255) UNSIGNED NOT NULL,
  `plist_customer_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_projectid` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plist_sow` longblob DEFAULT NULL,
  `plist_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plist_state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plist_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plist_pincode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plist_startdate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_enddate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_budget` decimal(15,2) NOT NULL,
  `plist_final_price` decimal(15,2) DEFAULT NULL,
  `plist_checkrcv` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plist_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plist_delivered_on` varchar(20) DEFAULT NULL,
  `plist_payment_on` varchar(20) DEFAULT NULL,
  `plist_customeremail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plist_project_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plist_ongnew` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plist_project_status_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plist_coupon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plist_pt_mngr_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `project_list`
--
DELIMITER $$
CREATE TRIGGER `project_notification` AFTER INSERT ON `project_list` FOR EACH ROW BEGIN
    INSERT INTO notifications (
        ntfn_project_id,
        ntfn_forUserId,
        ntfn_notification,
        ntfn_hyperlink,
        ntfn_readflag,
        ntfn_date_time,
        ntfn_type,
        created_at,
        updated_at
    )
    VALUES (
        NEW.plist_id,
        NEW.plist_customer_id,
        CONCAT('New project created: ', NEW.plist_title),
        NULL,
        0,
        DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'),
        'cust',
        DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'),
        DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s')
    );

    INSERT INTO notifications (
        ntfn_project_id,
        ntfn_forUserId,
        ntfn_notification,
        ntfn_hyperlink,
        ntfn_readflag,
        ntfn_date_time,
        ntfn_type,
        created_at,
        updated_at
    )
    VALUES (
        NEW.plist_id,
        NEW.plist_customer_id,
        CONCAT('New project created: ', NEW.plist_title),
        NULL,
        0,
        DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'),
        'pt',
        DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'),
        DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s')
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `project_owners`
--

CREATE TABLE `project_owners` (
  `pown_id` bigint(20) NOT NULL,
  `pown_username` varchar(20) DEFAULT NULL,
  `pown_name` varchar(255) NOT NULL,
  `pown_user_type` varchar(200) DEFAULT NULL,
  `pown_country` varchar(255) DEFAULT NULL,
  `pown_state` varchar(255) DEFAULT NULL,
  `pown_address` varchar(255) DEFAULT NULL,
  `pown_pincode` varchar(255) DEFAULT NULL,
  `pown_contact` varchar(255) DEFAULT NULL,
  `pown_email` varchar(255) NOT NULL,
  `pown_date_of_registration` varchar(20) DEFAULT NULL,
  `pown_about` text DEFAULT NULL,
  `pown_organisation_name` varchar(255) DEFAULT NULL,
  `pown_cin` varchar(255) DEFAULT NULL,
  `pown_gstpin` varchar(255) DEFAULT NULL,
  `pown_adhaar` varchar(255) DEFAULT NULL,
  `pown_body` varchar(255) DEFAULT NULL,
  `pown_password` varchar(255) DEFAULT NULL,
  `pown_login_flag` tinyint(1) NOT NULL DEFAULT 1,
  `pown_adhaarfile` varchar(255) DEFAULT NULL,
  `pown_profile_completion_flag` tinyint(1) DEFAULT NULL,
  `pown_dp` varchar(255) DEFAULT NULL,
  `pown_refered_by` varchar(400) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_payments`
--

CREATE TABLE `project_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_planner`
--

CREATE TABLE `project_planner` (
  `pplnr_id` bigint(255) UNSIGNED NOT NULL,
  `pplnr_milestone` varchar(255) NOT NULL,
  `pplnr_description` text DEFAULT NULL,
  `pplnr_start_date` varchar(20) NOT NULL,
  `pplnr_end_date` varchar(20) NOT NULL,
  `pplnr_status` varchar(255) NOT NULL,
  `pplnr_scope_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_planner_tasks`
--

CREATE TABLE `project_planner_tasks` (
  `pptasks_id` bigint(20) UNSIGNED NOT NULL,
  `pptasks_task_title` varchar(255) NOT NULL,
  `pptasks_description` text DEFAULT NULL,
  `pptasks_start_date` varchar(20) DEFAULT NULL,
  `pptasks_end_date` varchar(20) DEFAULT NULL,
  `pptasks_sp_id` bigint(20) DEFAULT NULL,
  `pptasks_date_of_completion` date DEFAULT NULL,
  `pptasks_proof_of_completion` longblob DEFAULT NULL,
  `pptasks_sp_status` varchar(255) DEFAULT NULL,
  `pptasks_pt_status` varchar(255) DEFAULT NULL,
  `pptasks_invoice_raised_flag` tinyint(1) DEFAULT 0,
  `pptasks_payment` decimal(40,4) UNSIGNED DEFAULT NULL,
  `pptasks_planner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_scope`
--

CREATE TABLE `project_scope` (
  `pscope_id` bigint(255) UNSIGNED NOT NULL,
  `pscope_project_id` bigint(20) UNSIGNED NOT NULL,
  `pscope_country` varchar(255) NOT NULL,
  `pscope_state` varchar(255) NOT NULL,
  `pscope_city` varchar(255) NOT NULL,
  `pscope_pincode` varchar(255) NOT NULL,
  `pscope_address` varchar(400) DEFAULT NULL,
  `pscope_checkrcv` tinyint(1) DEFAULT NULL,
  `pscope_sow` blob DEFAULT NULL,
  `pscope_status` varchar(10) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_providers`
--

CREATE TABLE `service_providers` (
  `sprov_id` bigint(255) NOT NULL,
  `sprov_username` varchar(20) DEFAULT NULL,
  `sprov_name` varchar(255) DEFAULT NULL,
  `sprov_user_type` varchar(200) DEFAULT NULL,
  `sprov_country` varchar(255) DEFAULT NULL,
  `sprov_state` varchar(255) DEFAULT NULL,
  `sprov_address` varchar(255) DEFAULT NULL,
  `sprov_pincode` varchar(255) DEFAULT NULL,
  `sprov_contact` varchar(255) DEFAULT NULL,
  `sprov_email` varchar(255) DEFAULT NULL,
  `sprov_date_of_registration` varchar(20) DEFAULT NULL,
  `sprov_about` text DEFAULT NULL,
  `sprov_organisation_name` varchar(400) DEFAULT NULL,
  `sprov_cin` varchar(255) DEFAULT NULL,
  `sprov_gstpin` varchar(255) DEFAULT NULL,
  `sprov_adhaar` varchar(255) DEFAULT NULL,
  `sprov_body` enum('Organization','Individual') DEFAULT NULL,
  `sprov_password` varchar(255) DEFAULT NULL,
  `sprov_login_flag` tinyint(1) NOT NULL DEFAULT 1,
  `sprov_adhaarfile` varchar(255) DEFAULT NULL,
  `sprov_profile_completion_flag` tinyint(1) NOT NULL DEFAULT 0,
  `sprov_dp` varchar(255) DEFAULT NULL,
  `sprov_cv` varchar(255) DEFAULT NULL,
  `sprov_verified_flag` tinyint(1) NOT NULL DEFAULT 0,
  `sprov_skill1` varchar(255) DEFAULT NULL,
  `sprov_skill2` varchar(255) DEFAULT NULL,
  `sprov_skill3` varchar(255) DEFAULT NULL,
  `sprov_total_experience` int(11) DEFAULT NULL,
  `sprov_year_of_establishment` int(11) DEFAULT NULL,
  `sprov_refered_by` varchar(400) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `sp_task_payments`
--

CREATE TABLE `sp_task_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_conversation`
--

CREATE TABLE `task_conversation` (
  `tconv_id` bigint(20) UNSIGNED NOT NULL,
  `tconv_task_id` bigint(20) UNSIGNED NOT NULL,
  `tconv_msg_by` bigint(20) UNSIGNED NOT NULL,
  `tconv_msg_body` text NOT NULL,
  `tconv_msg_date_time` datetime NOT NULL,
  `tconv_attachments` varchar(255) DEFAULT NULL,
  `tconv_read_flag` tinyint(1) NOT NULL DEFAULT 0,
  `tconv_project_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `tckt_id` bigint(20) UNSIGNED NOT NULL,
  `tckt_project_id` varchar(255) DEFAULT NULL,
  `tckt_title` varchar(255) NOT NULL,
  `tckt_description` text NOT NULL,
  `tckt_date_time` datetime DEFAULT NULL,
  `tckt_status` varchar(255) DEFAULT NULL,
  `tckt_attachment` varchar(255) DEFAULT NULL,
  `tckt_conversation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tckt_customer_id` varchar(400) NOT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `td_id` int(11) NOT NULL,
  `td_user_id` int(11) NOT NULL,
  `td_user_type` varchar(50) NOT NULL,
  `td_event` varchar(255) NOT NULL,
  `td_date` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(400) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` bigint(20) DEFAULT NULL,
  `user_type` varchar(400) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weusers`
--

CREATE TABLE `weusers` (
  `id` int(11) NOT NULL,
  `username` varchar(400) NOT NULL,
  `password` varchar(400) NOT NULL,
  `email` varchar(400) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hardwares`
--
ALTER TABLE `hardwares`
  ADD PRIMARY KEY (`hrdws_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`ntfn_id`),
  ADD KEY `notifications_ntfn_project_id_foreign` (`ntfn_project_id`);

--
-- Indexes for table `orders_placed`
--
ALTER TABLE `orders_placed`
  ADD PRIMARY KEY (`ordplcd_id`);

--
-- Indexes for table `order_addresses`
--
ALTER TABLE `order_addresses`
  ADD PRIMARY KEY (`ordradrs_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `project_conversation`
--
ALTER TABLE `project_conversation`
  ADD PRIMARY KEY (`pconv_id`),
  ADD KEY `project_conversation_pconv_task_id_foreign` (`pconv_task_id`),
  ADD KEY `project_conversation_pconv_project_id_foreign` (`pconv_project_id`);

--
-- Indexes for table `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`plist_id`);

--
-- Indexes for table `project_owners`
--
ALTER TABLE `project_owners`
  ADD PRIMARY KEY (`pown_id`);

--
-- Indexes for table `project_payments`
--
ALTER TABLE `project_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_planner`
--
ALTER TABLE `project_planner`
  ADD PRIMARY KEY (`pplnr_id`),
  ADD KEY `project_planner_pplnr_scope_id_foreign` (`pplnr_scope_id`);

--
-- Indexes for table `project_planner_tasks`
--
ALTER TABLE `project_planner_tasks`
  ADD PRIMARY KEY (`pptasks_id`);

--
-- Indexes for table `project_scope`
--
ALTER TABLE `project_scope`
  ADD PRIMARY KEY (`pscope_id`);

--
-- Indexes for table `service_providers`
--
ALTER TABLE `service_providers`
  ADD PRIMARY KEY (`sprov_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `task_conversation`
--
ALTER TABLE `task_conversation`
  ADD PRIMARY KEY (`tconv_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`tckt_id`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`td_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weusers`
--
ALTER TABLE `weusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hardwares`
--
ALTER TABLE `hardwares`
  MODIFY `hrdws_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `ntfn_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_placed`
--
ALTER TABLE `orders_placed`
  MODIFY `ordplcd_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_addresses`
--
ALTER TABLE `order_addresses`
  MODIFY `ordradrs_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_conversation`
--
ALTER TABLE `project_conversation`
  MODIFY `pconv_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_list`
--
ALTER TABLE `project_list`
  MODIFY `plist_id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_owners`
--
ALTER TABLE `project_owners`
  MODIFY `pown_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_planner`
--
ALTER TABLE `project_planner`
  MODIFY `pplnr_id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_planner_tasks`
--
ALTER TABLE `project_planner_tasks`
  MODIFY `pptasks_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_scope`
--
ALTER TABLE `project_scope`
  MODIFY `pscope_id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_providers`
--
ALTER TABLE `service_providers`
  MODIFY `sprov_id` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_conversation`
--
ALTER TABLE `task_conversation`
  MODIFY `tconv_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `tckt_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `td_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weusers`
--
ALTER TABLE `weusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
