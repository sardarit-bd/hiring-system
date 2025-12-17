-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2025 at 06:39 AM
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
-- Database: `job_portal`
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('job-portal-cache-settings', 'a:16:{s:9:\"site_name\";s:10:\"Job Portal\";s:9:\"site_logo\";N;s:12:\"site_favicon\";N;s:13:\"contact_phone\";s:14:\"+8801XXXXXXXXX\";s:13:\"contact_email\";s:16:\"info@example.com\";s:15:\"contact_address\";s:17:\"Dhaka, Bangladesh\";s:16:\"terms_conditions\";s:70:\"<h3>Terms & Conditions</h3><p>Please read these terms carefully...</p>\";s:14:\"privacy_policy\";s:64:\"<h3>Privacy Policy</h3><p>Your privacy is important to us...</p>\";s:8:\"about_us\";s:52:\"<h3>About Us</h3><p>Welcome to our job portal...</p>\";s:12:\"facebook_url\";s:20:\"https://facebook.com\";s:11:\"twitter_url\";s:19:\"https://twitter.com\";s:12:\"linkedin_url\";s:20:\"https://linkedin.com\";s:13:\"instagram_url\";s:21:\"https://instagram.com\";s:10:\"meta_title\";s:32:\"Job Portal - Find Your Dream Job\";s:16:\"meta_description\";s:39:\"Find your dream job with our job portal\";s:13:\"meta_keywords\";s:35:\"job, career, employment, bangladesh\";}', 2081304330);

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'fas fa-briefcase',
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `jobs_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `description`, `is_active`, `jobs_count`, `created_at`, `updated_at`) VALUES
(1, 'Technology', 'technology', 'fas fa-laptop-code', 'Software development, IT services, and tech related jobs', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(2, 'Marketing', 'marketing', 'fas fa-chart-line', 'Digital marketing, SEO, social media, and advertising', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(3, 'Finance', 'finance', 'fas fa-hand-holding-usd', 'Accounting, banking, investment, and financial services', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(4, 'Healthcare', 'healthcare', 'fas fa-user-md', 'Medical, nursing, pharmacy, and healthcare services', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(5, 'Design', 'design', 'fas fa-paint-brush', 'UI/UX design, graphic design, and creative roles', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(6, 'Sales', 'sales', 'fas fa-shopping-cart', 'Sales executive, business development, and retail', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(7, 'Education', 'education', 'fas fa-graduation-cap', 'Teaching, training, academic, and educational roles', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(8, 'Engineering', 'engineering', 'fas fa-wrench', 'Civil, mechanical, electrical, and other engineering fields', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(9, 'Human Resources', 'human-resources', 'fas fa-users', 'HR management, recruitment, and talent acquisition', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(10, 'Customer Service', 'customer-service', 'fas fa-headset', 'Customer support, call center, and service roles', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(11, 'Legal', 'legal', 'fas fa-balance-scale', 'Lawyer, paralegal, legal advisor, and compliance', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08'),
(12, 'Remote', 'remote', 'fas fa-home', 'Work from home and remote opportunities', 1, 0, '2025-12-16 05:16:08', '2025-12-16 05:16:08');

-- --------------------------------------------------------

--
-- Table structure for table `certifications`
--

CREATE TABLE `certifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `certification_name` varchar(255) NOT NULL,
  `issuing_organization` varchar(255) DEFAULT NULL,
  `credential_id` varchar(255) DEFAULT NULL,
  `credential_url` varchar(255) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `does_not_expire` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certifications`
--

INSERT INTO `certifications` (`id`, `user_id`, `certification_name`, `issuing_organization`, `credential_id`, `credential_url`, `issue_date`, `expiration_date`, `does_not_expire`, `description`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 5, 'AWS', 'Amazon', '2545645', 'https://shimzo.xyz', '2025-12-01', '2025-12-13', 0, 'kkkkkkk', 0, '2025-12-16 06:50:46', '2025-12-16 07:14:01');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `field_of_study` varchar(255) DEFAULT NULL,
  `start_year` year(4) DEFAULT NULL,
  `end_year` year(4) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `user_id`, `degree`, `institution`, `field_of_study`, `start_year`, `end_year`, `result`, `is_current`, `description`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 5, 'BSc', 'National University', 'CSE', '2018', '2022', '3.99', 0, 'very much ok', 0, '2025-12-16 04:13:26', '2025-12-16 04:13:26'),
(2, 5, 'MSc', 'National University', 'CSE', '2022', '2023', '3.00', 0, 'ok', 0, '2025-12-16 04:15:12', '2025-12-16 04:15:12');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `employment_type` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `skills_used` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills_used`)),
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `user_id`, `job_title`, `company_name`, `employment_type`, `start_date`, `end_date`, `is_current`, `location`, `description`, `skills_used`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 5, 'Trainee', 'Sarkar IT', 'full_time', '2025-12-01', '2025-12-15', 0, 'Dhaka', 'Not ok', '[\"Laraval\"]', 0, '2025-12-16 04:55:14', '2025-12-16 07:12:53');

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
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `job_seeker_id` bigint(20) UNSIGNED NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','reviewed','shortlisted','rejected','hired') NOT NULL DEFAULT 'pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `job_seeker_id`, `cover_letter`, `resume_path`, `status`, `applied_at`, `reviewed_at`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'kklllllllllhjuuuuuuuuuuuuuuuuuudhsnv skkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkajgrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 'resumes/EplkIhCnXekZxIcrscbPqW4973e0ApArhaqz9wuV.pdf', 'pending', '2025-12-15 03:58:26', NULL, NULL, '2025-12-15 03:58:26', '2025-12-15 03:58:26'),
(2, 2, 5, 'I am writing to express my interest in the Developer position at your company. I am a passionate and detail-oriented developer with hands-on experience in building web applications using modern technologies. I enjoy solving real-world problems through clean, efficient, and scalable code.\r\n\r\nI have experience working with technologies such as HTML, CSS, JavaScript, PHP (Laravel), React, and MySQL, and I am familiar with version control systems like Git/GitHub. I have built projects involving authentication, CRUD operations, REST APIs, and responsive user interfaces. These experiences have strengthened my understanding of both frontend and backend development.\r\n\r\nI am always eager to learn new technologies and improve my skills. I can work independently as well as collaboratively in a team environment. I take responsibility for my work and focus on writing maintainable and well-structured code.', 'resumes/LresPp3d654EUhh85Q3OeMYSGbW6O1zVHQHLblzV.pdf', 'shortlisted', '2025-12-15 21:14:28', '2025-12-15 21:16:58', NULL, '2025-12-15 21:14:29', '2025-12-15 21:16:58');

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
-- Table structure for table `job_seeker_profiles`
--

CREATE TABLE `job_seeker_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `professional_title` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `experience_level` varchar(255) DEFAULT NULL,
  `preferred_job_title` varchar(255) DEFAULT NULL,
  `job_type_preference` varchar(255) DEFAULT NULL,
  `expected_salary` varchar(255) DEFAULT NULL,
  `preferred_location` varchar(255) DEFAULT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `languages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`languages`)),
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `profile_completion` int(11) NOT NULL DEFAULT 0,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `portfolio_website` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_seeker_profiles`
--

INSERT INTO `job_seeker_profiles` (`id`, `user_id`, `professional_title`, `summary`, `experience_level`, `preferred_job_title`, `job_type_preference`, `expected_salary`, `preferred_location`, `availability`, `date_of_birth`, `gender`, `languages`, `social_links`, `profile_completion`, `is_public`, `portfolio_website`, `created_at`, `updated_at`) VALUES
(1, 5, 'Laravel Developer', 'Lorem ipsum dollar sit amet', 'fresher', 'Developer', 'full_time', '50000', 'Dhaka', 'immediate', '2001-08-09', 'male', '[\"English\"]', '{\"github\":\"https:\\/\\/shimzo.xyz\",\"linkedin\":\"https:\\/\\/shimzo.xyz\",\"portfolio\":\"https:\\/\\/shimzo.xyz\"}', 90, 1, 'https://shimzo.xyz', '2025-12-16 04:10:06', '2025-12-16 06:42:16');

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
(4, '2025_12_15_072204_create_personal_access_tokens_table', 1),
(5, '2025_12_15_072603_add_roles_to_users_table', 2),
(6, '2025_12_15_072711_create_openjobs_table', 2),
(7, '2025_12_15_072731_create_job_applications_table', 2),
(8, '2025_12_16_092954_create_job_seeker_profiles_table', 3),
(9, '2025_12_16_093043_create_experiences_table', 3),
(10, '2025_12_16_093105_create_projects_table', 3),
(11, '2025_12_16_093126_create_certifications_table', 3),
(12, '2025_12_16_100346_create_education_table', 4),
(13, '2025_12_16_110840_create_categories_table', 5),
(14, '2025_12_16_161040_create_settings_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `openjobs`
--

CREATE TABLE `openjobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `job_type` enum('full_time','part_time','contract','internship','remote') NOT NULL,
  `salary_min` decimal(10,2) DEFAULT NULL,
  `salary_max` decimal(10,2) DEFAULT NULL,
  `salary_type` varchar(255) NOT NULL DEFAULT 'monthly',
  `deadline` date NOT NULL,
  `vacancy` int(11) NOT NULL DEFAULT 1,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `openjobs`
--

INSERT INTO `openjobs` (`id`, `employer_id`, `title`, `description`, `requirements`, `category`, `location`, `job_type`, `salary_min`, `salary_max`, `salary_type`, `deadline`, `vacancy`, `status`, `is_active`, `views`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'Demo Job 1', 'Lorem ipsum dollor sit amet', '1. demo 1\r\n2. demo 2\r\n3. demo 3', 'Finance', 'Dhaka', 'full_time', 2500.00, 3000.00, 'monthly', '2025-12-31', 2, 'approved', 1, 37, '2025-12-15 21:07:04', '2025-12-16 09:27:39', NULL),
(2, 3, 'Demo Job 5', 'Lorem ipsum dollar sit amet', 'B.Sc & M.Sc', 'Technology', 'Dhaka', 'full_time', 2000.00, 3000.00, 'monthly', '2025-12-31', 5, 'approved', 1, 13, '2025-12-15 21:07:04', '2025-12-17 04:38:06', NULL),
(3, 3, 'Demo job 3', 'Lorem ipsum dolar Lorem ipsum dolar Lorem ipsum dolar Lorem ipsum dolar Lorem ipsum dolar', 'BSc', 'Sales', 'Dhaka', 'full_time', 2200.00, 3000.00, 'monthly', '2025-12-31', 10, 'approved', 1, 1, '2025-12-16 09:26:22', '2025-12-16 09:54:29', NULL),
(4, 3, 'Demo job 2', 'Lorem ipsum dolar Lorem ipsum dolar Lorem ipsum dolar Lorem ipsum dolar Lorem ipsum dolar Lorem ipsum dolar', 'MSc', 'Engineering', 'Dhaka', 'full_time', 22300.00, 30000.00, 'monthly', '2025-12-31', 1, 'approved', 1, 8, '2025-12-16 09:27:27', '2025-12-17 04:50:31', NULL),
(5, 3, 'Demo job 7', 'lorem ipsum dolar lorem ipsum dolar lorem ipsum dolar lorem ipsum dolar', 'Bsc', 'Education', 'Dhaka', 'full_time', 50000.00, 60000.00, 'monthly', '2025-12-31', 12, 'approved', 1, 0, '2025-12-17 05:00:30', '2025-12-17 05:00:41', NULL),
(6, 3, 'Demo Job legal', 'lorem ipsum dolar lorem ipsum dolar lorem ipsum dolar lorem ipsum dolar lorem ipsum dolar', 'M.Sc.', 'Legal', 'Dhaka', 'full_time', 40000.00, 60000.00, 'monthly', '2025-12-31', 5, 'approved', 1, 0, '2025-12-17 05:22:50', '2025-12-17 05:23:47', NULL),
(7, 3, 'Demo Job legal', 'lorem ipsum dolar lorem ipsum dolar lorem ipsum dolar lorem ipsum dolar lorem ipsum dolar', 'M.Sc.', 'Legal', 'Dhaka', 'full_time', 40000.00, 60000.00, 'monthly', '2025-12-31', 5, 'pending', 1, 0, '2025-12-17 05:22:50', '2025-12-17 05:23:00', '2025-12-17 05:23:00'),
(8, 3, 'Demo Job 9', 'lorem ipsum dolar lorem ipsum dolar lorem ipsum dolar', 'Masters', 'Design', 'Dhaka', 'full_time', 40000.00, 60000.00, 'monthly', '2025-12-31', 1, 'approved', 1, 0, '2025-12-17 05:23:35', '2025-12-17 05:23:46', NULL);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `technologies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`technologies`)),
  `github_link` varchar(255) DEFAULT NULL,
  `live_link` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_ongoing` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `project_name`, `description`, `technologies`, `github_link`, `live_link`, `start_date`, `end_date`, `is_ongoing`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 5, 'Smart Parking System', 'Lorem ipsum demo daollar Lorem ipsum demo daollar Lorem ipsum demo daollar Lorem ipsum demo daollar Lorem ipsum demo daollar Lorem ipsum demo daollar Lorem ipsum demo daollar Lorem ipsum demo daollar Lorem ipsum demo daollar Lorem ipsum demo daollar', '[\"Laravel\",\"ReactJs\"]', 'https://github/mishimanto/e-commerce', 'https://r.shimzo.xyz', '2025-12-01', '2025-12-05', 0, 0, '2025-12-16 04:58:59', '2025-12-16 07:12:09');

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
('5FeKBbI5lO0QmaMH4JU0VhRmvNZCEozIA9tckAFp', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU2l1bUxzZG5CSmdXN1pJeWpwa2xhMnlHOE90cm9IbEFCU1VyR2E3OSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1765949813),
('OF58E6tZplsbMIk5O1IVDsHevGKqDP8qtgBeE8VY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMTc0QVI1RTNnOHgwajE4cDJpRzJLZ1czWXpYQWdUS0VtSnVqaWR1ayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9qb2JzIjtzOjU6InJvdXRlIjtzOjEwOiJqb2JzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765947750),
('sQjc6dQpl7I1c95yV1B5HsAvUrHgzKsqehA8MqSe', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib2JZNTJtR0RiV2xLdnpCc2FlMmVoanpYVXNNWlFKMjY2UzdmOW13YSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9qb2JzIjtzOjU6InJvdXRlIjtzOjEwOiJqb2JzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1765879596),
('wef9uYhdnNADFa3BdbKDbsdrZViNvjTF3vqDulb5', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT0d2N0o0Z3dQRDlLdWl1UFVicXlhSHpSeVFlMmRaTmt0WXMydWVrMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9qb2JzIjtzOjU6InJvdXRlIjtzOjEwOiJhZG1pbi5qb2JzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1765949027),
('X77AEysZpYoDocH5Mowq2CLv10ostCHxYJOmuaUQ', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaHo0T29uQVJSQnJheG9MaXJiTWpuWno1TGRoQlY1TEI0a2JOdE9QTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1765885822),
('zP3c3I2YWDy6qN5IUIyOQpzv9HXYARsZqhxnmhLF', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM2I5dzlrSUZYdThyT2tOVnVBcDJxdk5zeXI1R0VXa0hlNkU3dk5EWCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vc2V0dGluZ3MiO3M6NToicm91dGUiO3M6MjA6ImFkbWluLnNldHRpbmdzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1765885956);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `description`, `order`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Job Portal', 'text', 'general', 'Website Name', 1, NULL, '2025-12-17 04:04:22'),
(2, 'site_logo', NULL, 'image', 'general', 'Website Logo', 2, NULL, NULL),
(3, 'site_favicon', NULL, 'image', 'general', 'Website Favicon', 3, NULL, NULL),
(4, 'contact_phone', '+8801XXXXXXXXX', 'phone', 'contact', 'Contact Phone Number', 4, NULL, NULL),
(5, 'contact_email', 'info@example.com', 'email', 'contact', 'Contact Email Address', 5, NULL, NULL),
(6, 'contact_address', 'Dhaka, Bangladesh', 'textarea', 'contact', 'Physical Address', 6, NULL, NULL),
(7, 'terms_conditions', '<h3>Terms & Conditions</h3><p>Please read these terms carefully...</p>', 'textarea', 'legal', 'Terms and Conditions Content', 7, NULL, NULL),
(8, 'privacy_policy', '<h3>Privacy Policy</h3><p>Your privacy is important to us...</p>', 'textarea', 'legal', 'Privacy Policy Content', 8, NULL, NULL),
(9, 'about_us', '<h3>About Us</h3><p>Welcome to our job portal...</p>', 'textarea', 'general', 'About Us Content', 9, NULL, NULL),
(10, 'facebook_url', 'https://facebook.com', 'text', 'social', 'Facebook Page URL', 10, NULL, NULL),
(11, 'twitter_url', 'https://twitter.com', 'text', 'social', 'Twitter Profile URL', 11, NULL, NULL),
(12, 'linkedin_url', 'https://linkedin.com', 'text', 'social', 'LinkedIn Profile URL', 12, NULL, NULL),
(13, 'instagram_url', 'https://instagram.com', 'text', 'social', 'Instagram Profile URL', 13, NULL, NULL),
(14, 'meta_title', 'Job Portal - Find Your Dream Job', 'text', 'seo', 'Website Meta Title', 14, NULL, NULL),
(15, 'meta_description', 'Find your dream job with our job portal', 'textarea', 'seo', 'Website Meta Description', 15, NULL, NULL),
(16, 'meta_keywords', 'job, career, employment, bangladesh', 'text', 'seo', 'Website Meta Keywords', 16, NULL, NULL);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','employer','job_seeker') NOT NULL DEFAULT 'job_seeker',
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `address`, `company_name`, `website`, `industry`, `resume_path`, `skills`, `experience`, `education`, `is_active`) VALUES
(1, 'Test User', 'test@example.com', '2025-12-15 02:29:32', '$2y$12$MrdNMf2ISSBszQH5yDklq.0urtoBvPLvb8iTMmAF//VKL3X6ZEU0G', 'ivVbNC1QrN', '2025-12-15 02:29:32', '2025-12-15 02:29:32', 'job_seeker', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Admin User', 'admin@gmail.com', '2025-12-15 02:30:47', '$2y$12$7fdDkYRfZTi7jYxZat7RV./T5FRrOyz8AJRPvTXT0Kjp9fueJ4Ndi', NULL, '2025-12-15 02:30:47', '2025-12-15 21:10:38', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, 'Tech Solutions Inc.', 'employer@gmail.com', '2025-12-15 02:30:47', '$2y$12$zGa5zdy.chBlJJaVLQogg.Cbu5Vh758OzZlE3s3VhqPGySMaMYUoe', NULL, '2025-12-15 02:30:47', '2025-12-15 21:05:44', 'employer', '+1 234 567 8900', NULL, 'Tech Solutions Inc.', 'https://techsolutions.com', 'Information Technology', NULL, NULL, NULL, NULL, 1),
(4, 'John Doe', 'john@example.com', '2025-12-15 02:30:47', '$2y$12$/2CBPSQS75nnOxRGqBusSuPegq05u3uj81VXtWHhrx5kRTV1aDr.G', NULL, '2025-12-15 02:30:47', '2025-12-15 02:30:47', 'job_seeker', '+1 234 567 8901', NULL, NULL, NULL, NULL, NULL, '\"[\\\"PHP\\\",\\\"Laravel\\\",\\\"MySQL\\\",\\\"JavaScript\\\"]\"', '5 years of web development experience', 'Bachelor of Computer Science', 1),
(5, 'Tonmoy Mirza', 'abc@gmail.com', NULL, '$2y$12$zGa5zdy.chBlJJaVLQogg.Cbu5Vh758OzZlE3s3VhqPGySMaMYUoe', NULL, '2025-12-15 02:35:53', '2025-12-16 03:18:49', 'job_seeker', '01949854504', NULL, NULL, NULL, NULL, 'resumes/mJlH2hhLbdK84No2cTGSEpXNL98hL0IxQsYXIQYg.pdf', NULL, NULL, NULL, 1),
(6, 'Admin User', 'admin@jobportal.com', '2025-12-16 05:15:41', '$2y$12$44nfWIkY83LjT.inB3F8Ne/zPq3vtFY7rt4K0Ckv3Lmo2aGIznyPm', NULL, '2025-12-16 05:15:41', '2025-12-16 05:15:41', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(7, 'Tech Solutions Inc.', 'employer@tech.com', '2025-12-16 05:15:41', '$2y$12$jj8JRoZ2UCOJtABrMCuQdOwug0oY0BrHBTqthQn3SzdM.Ljd9em0a', NULL, '2025-12-16 05:15:41', '2025-12-16 05:15:41', 'employer', '+1 234 567 8900', NULL, 'Tech Solutions Inc.', 'https://techsolutions.com', 'Information Technology', NULL, NULL, NULL, NULL, 1);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `certifications`
--
ALTER TABLE `certifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `education_user_id_index` (`user_id`),
  ADD KEY `education_sort_order_index` (`sort_order`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experiences_user_id_foreign` (`user_id`);

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
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_applications_job_id_job_seeker_id_unique` (`job_id`,`job_seeker_id`),
  ADD KEY `job_applications_job_seeker_id_foreign` (`job_seeker_id`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_seeker_profiles`
--
ALTER TABLE `job_seeker_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_seeker_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `openjobs`
--
ALTER TABLE `openjobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `openjobs_employer_id_foreign` (`employer_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `certifications`
--
ALTER TABLE `certifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_seeker_profiles`
--
ALTER TABLE `job_seeker_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `openjobs`
--
ALTER TABLE `openjobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certifications`
--
ALTER TABLE `certifications`
  ADD CONSTRAINT `certifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `education_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `experiences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `openjobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_job_seeker_id_foreign` FOREIGN KEY (`job_seeker_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_seeker_profiles`
--
ALTER TABLE `job_seeker_profiles`
  ADD CONSTRAINT `job_seeker_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `openjobs`
--
ALTER TABLE `openjobs`
  ADD CONSTRAINT `openjobs_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
