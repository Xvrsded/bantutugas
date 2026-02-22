SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `order_addons`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `packages`;
DROP TABLE IF EXISTS `addons`;
DROP TABLE IF EXISTS `portfolios`;
DROP TABLE IF EXISTS `testimonials`;
DROP TABLE IF EXISTS `contacts`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` enum('academic-sma','academic-kuliah','academic-makalah','academic-skripsi','academic-tesis','academic-revisi','academic-olahdata','tech-pcb','tech-iot','tech-webmonitoring','tech-programming') NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price_start` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price_end` decimal(10,2) DEFAULT NULL,
  `features` longtext,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price_per_unit` decimal(12,2) NOT NULL,
  `unit_label` varchar(255) NOT NULL DEFAULT 'unit',
  `description` text,
  `features` longtext,
  `min_quantity` int NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `packages_service_id_is_active_index` (`service_id`,`is_active`),
  CONSTRAINT `packages_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `addons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `description` text,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addons_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `client_phone` varchar(255) NOT NULL,
  `service_id` bigint unsigned NOT NULL,
  `package_id` bigint unsigned DEFAULT NULL,
  `project_title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `budget` decimal(12,2) DEFAULT NULL,
  `package_price` decimal(12,2) DEFAULT NULL,
  `addons_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(12,2) DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `unit_quantity` int DEFAULT NULL,
  `question_type` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `question_count` int DEFAULT NULL,
  `needs_explanation` tinyint(1) NOT NULL DEFAULT '0',
  `deadline_hours` int DEFAULT NULL,
  `difficulty_score` int DEFAULT NULL,
  `difficulty_level` varchar(255) DEFAULT NULL,
  `base_price` decimal(12,2) DEFAULT NULL,
  `multiplier` decimal(4,2) NOT NULL DEFAULT '1.00',
  `calculated_price` decimal(12,2) DEFAULT NULL,
  `final_price` decimal(12,2) DEFAULT NULL,
  `admin_adjusted_price` decimal(12,2) DEFAULT NULL,
  `price_overridden` tinyint(1) NOT NULL DEFAULT '0',
  `price_adjustment_reason` text,
  `price_adjustment_notes` text,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_choice` varchar(255) DEFAULT NULL,
  `dp_percentage` int DEFAULT NULL,
  `dp_amount` decimal(12,2) DEFAULT NULL,
  `remaining_amount` decimal(12,2) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','in_progress','completed','rejected') NOT NULL DEFAULT 'pending',
  `notes` longtext,
  `is_notified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_service_id_foreign` (`service_id`),
  KEY `orders_package_id_foreign` (`package_id`),
  CONSTRAINT `orders_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_addons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `addon_id` bigint unsigned NOT NULL,
  `addon_price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_addons_order_id_addon_id_unique` (`order_id`,`addon_id`),
  KEY `order_addons_addon_id_foreign` (`addon_id`),
  CONSTRAINT `order_addons_addon_id_foreign` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_addons_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `portfolios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` enum('academic','pcb','iot','webmonitoring','programming') NOT NULL DEFAULT 'academic',
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `project_url` varchar(255) DEFAULT NULL,
  `technologies` longtext,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `message` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_is_approved_index` (`is_approved`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_is_read_index` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`id`,`name`,`category`,`description`,`icon`,`image`,`price_start`,`price_end`,`features`,`is_active`,`created_at`,`updated_at`) VALUES
(1,'Tugas SMA (Matematika, IPA, IPS)','academic-sma','Bantuan mengerjakan tugas sekolah menengah atas dengan solusi lengkap dan penjelasan','book',NULL,50000.00,200000.00,'["Solusi lengkap","Penjelasan detail","Revisi unlimited","Dijamin akurat"]',1,NOW(),NOW()),
(2,'Tugas Kuliah (Semua Jurusan)','academic-kuliah','Bantuan mengerjakan tugas perkuliahan dari berbagai disiplin ilmu','book',NULL,75000.00,500000.00,'["Sesuai kurikulum","Sumber terpercaya","Format APA/Harvard","Konsultasi gratis"]',1,NOW(),NOW()),
(3,'Penulisan Makalah & Paper','academic-makalah','Penulisan makalah ilmiah dengan struktur dan format yang sempurna','file-earmark-text',NULL,150000.00,1000000.00,'["Plagiasi 0%","Referensi lengkap","Edit berkali-kali","Pengumpulan tepat waktu"]',1,NOW(),NOW()),
(4,'Penulisan Skripsi','academic-skripsi','Pendampingan lengkap penulisan skripsi dari awal hingga akhir','book-half',NULL,500000.00,5000000.00,'["Konsultasi langsung","Siap revisi dosen","Panduan presentasi","Garansi lulus"]',1,NOW(),NOW()),
(5,'Penulisan Tesis & Disertasi','academic-tesis','Pendampingan penulisan tesis untuk program pasca sarjana','book-half',NULL,2000000.00,10000000.00,'["Mentor profesional","Publikasi siap","Defendable content","Support penuh"]',1,NOW(),NOW()),
(6,'Revisi & Editing Dosen','academic-revisi','Membantu memperbaiki revisi dari dosen dengan detail dan profesional','pencil-square',NULL,100000.00,800000.00,'["Cepat & efisien","Sesuai feedback","Garansi revisi diterima","Update real-time"]',1,NOW(),NOW()),
(7,'Olah Data & Analisis Statistik','academic-olahdata','Pengolahan data penelitian menggunakan software statistik profesional','graph-up',NULL,200000.00,2000000.00,'["SPSS, R, Python","Interpretasi lengkap","Siap publikasi","Konsultasi analisis"]',1,NOW(),NOW()),
(8,'Desain & Fabrikasi PCB','tech-pcb','Desain PCB profesional dan layanan fabrikasi untuk proyek elektronik Anda','cpu',NULL,300000.00,3000000.00,'["Desain KiCad/Eagle","Simulasi lengkap","Produksi prototype","Testing support"]',1,NOW(),NOW()),
(9,'Proyek IoT (Arduino & ESP32)','tech-iot','Pengembangan proyek IoT lengkap dengan mikrokontroler Arduino dan ESP32','bezier2',NULL,500000.00,5000000.00,'["Program microcontroller","Cloud integration","Sensor interfacing","Mobile app"]',1,NOW(),NOW()),
(10,'Web Monitoring & Dashboard','tech-webmonitoring','Membuat sistem monitoring real-time dengan dashboard web interaktif','graph-up-arrow',NULL,1000000.00,10000000.00,'["Real-time data","API integration","Database design","Responsive design"]',1,NOW(),NOW()),
(11,'Jasa Pemrograman & Development','tech-programming','Layanan development website, aplikasi web, dan backend system','code-square',NULL,1500000.00,20000000.00,'["Full stack dev","Database design","API development","Testing & QA"]',1,NOW(),NOW());

INSERT INTO `packages` (`service_id`,`name`,`slug`,`price_per_unit`,`unit_label`,`description`,`features`,`min_quantity`,`is_active`,`sort_order`,`created_at`,`updated_at`)
SELECT id,'Paket Hemat','hemat',
CASE
WHEN category LIKE '%sma%' THEN 25000
WHEN category LIKE '%kuliah%' THEN 35000
WHEN category LIKE '%makalah%' THEN 5000
WHEN category LIKE '%skripsi%' THEN 8000
WHEN category LIKE '%tesis%' THEN 15000
WHEN category LIKE '%revisi%' THEN 3000
ELSE 250000
END,
CASE
WHEN category LIKE '%sma%' THEN 'paket'
WHEN category LIKE '%kuliah%' THEN 'paket'
WHEN category LIKE '%makalah%' THEN 'halaman'
WHEN category LIKE '%skripsi%' THEN 'halaman'
WHEN category LIKE '%tesis%' THEN 'halaman'
WHEN category LIKE '%revisi%' THEN 'halaman'
ELSE 'item'
END,
CONCAT('Paket ekonomis untuk ', name, '. Pengerjaan standar tanpa revisi.'),
'["Pengerjaan standar","Format dasar","Tanpa revisi","Deadline normal (5-7 hari)","WhatsApp support"]',
CASE
WHEN category LIKE '%sma%' THEN 1
WHEN category LIKE '%kuliah%' THEN 1
WHEN category LIKE '%makalah%' THEN 5
WHEN category LIKE '%skripsi%' THEN 50
WHEN category LIKE '%tesis%' THEN 80
WHEN category LIKE '%revisi%' THEN 10
ELSE 1
END,
1,1,NOW(),NOW()
FROM services;

INSERT INTO `packages` (`service_id`,`name`,`slug`,`price_per_unit`,`unit_label`,`description`,`features`,`min_quantity`,`is_active`,`sort_order`,`created_at`,`updated_at`)
SELECT id,'Paket Standar','standar',
CASE
WHEN category LIKE '%sma%' THEN 40000
WHEN category LIKE '%kuliah%' THEN 55000
WHEN category LIKE '%makalah%' THEN 8000
WHEN category LIKE '%skripsi%' THEN 12000
WHEN category LIKE '%tesis%' THEN 30000
WHEN category LIKE '%revisi%' THEN 5000
ELSE 400000
END,
CASE
WHEN category LIKE '%sma%' THEN 'paket'
WHEN category LIKE '%kuliah%' THEN 'paket'
WHEN category LIKE '%makalah%' THEN 'halaman'
WHEN category LIKE '%skripsi%' THEN 'halaman'
WHEN category LIKE '%tesis%' THEN 'halaman'
WHEN category LIKE '%revisi%' THEN 'halaman'
ELSE 'item'
END,
CONCAT('Paket populer untuk ', name, '. Dengan 1x revisi gratis.'),
'["Pengerjaan detail","Format rapi & profesional","1x revisi gratis","Deadline fleksibel (3-5 hari)","WhatsApp + Email support","Konsultasi singkat"]',
CASE
WHEN category LIKE '%sma%' THEN 1
WHEN category LIKE '%kuliah%' THEN 1
WHEN category LIKE '%makalah%' THEN 5
WHEN category LIKE '%skripsi%' THEN 50
WHEN category LIKE '%tesis%' THEN 80
WHEN category LIKE '%revisi%' THEN 10
ELSE 1
END,
1,2,NOW(),NOW()
FROM services;

INSERT INTO `packages` (`service_id`,`name`,`slug`,`price_per_unit`,`unit_label`,`description`,`features`,`min_quantity`,`is_active`,`sort_order`,`created_at`,`updated_at`)
SELECT id,'Paket Premium','premium',
CASE
WHEN category LIKE '%sma%' THEN 60000
WHEN category LIKE '%kuliah%' THEN 85000
WHEN category LIKE '%makalah%' THEN 12000
WHEN category LIKE '%skripsi%' THEN 18000
WHEN category LIKE '%tesis%' THEN 60000
WHEN category LIKE '%revisi%' THEN 8000
ELSE 600000
END,
CASE
WHEN category LIKE '%sma%' THEN 'paket'
WHEN category LIKE '%kuliah%' THEN 'paket'
WHEN category LIKE '%makalah%' THEN 'halaman'
WHEN category LIKE '%skripsi%' THEN 'halaman'
WHEN category LIKE '%tesis%' THEN 'halaman'
WHEN category LIKE '%revisi%' THEN 'halaman'
ELSE 'item'
END,
CONCAT('Paket terbaik untuk ', name, '. Dengan 2x revisi & priority service.'),
'["Pengerjaan expert level","Format premium & sempurna","2x revisi gratis","Priority deadline (1-3 hari)","24/7 WhatsApp support","Konsultasi detail","Quality assurance & cek plagiasi"]',
CASE
WHEN category LIKE '%sma%' THEN 1
WHEN category LIKE '%kuliah%' THEN 1
WHEN category LIKE '%makalah%' THEN 5
WHEN category LIKE '%skripsi%' THEN 50
WHEN category LIKE '%tesis%' THEN 80
WHEN category LIKE '%revisi%' THEN 10
ELSE 1
END,
1,3,NOW(),NOW()
FROM services;

INSERT INTO `addons` (`name`,`slug`,`type`,`price`,`description`,`icon`,`is_active`,`sort_order`,`created_at`,`updated_at`) VALUES
('⚡ Express 24 Jam','express-24','percentage',20.00,'Pengerjaan dipercepat, selesai dalam 24 jam (tidak termasuk hari libur)','bi-lightning-charge-fill',1,1,NOW(),NOW()),
('🌍 Bahasa Inggris','english-version','percentage',30.00,'Dikerjakan dalam bahasa Inggris yang baik dan profesional','bi-globe',1,2,NOW(),NOW()),
('📋 Turnitin Check','turnitin-check','fixed',25000.00,'Cek plagiarisme lengkap dengan laporan similarity dari Turnitin','bi-shield-check',1,3,NOW(),NOW()),
('📊 Analisis Statistik','statistics-analysis','fixed',150000.00,'Ditambahkan analisis data & grafik statistik berkualitas SPSS/Excel','bi-bar-chart',1,4,NOW(),NOW()),
('💻 Source Code & Demo','source-code-demo','fixed',200000.00,'Source code lengkap + demo aplikasi + dokumentasi teknis','bi-code-slash',1,5,NOW(),NOW()),
('🎥 Ngezoom Bareng','zoom-bareng','percentage',15.00,'Sesi Zoom tambahan untuk bahas materi sampai jelas (upgrade dari paket)','bi-arrow-repeat',1,6,NOW(),NOW()),
('📑 Format & Finishing','formatting-finishing','fixed',50000.00,'Formatting sempurna sesuai standar, daftar isi otomatis, margin presisi','bi-file-earmark-richtext',1,7,NOW(),NOW()),
('📹 Video Penjelasan','video-explanation','fixed',75000.00,'Video penjelasan 10-15 menit cara penyelesaian & teori penting','bi-play-circle',1,8,NOW(),NOW()),
('🎤 Konsultasi 1 Jam','consultation-1hour','fixed',100000.00,'Sesi bimbingan langsung 1 jam via Zoom/WhatsApp call','bi-camera-video',1,9,NOW(),NOW()),
('🎨 Presentasi Slide Pro','presentation-pro','fixed',120000.00,'Slide presentasi profesional + animasi + script presentasi','bi-file-earmark-slides',1,10,NOW(),NOW());

INSERT INTO `portfolios` (`title`,`category`,`description`,`image`,`client_name`,`project_url`,`technologies`,`is_featured`,`created_at`,`updated_at`) VALUES
('IoT Automation Gates','iot','Sistem IoT automation gates menggunakan RFID untuk akses gerbang otomatis dengan monitoring status perangkat secara real-time.','portfolio-images/IoT1.jpg|portfolio-images/IoT2.jpg','PT Teknologi Maju','#','["ESP32","RFID","Firebase","Arduino IDE"]',1,NOW(),NOW()),
('Website Monitoring Detak Jantung','programming','Website monitoring detak jantung berbasis dashboard real-time untuk menampilkan data sensor secara akurat dan responsif.','portfolio-images/websiteMonitoring.png|portfolio-images/websiteMonitoring2.png','Universitas Mitra','#','["Laravel","MySQL","Chart.js","Bootstrap"]',1,NOW(),NOW()),
('Design PCB','pcb','Perancangan design PCB dari skematik hingga layout siap produksi untuk kebutuhan prototipe dan implementasi perangkat elektronik.','portfolio-images/DesignPCB1.png|portfolio-images/DesignPCB2.png','Client Industri Elektronik','#','["KiCad","Altium","Gerber","Soldering"]',1,NOW(),NOW());

SET FOREIGN_KEY_CHECKS=1;
