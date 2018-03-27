/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 10.1.19-MariaDB : Database - lavida
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lavida` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `lavida`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'kategori1','2017-03-16 17:04:42','2017-03-16 17:04:42'),
(2,'kategori22','2017-03-16 17:05:00','2017-03-16 17:40:23'),
(3,'kategori3','2017-03-16 17:07:15','2017-03-16 17:07:15'),
(4,'kategori44','2017-03-16 17:12:13','2017-03-16 17:40:28'),
(5,'kategori5','2017-03-16 17:13:14','2017-03-16 17:13:14'),
(6,'kategori6','2017-03-16 17:40:43','2017-03-16 17:40:43');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pic_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pic_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pic_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pic_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `customers` */

insert  into `customers`(`id`,`customer_code`,`customer_name`,`pic_name`,`pic_contact`,`pic_email`,`pic_phone`,`customer_location`,`customer_description`,`status`,`created_at`,`updated_at`) values 
(1,'CU1','customer11','customer11picc','081208120812','customer1@gmail.com','','customer1 location','customer1 description',1,'2017-01-25 08:29:08','2017-03-15 14:11:12'),
(2,'CU2','customer22','customer2pic','082208220822','customer2@gmail.com','','customer2 location','customer2 description',0,'2027-02-25 08:29:08','2017-08-09 17:13:44'),
(3,'CU3','customer3','piccustomer3','081208120812','emailcus3@gmail.com','','lokasi cus3','deskripsi cus3',1,'2017-02-27 17:18:31','2017-03-09 11:48:08'),
(4,'CU4','customer4','adfasf','4','asdfasdf@ccs.ss','','lokasi44','desc asdfasdf',0,'2017-03-15 15:40:11','2017-08-09 17:13:48');

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_sku` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_category` int(11) DEFAULT NULL,
  `supplier_id` int(10) unsigned DEFAULT NULL,
  `item_qty` int(11) NOT NULL,
  `item_min_qty` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `items_supplier_id_foreign` (`supplier_id`),
  KEY `item_category` (`item_category`),
  CONSTRAINT `items_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `items_to_cate` FOREIGN KEY (`item_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `items` */

insert  into `items`(`id`,`item_code`,`item_brand`,`item_sku`,`item_name`,`item_category`,`supplier_id`,`item_qty`,`item_min_qty`,`status`,`created_at`,`updated_at`) values 
(1,'BA111119','m19','SK11119','b19',1,23,16,11,1,'2017-03-16 22:51:34','2017-08-07 12:50:30'),
(2,'BA22222','m22','SK2222','b22',2,23,20,10,1,'2017-03-16 22:58:17','2017-08-09 17:10:07'),
(3,'BA33333','m3','SK3333','b3',1,23,14,15,1,'2017-03-16 23:02:23','2017-08-02 16:23:04'),
(4,'BA44444','m4','SK4444','b4',3,24,0,11,0,'2017-03-16 23:02:49','2017-08-07 13:28:15'),
(5,'BA55555','m5','SK5555','b5',3,24,15,11,1,'2017-03-16 23:04:27','2017-08-07 17:28:47'),
(6,'BA66666','m6','SK6666','b6',2,24,15,11,1,'2017-03-16 23:05:08','2017-08-21 18:41:49'),
(9,'BA77777','m7','SKU7777','b7',3,24,19,15,1,'2017-04-15 15:23:09','2017-07-27 17:36:34'),
(10,'BA88888','m8','SK8888','b8',1,23,12,16,1,'2017-04-15 15:49:23','2017-08-09 17:11:39'),
(11,'asdf','merkasdf','asfd','bla bla',5,23,12,15,1,'2017-07-12 16:48:07','2017-07-13 16:03:30'),
(12,'BA99922','merek barang nya','SKU987','celana bahan kain',2,23,17,10,1,'2017-07-13 10:19:17','2017-08-07 17:25:36'),
(14,'kodkeo','merkemerke','skjusku','nama nama a',4,NULL,225,11,1,'2017-07-13 16:00:27','2017-07-27 17:36:34'),
(15,'asjhdgfa','asdk','asfd as','as asdf',1,NULL,26,11,1,'2017-07-24 18:46:26','2017-08-07 17:25:36');

/*Table structure for table `kembalis` */

DROP TABLE IF EXISTS `kembalis`;

CREATE TABLE `kembalis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_returan_detail` int(10) unsigned DEFAULT NULL,
  `item_id` int(10) unsigned DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_id` int(10) unsigned DEFAULT NULL,
  `qty_kembali` int(11) NOT NULL,
  `datetime_transaction` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `kembalis_item_id_foreign` (`item_id`),
  KEY `kembalis_supplier_id_foreign` (`supplier_id`),
  KEY `kembalis_id_returan_detail_foreign` (`id_returan_detail`),
  CONSTRAINT `kembalis_id_returan_detail_foreign` FOREIGN KEY (`id_returan_detail`) REFERENCES `returan_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `kembalis_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `kembalis_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `kembalis` */

insert  into `kembalis`(`id`,`id_returan_detail`,`item_id`,`item_name`,`supplier_id`,`qty_kembali`,`datetime_transaction`,`status`,`created_at`,`updated_at`) values 
(1,1,6,'b6',24,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(2,2,1,'b1',23,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(3,3,3,'b3',23,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(4,4,5,'b5',24,0,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(5,5,1,'b1',23,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(6,6,2,'b22',23,1,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(7,7,4,'b4',24,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(8,8,6,'b6',24,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(9,9,1,'b1',23,2,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(10,10,12,'celana bahan kain',23,1,'2017-07-24 18:28:44',1,'2017-07-24 18:28:45','2017-07-24 18:28:45'),
(11,11,12,'celana bahan kain',23,1,'2017-07-24 18:28:44',1,'2017-07-24 18:28:45','2017-07-24 18:28:45'),
(12,12,12,'celana',23,1,'2017-07-24 18:33:01',1,'2017-07-24 18:33:02','2017-07-24 18:33:02'),
(13,13,2,'b22',23,1,'2017-08-02 16:11:53',1,'2017-08-02 16:11:53','2017-08-02 16:11:53'),
(14,14,3,'b3',23,2,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(15,15,1,'b1',23,0,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(16,16,2,'b22',23,0,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(17,17,2,'b22',23,1,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(18,18,3,'b3',23,1,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(19,19,1,'b1',23,2,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(20,20,2,'b22',23,0,'2017-08-02 16:22:41',1,'2017-08-02 16:22:42','2017-08-02 16:22:42'),
(21,21,2,'b22',23,1,'2017-08-02 16:23:04',1,'2017-08-02 16:23:04','2017-08-02 16:23:04'),
(22,22,3,'b3',23,2,'2017-08-02 16:23:04',1,'2017-08-02 16:23:04','2017-08-02 16:23:04'),
(23,23,2,'b22',23,1,'2017-08-07 17:28:18',1,'2017-08-07 17:28:18','2017-08-07 17:28:18'),
(24,24,5,'b5',24,1,'2017-08-07 17:28:18',1,'2017-08-07 17:28:19','2017-08-07 17:28:19'),
(25,25,2,'b22',23,0,'2017-08-07 17:28:36',1,'2017-08-07 17:28:36','2017-08-07 17:28:36'),
(26,26,5,'b5',24,3,'2017-08-07 17:28:36',1,'2017-08-07 17:28:37','2017-08-07 17:28:37'),
(27,27,2,'b22',23,1,'2017-08-07 17:28:47',1,'2017-08-07 17:28:47','2017-08-07 17:28:47'),
(28,28,5,'b5',24,1,'2017-08-07 17:28:47',1,'2017-08-07 17:28:47','2017-08-07 17:28:47'),
(29,29,6,'b6',24,1,'2017-08-21 18:40:21',1,'2017-08-21 18:40:21','2017-08-21 18:40:21'),
(30,30,10,'b8',23,0,'2017-08-21 18:40:21',1,'2017-08-21 18:40:21','2017-08-21 18:40:21'),
(31,31,6,'b6',24,0,'2017-08-21 18:40:44',1,'2017-08-21 18:40:44','2017-08-21 18:40:44'),
(32,32,10,'b8',23,0,'2017-08-21 18:40:44',1,'2017-08-21 18:40:44','2017-08-21 18:40:44'),
(33,33,6,'b6',24,1,'2017-08-21 18:41:49',1,'2017-08-21 18:41:49','2017-08-21 18:41:49'),
(34,34,10,'b8',23,0,'2017-08-21 18:41:49',1,'2017-08-21 18:41:49','2017-08-21 18:41:49');

/*Table structure for table `logs` */

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `log_to_users` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `logs` */

insert  into `logs`(`id`,`userid`,`name`,`created_at`,`updated_at`) values 
(1,1,'user id : 1 telah menambahkan barang baru dengan id : 1','2017-03-16 22:51:34','2017-03-16 22:51:34'),
(2,1,'user id : 1 telah menambahkan barang baru dengan id : 2','2017-03-16 22:58:17','2017-03-16 22:58:17'),
(3,1,'user id : 1 telah memperbarui data barang pada id : 2','2017-03-16 22:58:36','2017-03-16 22:58:36'),
(4,1,'user id : 1 telah menambahkan barang baru dengan id : 3','2017-03-16 23:02:23','2017-03-16 23:02:23'),
(5,1,'user id : 1 telah menambahkan barang baru dengan id : 4','2017-03-16 23:02:49','2017-03-16 23:02:49'),
(6,1,'user id : 1 telah menambahkan barang baru dengan id : 5','2017-03-16 23:04:27','2017-03-16 23:04:27'),
(7,1,'user id : 1 telah menambahkan barang baru dengan id : 6','2017-03-16 23:05:09','2017-03-16 23:05:09'),
(8,1,'user id : 1 telah membeli barang pada id : 4 sebanyak 3','2017-03-16 23:06:31','2017-03-16 23:06:31'),
(9,1,'user id : 1 telah membeli barang pada id : 6 sebanyak 1','2017-03-16 23:06:31','2017-03-16 23:06:31'),
(10,1,'user id : 1 telah membeli barang pada id : 5 sebanyak 3','2017-03-16 23:06:57','2017-03-16 23:06:57'),
(11,1,'user id : 1 telah membeli barang pada id : 6 sebanyak 2','2017-03-16 23:06:57','2017-03-16 23:06:57'),
(12,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 2','2017-03-16 23:07:27','2017-03-16 23:07:27'),
(13,1,'user id : 1 telah menjual barang dengan id : 5 sebanyak 5','2017-03-16 23:07:27','2017-03-16 23:07:27'),
(14,1,'user id : 1 telah menjual barang dengan id : 6 sebanyak 2','2017-03-16 23:07:54','2017-03-16 23:07:54'),
(15,1,'user id : 1 telah menjual barang dengan id : 1 sebanyak 2','2017-03-16 23:08:18','2017-03-16 23:08:18'),
(16,1,'user id : 1 telah menjual barang dengan id : 3 sebanyak 2','2017-03-16 23:08:18','2017-03-16 23:08:18'),
(17,1,'user id : 1 telah menjual barang dengan id : 5 sebanyak 2','2017-03-16 23:08:18','2017-03-16 23:08:18'),
(18,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 2','2017-03-16 23:08:47','2017-03-16 23:08:47'),
(19,1,'user id : 1 telah menjual barang dengan id : 3 sebanyak 4','2017-03-16 23:08:47','2017-03-16 23:08:47'),
(20,1,'user id : 1 telah menjual barang dengan id : 1 sebanyak 3','2017-03-16 23:09:29','2017-03-16 23:09:29'),
(21,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 1','2017-03-16 23:09:29','2017-03-16 23:09:29'),
(22,1,'user id : 1 telah menjual barang dengan id : 4 sebanyak 1','2017-03-16 23:09:30','2017-03-16 23:09:30'),
(23,1,'user id : 1 telah menjual barang dengan id : 6 sebanyak 1','2017-03-16 23:09:30','2017-03-16 23:09:30'),
(24,1,'user id : 1 telah menambahkan returan baru dengan id : 1','2017-03-16 23:14:40','2017-03-16 23:14:40'),
(25,1,'user id : 1 telah menjual barang dengan id : 1 sebanyak 2','2017-03-16 23:16:31','2017-03-16 23:16:31'),
(26,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 3','2017-03-16 23:16:31','2017-03-16 23:16:31'),
(27,1,'user id : 1 telah membeli barang pada id : 1 sebanyak 7','2017-04-12 18:51:55','2017-04-12 18:51:55'),
(28,1,'user id : 1 telah membeli barang pada id : 2 sebanyak 8','2017-04-12 18:51:55','2017-04-12 18:51:55'),
(32,1,'user id : 1 telah menambahkan barang baru dengan id : 9','2017-04-15 15:23:09','2017-04-15 15:23:09'),
(33,1,'user id : 1 telah menambahkan barang baru dengan id : 10','2017-04-15 15:49:23','2017-04-15 15:49:23'),
(34,1,'user id : 1 telah memperbarui data barang pada id : 10','2017-04-15 15:51:06','2017-04-15 15:51:06'),
(35,1,'user id : 1 telah memperbarui data barang pada id : 3','2017-04-15 15:51:24','2017-04-15 15:51:24'),
(36,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 10','2017-04-15 15:59:32','2017-04-15 15:59:32'),
(37,1,'user id : 1 telah menjual barang dengan id : 4 sebanyak 10','2017-04-15 15:59:32','2017-04-15 15:59:32'),
(38,1,'user id : 1 telah menjual barang dengan id : 10 sebanyak 6','2017-04-15 15:59:32','2017-04-15 15:59:32'),
(39,1,'user id : 1 telah memperbarui data kategori pada id : 1','2017-04-17 11:28:29','2017-04-17 11:28:29'),
(40,1,'user id : 1 telah memperbarui data kategori pada id : 1','2017-04-17 11:28:36','2017-04-17 11:28:36'),
(41,1,'user id : 1 telah membeli barang pada id : 1 sebanyak 3','2017-04-23 23:10:36','2017-04-23 23:10:36'),
(42,1,'user id : 1 telah membeli barang pada id : 3 sebanyak 3','2017-04-23 23:10:36','2017-04-23 23:10:36'),
(43,1,'user id : 1 telah membeli barang pada id : 2 sebanyak 4','2017-04-23 23:10:45','2017-04-23 23:10:45'),
(44,1,'user id : 1 telah membeli barang pada id : 4 sebanyak 2','2017-04-23 23:11:04','2017-04-23 23:11:04'),
(45,1,'user id : 1 telah membeli barang pada id : 2 sebanyak 4','2017-04-23 23:11:25','2017-04-23 23:11:25'),
(46,1,'user id : 1 telah membeli barang pada id : 10 sebanyak 5','2017-04-23 23:11:25','2017-04-23 23:11:25'),
(47,1,'user id : 1 telah menjual barang dengan id : 1 sebanyak 4','2017-04-23 23:30:49','2017-04-23 23:30:49'),
(48,1,'user id : 1 telah menjual barang dengan id : 3 sebanyak 2','2017-04-23 23:31:13','2017-04-23 23:31:13'),
(49,1,'user id : 1 telah menjual barang dengan id : 5 sebanyak 3','2017-04-23 23:31:13','2017-04-23 23:31:13'),
(50,1,'user id : 1 telah menjual barang dengan id : 3 sebanyak 3','2017-04-23 23:31:38','2017-04-23 23:31:38'),
(51,1,'user id : 1 telah membeli barang pada id : 2 sebanyak 2','2017-04-24 17:38:24','2017-04-24 17:38:24'),
(52,1,'user id : 1 telah membeli barang pada id : 2 sebanyak 1','2017-04-24 17:41:52','2017-04-24 17:41:52'),
(53,1,'user id : 1 telah membeli barang pada id : 9 sebanyak 3','2017-04-24 17:42:10','2017-04-24 17:42:10'),
(54,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 2','2017-04-24 18:06:42','2017-04-24 18:06:42'),
(55,1,'user id : 1 telah menjual barang dengan id : 3 sebanyak 1','2017-04-24 18:06:42','2017-04-24 18:06:42'),
(56,1,'user id : 1 telah menjual barang dengan id : 4 sebanyak 2','2017-04-24 18:07:12','2017-04-24 18:07:12'),
(57,1,'user id : 1 telah menjual barang dengan id : 6 sebanyak 1','2017-04-24 18:07:12','2017-04-24 18:07:12'),
(58,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 2','2017-04-24 18:07:30','2017-04-24 18:07:30'),
(59,1,'user id : 1 telah mengupdate data penjualan pada id : 13','2017-04-24 18:10:06','2017-04-24 18:10:06'),
(60,1,'user id : 1 telah menambahkan returan baru dengan id : 2','2017-04-27 10:54:26','2017-04-27 10:54:26'),
(61,1,'user id : 1 telah mengarsip data pembelian','2017-04-27 21:33:16','2017-04-27 21:33:16'),
(62,1,'user id : 1 telah mengarsip data pembelian','2017-04-27 21:36:26','2017-04-27 21:36:26'),
(63,1,'user id : 1 telah menambahkan returan baru dengan id : 3','2017-04-28 00:42:51','2017-04-28 00:42:51'),
(64,1,'user id : 1 telah mengarsip data penjualan','2017-04-28 00:55:37','2017-04-28 00:55:37'),
(65,1,'user id : 1 telah mengarsip data penjualan','2017-04-28 00:57:32','2017-04-28 00:57:32'),
(66,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 3','2017-04-28 01:06:24','2017-04-28 01:06:24'),
(67,1,'user id : 1 telah menjual barang dengan id : 4 sebanyak 2','2017-04-28 01:06:24','2017-04-28 01:06:24'),
(68,1,'user id : 1 telah menjual barang dengan id : 6 sebanyak 3','2017-04-28 01:06:24','2017-04-28 01:06:24'),
(69,1,'user id : 1 telah menambahkan returan baru dengan id : 4','2017-04-28 01:06:41','2017-04-28 01:06:41'),
(70,1,'user id : 1 telah mengarsip data penjualan','2017-04-28 01:07:28','2017-04-28 01:07:28'),
(71,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 2','2017-04-28 01:08:25','2017-04-28 01:08:25'),
(72,1,'user id : 1 telah menjual barang dengan id : 4 sebanyak 2','2017-04-28 01:08:25','2017-04-28 01:08:25'),
(73,1,'user id : 1 telah menjual barang dengan id : 5 sebanyak 3','2017-04-28 01:08:44','2017-04-28 01:08:44'),
(74,1,'user id : 1 telah menjual barang dengan id : 9 sebanyak 1','2017-04-28 01:08:45','2017-04-28 01:08:45'),
(75,1,'user id : 1 telah menambahkan returan baru dengan id : 5','2017-04-28 01:09:08','2017-04-28 01:09:08'),
(76,1,'user id : 1 telah mengarsip data penjualan','2017-04-28 01:10:03','2017-04-28 01:10:03'),
(77,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 2','2017-04-28 01:10:48','2017-04-28 01:10:48'),
(78,1,'user id : 1 telah menjual barang dengan id : 6 sebanyak 2','2017-04-28 01:10:48','2017-04-28 01:10:48'),
(79,1,'user id : 1 telah menjual barang dengan id : 1 sebanyak 1','2017-04-28 01:11:13','2017-04-28 01:11:13'),
(80,1,'user id : 1 telah menjual barang dengan id : 5 sebanyak 1','2017-04-28 01:11:13','2017-04-28 01:11:13'),
(81,1,'user id : 1 telah menjual barang dengan id : 9 sebanyak 1','2017-04-28 01:11:13','2017-04-28 01:11:13'),
(82,1,'user id : 1 telah menambahkan returan baru dengan id : 6','2017-04-28 01:11:33','2017-04-28 01:11:33'),
(83,1,'user id : 1 telah mengarsip data penjualan','2017-04-28 01:11:51','2017-04-28 01:11:51'),
(84,1,'user id : 1 telah menjual barang dengan id : 10 sebanyak 2','2017-04-30 14:00:30','2017-04-30 14:00:30'),
(85,1,'user id : 1 telah mengupdate data penjualan pada id : 18','2017-04-30 14:00:42','2017-04-30 14:00:42'),
(86,1,'user id : 1 telah menambahkan returan baru dengan id : 3','2017-04-30 14:01:03','2017-04-30 14:01:03'),
(87,1,'user id : 1 telah mengarsip data penjualan','2017-04-30 14:26:46','2017-04-30 14:26:46'),
(88,1,'user id : 1 telah membeli barang pada id : 2 sebanyak 2','2017-05-03 10:17:27','2017-05-03 10:17:27'),
(89,1,'user id : 1 telah mengarsip data pembelian','2017-05-03 10:17:34','2017-05-03 10:17:34'),
(90,1,'user id : 1 telah membeli barang pada id : 3 sebanyak 2','2017-05-03 10:22:07','2017-05-03 10:22:07'),
(91,1,'user id : 1 telah mengarsip data pembelian','2017-05-03 10:34:11','2017-05-03 10:34:11'),
(92,1,'user id : 1 telah menjual barang dengan id : 5 sebanyak 1','2017-05-03 10:36:42','2017-05-03 10:36:42'),
(93,1,'user id : 1 telah mengarsip data penjualan','2017-05-03 10:36:57','2017-05-03 10:36:57'),
(94,1,'user id : 1 telah menambahkan barang baru dengan id : 11','2017-07-12 16:48:07','2017-07-12 16:48:07'),
(95,1,'user id : 1 telah menambahkan barang baru dengan id : 12','2017-07-13 10:19:17','2017-07-13 10:19:17'),
(96,1,'user id : 1 telah menjual barang dengan id : 12 sebanyak 2','2017-07-13 10:20:02','2017-07-13 10:20:02'),
(97,1,'user id : 1 telah menjual barang dengan id : 12 sebanyak 5','2017-07-13 11:21:24','2017-07-13 11:21:24'),
(98,1,'user id : 1 telah menambahkan barang baru dengan id : 14','2017-07-13 16:00:27','2017-07-13 16:00:27'),
(99,1,'user id : 1 telah memperbarui data barang pada id : 11','2017-07-13 16:03:30','2017-07-13 16:03:30'),
(100,1,'user id : 1 telah mengupdate data pembelian pada id : 4','2017-07-14 08:22:23','2017-07-14 08:22:23'),
(101,1,'user id : 1 telah mengupdate data pembelian pada id : 4','2017-07-14 08:22:39','2017-07-14 08:22:39'),
(102,1,'user id : 1 telah mengupdate data pembelian pada id : 4','2017-07-14 11:14:11','2017-07-14 11:14:11'),
(103,1,'user id : 1 telah mengupdate data penjualan pada id : 19','2017-07-14 11:21:35','2017-07-14 11:21:35'),
(104,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 1','2017-07-14 11:56:26','2017-07-14 11:56:26'),
(105,1,'user id : 1 telah mengupdate data penjualan pada id : 20','2017-07-14 11:56:39','2017-07-14 11:56:39'),
(106,1,'user id : 1 telah mengupdate data penjualan pada id : 20','2017-07-14 11:56:59','2017-07-14 11:56:59'),
(107,1,'user id : 1 telah membeli barang pada id : 4 sebanyak 1','2017-07-15 15:07:11','2017-07-15 15:07:11'),
(108,1,'user id : 1 telah membeli barang pada id : 5 sebanyak 1','2017-07-15 15:07:11','2017-07-15 15:07:11'),
(109,1,'user id : 1 telah mengupdate data pembelian pada id : 9','2017-07-15 15:12:30','2017-07-15 15:12:30'),
(110,1,'user id : 1 telah membeli barang pada id : 5 sebanyak 1','2017-07-15 15:12:46','2017-07-15 15:12:46'),
(111,1,'user id : 1 telah menambahkan returan baru dengan id : 3','2017-07-24 18:28:45','2017-07-24 18:28:45'),
(112,1,'user id : 1 telah menambahkan returan baru dengan id : 4','2017-07-24 18:33:02','2017-07-24 18:33:02'),
(113,1,'user id : 1 telah menambahkan barang baru dengan id : 15','2017-07-24 18:46:26','2017-07-24 18:46:26'),
(114,1,'user id : 1 telah membeli barang pada id : 2 sebanyak 2','2017-07-24 18:57:14','2017-07-24 18:57:14'),
(115,1,'user id : 1 telah membeli barang pada id : 10 sebanyak 2','2017-07-24 18:57:14','2017-07-24 18:57:14'),
(116,1,'user id : 1 telah membeli barang pada id : 12 sebanyak 2','2017-07-24 18:57:14','2017-07-24 18:57:14'),
(117,1,'user id : 1 telah membeli barang pada id : 15 sebanyak 3','2017-07-24 18:57:14','2017-07-24 18:57:14'),
(118,1,'user id : 1 telah mengupdate data pembelian pada id : 4','2017-07-27 17:36:34','2017-07-27 17:36:34'),
(119,1,'user id : 1 telah menambahkan returan baru dengan id : 4','2017-08-02 16:11:54','2017-08-02 16:11:54'),
(120,1,'user id : 1 telah menambahkan returan baru dengan id : 4','2017-08-02 16:22:42','2017-08-02 16:22:42'),
(121,1,'user id : 1 telah menambahkan returan baru dengan id : 4','2017-08-02 16:23:05','2017-08-02 16:23:05'),
(122,1,'user id : 1 telah memperbarui data supplier pada id : 23','2017-08-07 12:47:38','2017-08-07 12:47:38'),
(123,1,'user id : 1 telah memperbarui data barang pada id : 1','2017-08-07 12:50:30','2017-08-07 12:50:30'),
(124,1,'user id : 1 telah menjual barang dengan id : 4 sebanyak 8','2017-08-07 13:28:07','2017-08-07 13:28:07'),
(125,1,'user id : 1 telah mengganti status barang pada id : 4 menjadi 0','2017-08-07 13:28:15','2017-08-07 13:28:15'),
(126,1,'user id : 1 telah menambahkan supplier baru dengan id  : 25','2017-08-07 13:33:47','2017-08-07 13:33:47'),
(127,1,'user id : 1 telah mengganti status supplier pada id : 25 menjadi 0','2017-08-07 13:33:55','2017-08-07 13:33:55'),
(128,1,'user id : 1 telah mengupdate data pembelian pada id : 11','2017-08-07 17:25:36','2017-08-07 17:25:36'),
(129,1,'user id : 1 telah menambahkan returan baru dengan id : 5','2017-08-07 17:28:19','2017-08-07 17:28:19'),
(130,1,'user id : 1 telah menambahkan returan baru dengan id : 6','2017-08-07 17:28:37','2017-08-07 17:28:37'),
(131,1,'user id : 1 telah menambahkan returan baru dengan id : 7','2017-08-07 17:28:47','2017-08-07 17:28:47'),
(132,1,'user id : 1 telah menambahkan supplier baru dengan id  : 26','2017-08-09 16:45:11','2017-08-09 16:45:11'),
(133,1,'user id : 1 telah memperbarui data supplier pada id : 23','2017-08-09 16:45:38','2017-08-09 16:45:38'),
(134,1,'user id : 1 telah memperbarui data supplier pada id : 23','2017-08-09 16:47:03','2017-08-09 16:47:03'),
(135,1,'user id : 1 telah menjual barang dengan id : 2 sebanyak 1','2017-08-09 17:10:07','2017-08-09 17:10:07'),
(136,1,'user id : 1 telah menjual barang dengan id : 6 sebanyak 2','2017-08-09 17:11:38','2017-08-09 17:11:38'),
(137,1,'user id : 1 telah menjual barang dengan id : 10 sebanyak 2','2017-08-09 17:11:39','2017-08-09 17:11:39'),
(138,1,'user id : 1 telah mengganti status customer pada id : 2 menjadi 0','2017-08-09 17:13:38','2017-08-09 17:13:38'),
(139,1,'user id : 1 telah mengganti status customer pada id : 2 menjadi 1','2017-08-09 17:13:38','2017-08-09 17:13:38'),
(140,1,'user id : 1 telah mengganti status customer pada id : 2 menjadi 0','2017-08-09 17:13:44','2017-08-09 17:13:44'),
(141,1,'user id : 1 telah mengganti status customer pada id : 4 menjadi 0','2017-08-09 17:13:48','2017-08-09 17:13:48'),
(142,1,'user id : 1 telah menambahkan returan baru dengan id : 8','2017-08-21 18:40:21','2017-08-21 18:40:21'),
(143,1,'user id : 1 telah menambahkan returan baru dengan id : 9','2017-08-21 18:40:44','2017-08-21 18:40:44'),
(144,1,'user id : 1 telah menambahkan returan baru dengan id : 10','2017-08-21 18:41:49','2017-08-21 18:41:49');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`migration`,`batch`) values 
('2014_10_12_000000_create_users_table',1),
('2014_10_12_100000_create_password_resets_table',1),
('2017_01_25_140509_create_suppliers_table',1),
('2017_01_25_140638_create_customers_table',1),
('2017_01_25_140708_create_items_table',1),
('2017_01_26_035308_create_logs_table',1),
('2017_01_27_112529_create_pembelians_tables',1),
('2017_01_27_112611_create_penjualans_tables',1),
('2017_02_07_193732_create_returans_table',1),
('2017_02_07_193751_create_waste_list_table',1),
('2017_02_07_194610_create_returan_detail_table',1),
('2017_02_07_204559_create_penjualan_detail_table',1),
('2017_02_07_204729_create_pembelian_detail_table',1),
('2017_02_21_002851_create_returan_detail_status_table',1),
('2017_02_21_002925_create_kembalis_table',1);

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `read` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `notifications` */

insert  into `notifications`(`id`,`item_id`,`description`,`read`,`created_at`,`updated_at`) values 
(2,9,'barang dengan id : 9 di bawah stock minimum','true','2017-04-15 15:28:17','2017-04-15 15:28:17'),
(3,10,'barang dengan id : 10 di bawah stock minimum','true','2017-04-21 16:35:46','2017-04-21 16:35:46'),
(4,3,'barang dengan id : 3 di bawah stock minimum','true','2017-04-21 16:38:58','2017-04-21 16:38:58'),
(5,2,'barang dengan id : 2 di bawah stock minimum','true','2017-04-21 16:36:07','2017-04-21 16:36:07'),
(6,4,'barang dengan id : 4 di bawah stock minimum','true','2017-04-22 16:25:20','2017-04-22 16:25:20'),
(7,3,'barang dengan id : 3 di bawah stock minimum','false','2017-04-23 23:31:13','2017-04-23 23:31:13'),
(8,5,'barang dengan id : 5 di bawah stock minimum','true','2017-04-27 16:32:01','2017-04-27 16:32:01'),
(9,4,'barang dengan id : 4 di bawah stock minimum','false','2017-04-24 18:07:12','2017-04-24 18:07:12'),
(10,5,'barang dengan id : 5 di bawah stock minimum','true','2017-07-13 15:53:09','2017-07-13 15:53:09'),
(11,9,'barang dengan id : 9 di bawah stock minimum','true','2017-07-13 15:53:16','2017-07-13 15:53:16'),
(12,2,'barang dengan id : 2 di bawah stock minimum','false','2017-04-28 01:10:48','2017-04-28 01:10:48'),
(13,10,'barang dengan id : 10 di bawah stock minimum','true','2017-07-13 15:53:13','2017-07-13 15:53:13'),
(14,11,'barang dengan id : 11 di bawah stock minimum','false','2017-07-13 16:03:30','2017-07-13 16:03:30'),
(15,10,'barang dengan id : 10 di bawah stock minimum','false','2017-08-09 17:11:39','2017-08-09 17:11:39');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `pembelian_detail` */

DROP TABLE IF EXISTS `pembelian_detail`;

CREATE TABLE `pembelian_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pembelian` int(10) unsigned DEFAULT NULL,
  `item_id` int(10) unsigned DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_id` int(10) unsigned DEFAULT NULL,
  `purchase_qty` int(11) NOT NULL,
  `datetime_transaction` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pembelian_detail_id_pembelian_foreign` (`id_pembelian`),
  KEY `pembelian_detail_item_id_foreign` (`item_id`),
  KEY `pembelian_detail_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `pembelian_detail_id_pembelian_foreign` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_detail_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_detail_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `pembelian_detail` */

insert  into `pembelian_detail`(`id`,`id_pembelian`,`item_id`,`item_name`,`supplier_id`,`purchase_qty`,`datetime_transaction`,`status`,`created_at`,`updated_at`) values 
(1,1,4,'b4',24,3,'2017-03-16 23:05:28',1,'2017-03-16 23:06:31','2017-03-16 23:06:31'),
(2,1,6,'b6',24,1,'2017-03-16 23:05:28',1,'2017-03-16 23:06:31','2017-03-16 23:06:31'),
(3,2,5,'b5',24,3,'2017-03-16 23:06:31',1,'2017-03-16 23:06:57','2017-03-16 23:06:57'),
(4,2,6,'b6',24,2,'2017-03-16 23:06:31',1,'2017-03-16 23:06:57','2017-03-16 23:06:57'),
(5,3,1,'b1',23,7,'2017-04-12 18:51:54',1,'2017-04-12 18:51:55','2017-04-12 18:51:55'),
(6,3,2,'b22',23,8,'2017-04-12 18:51:54',1,'2017-04-12 18:51:55','2017-04-12 18:51:55'),
(9,5,2,'b22',23,4,'2017-04-23 23:10:45',1,'2017-04-23 23:10:45','2017-04-23 23:10:45'),
(10,6,4,'b4',24,2,'2017-04-23 23:11:03',1,'2017-04-23 23:11:03','2017-04-23 23:11:03'),
(11,7,2,'b22',23,4,'2017-04-23 23:11:25',1,'2017-04-23 23:11:25','2017-04-23 23:11:25'),
(12,7,10,'b8',23,5,'2017-04-23 23:11:25',1,'2017-04-23 23:11:25','2017-04-23 23:11:25'),
(22,9,5,'b5',23,2,'2017-07-15 15:12:29',1,'2017-07-15 15:12:29','2017-07-15 15:12:29'),
(23,9,9,'b7',23,4,'2017-07-15 15:12:29',1,'2017-07-15 15:12:30','2017-07-15 15:12:30'),
(24,10,5,'b5',23,1,'2017-07-15 15:12:46',1,'2017-07-15 15:12:46','2017-07-15 15:12:46'),
(29,4,2,'b22',NULL,1,'2017-07-27 17:36:34',1,'2017-07-27 17:36:34','2017-07-27 17:36:34'),
(30,4,9,'b7',NULL,1,'2017-07-27 17:36:34',1,'2017-07-27 17:36:34','2017-07-27 17:36:34'),
(31,4,14,'nama nama a',NULL,3,'2017-07-27 17:36:34',1,'2017-07-27 17:36:34','2017-07-27 17:36:34'),
(32,4,15,'as asdf',NULL,1,'2017-07-27 17:36:34',1,'2017-07-27 17:36:34','2017-07-27 17:36:34'),
(33,11,2,'b22',24,2,'2017-08-07 17:25:35',1,'2017-08-07 17:25:36','2017-08-07 17:25:36'),
(34,11,10,'b8',24,2,'2017-08-07 17:25:35',1,'2017-08-07 17:25:36','2017-08-07 17:25:36'),
(35,11,12,'celana bahan kain',24,2,'2017-08-07 17:25:35',1,'2017-08-07 17:25:36','2017-08-07 17:25:36'),
(36,11,15,'as asdf',24,3,'2017-08-07 17:25:35',1,'2017-08-07 17:25:36','2017-08-07 17:25:36');

/*Table structure for table `pembelians` */

DROP TABLE IF EXISTS `pembelians`;

CREATE TABLE `pembelians` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_id` int(10) unsigned DEFAULT NULL,
  `datetime_transaction` datetime NOT NULL,
  `datetime_estimate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pembelians_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `pembelians_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `pembelians` */

insert  into `pembelians`(`id`,`no_nota`,`supplier_id`,`datetime_transaction`,`datetime_estimate`,`status`,`created_at`,`updated_at`) values 
(1,'PB11111',24,'2017-03-16 23:05:28','2017-03-17 23:05:28',1,'2017-03-16 23:06:31','2017-03-16 23:06:31'),
(2,'PB22221',24,'2017-03-16 23:06:31','2017-03-17 23:06:31',1,'2017-03-16 23:06:57','2017-03-16 23:06:57'),
(3,'PB91469',23,'2017-04-12 18:51:54','2017-04-13 18:51:41',1,'2017-04-12 18:51:54','2017-04-12 18:51:54'),
(4,'PB55737',23,'2017-04-23 23:10:35','2017-04-26 23:10:00',1,'2017-04-23 23:10:35','2017-07-27 17:36:34'),
(5,'PB21901',23,'2017-04-23 23:10:45','2017-04-24 23:10:37',1,'2017-04-23 23:10:45','2017-04-23 23:10:45'),
(6,'PB27638',24,'2017-04-23 23:11:03','2017-04-25 23:10:00',1,'2017-04-23 23:11:03','2017-04-23 23:11:03'),
(7,'PB98101',23,'2017-04-23 23:11:25','2017-04-26 23:11:00',1,'2017-04-23 23:11:25','2017-04-23 23:11:25'),
(8,'PB94722',23,'2017-07-15 15:06:44','2017-07-16 15:06:16',1,'2017-07-15 15:06:44','2017-07-15 15:06:44'),
(9,'PB13482',23,'2017-07-15 15:07:10','2017-07-16 15:06:16',1,'2017-07-15 15:07:10','2017-07-15 15:12:29'),
(10,'PB28376',23,'2017-07-15 15:12:46','2017-07-16 15:12:30',1,'2017-07-15 15:12:46','2017-07-15 15:12:46'),
(11,'PB61190',24,'2017-07-24 18:57:13','2017-07-25 18:56:29',1,'2017-07-24 18:57:13','2017-08-07 17:25:35');

/*Table structure for table `penjualan_detail` */

DROP TABLE IF EXISTS `penjualan_detail`;

CREATE TABLE `penjualan_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(10) unsigned DEFAULT NULL,
  `item_id` int(10) unsigned DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_id` int(10) unsigned DEFAULT NULL,
  `selling_qty` int(11) NOT NULL,
  `selling_qty_temp` int(11) NOT NULL,
  `datetime_transaction` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `penjualan_detail_id_penjualan_foreign` (`id_penjualan`),
  KEY `penjualan_detail_item_id_foreign` (`item_id`),
  KEY `penjualan_detail_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `penjualan_detail_id_penjualan_foreign` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_detail_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_detail_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `penjualan_detail` */

insert  into `penjualan_detail`(`id`,`id_penjualan`,`item_id`,`item_name`,`supplier_id`,`selling_qty`,`selling_qty_temp`,`datetime_transaction`,`status`,`created_at`,`updated_at`) values 
(1,1,2,'b22',23,0,0,'2017-03-16 23:07:01',1,'2017-03-16 23:07:27','2017-08-07 17:28:47'),
(2,1,5,'b5',24,0,0,'2017-03-16 23:07:01',1,'2017-03-16 23:07:27','2017-08-07 17:28:47'),
(3,2,6,'b6',24,2,2,'2017-03-16 23:07:27',1,'2017-03-16 23:07:54','2017-03-16 23:07:54'),
(4,3,1,'b1',23,2,2,'2017-03-16 23:07:54',1,'2017-03-16 23:08:18','2017-03-16 23:08:18'),
(5,3,3,'b3',23,2,2,'2017-03-16 23:07:54',1,'2017-03-16 23:08:18','2017-03-16 23:08:18'),
(6,3,5,'b5',24,2,2,'2017-03-16 23:07:54',1,'2017-03-16 23:08:18','2017-03-16 23:08:18'),
(7,4,2,'b22',23,0,0,'2017-03-16 23:08:18',1,'2017-03-16 23:08:47','2017-08-02 16:23:04'),
(8,4,3,'b3',23,0,0,'2017-03-16 23:08:18',1,'2017-03-16 23:08:47','2017-08-02 16:23:05'),
(9,5,1,'b1',23,3,3,'2017-03-16 23:08:47',1,'2017-03-16 23:09:29','2017-03-16 23:09:29'),
(10,5,2,'b22',23,1,1,'2017-03-16 23:08:47',1,'2017-03-16 23:09:29','2017-03-16 23:09:29'),
(11,5,4,'b4',24,1,1,'2017-03-16 23:08:47',1,'2017-03-16 23:09:29','2017-03-16 23:09:29'),
(12,5,6,'b6',24,1,1,'2017-03-16 23:08:47',1,'2017-03-16 23:09:30','2017-03-16 23:09:30'),
(13,6,1,'b1',23,0,0,'2017-03-16 23:16:09',1,'2017-03-16 23:16:30','2017-08-02 16:22:42'),
(14,6,2,'b22',23,0,0,'2017-03-16 23:16:09',1,'2017-03-16 23:16:31','2017-08-02 16:22:42'),
(15,7,2,'b22',23,10,10,'2017-04-15 15:59:32',1,'2017-04-15 15:59:32','2017-04-15 15:59:32'),
(16,7,4,'b4',24,10,10,'2017-04-15 15:59:32',1,'2017-04-15 15:59:32','2017-04-15 15:59:32'),
(17,7,10,'b8',23,6,6,'2017-04-15 15:59:32',1,'2017-04-15 15:59:32','2017-04-15 15:59:32'),
(18,8,1,'b1',23,4,4,'2017-04-23 23:30:49',1,'2017-04-23 23:30:49','2017-04-23 23:30:49'),
(19,9,3,'b3',23,2,2,'2017-04-23 23:31:12',1,'2017-04-23 23:31:12','2017-04-23 23:31:12'),
(20,9,5,'b5',24,3,3,'2017-04-23 23:31:12',1,'2017-04-23 23:31:13','2017-04-23 23:31:13'),
(21,10,3,'b3',23,3,3,'2017-04-23 23:31:38',1,'2017-04-23 23:31:38','2017-04-23 23:31:38'),
(35,17,2,'b22',23,2,2,'2017-04-28 01:10:48',1,'2017-04-28 01:10:48','2017-04-28 01:10:48'),
(36,17,6,'b6',24,2,2,'2017-04-28 01:10:48',1,'2017-04-28 01:10:48','2017-04-28 01:10:48'),
(37,18,12,'celana',23,2,2,'2017-07-13 10:20:02',1,'2017-07-13 10:20:02','2017-07-13 10:20:02'),
(39,19,12,'celana bahan kain',23,5,5,'2017-07-14 11:21:35',1,'2017-07-14 11:21:35','2017-07-14 11:21:35'),
(42,20,12,'celana bahan kain',23,1,1,'2017-07-14 11:56:59',1,'2017-07-14 11:56:59','2017-07-14 11:56:59'),
(43,21,4,'b4',24,8,8,'2017-08-07 13:28:07',1,'2017-08-07 13:28:07','2017-08-07 13:28:07'),
(44,22,2,'b22',23,1,1,'2017-08-09 17:10:07',1,'2017-08-09 17:10:07','2017-08-09 17:10:07'),
(45,23,6,'b6',24,2,0,'2017-08-09 17:11:37',1,'2017-08-09 17:11:38','2017-08-21 18:41:49'),
(46,23,10,'b8',23,2,1,'2017-08-09 17:11:37',1,'2017-08-09 17:11:38','2017-08-21 18:40:21');

/*Table structure for table `penjualans` */

DROP TABLE IF EXISTS `penjualans`;

CREATE TABLE `penjualans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `datetime_transaction` datetime NOT NULL,
  `datetime_estimate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `remark_returan` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `penjualans_customer_id_foreign` (`customer_id`),
  CONSTRAINT `penjualans_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `penjualans` */

insert  into `penjualans`(`id`,`no_nota`,`customer_id`,`datetime_transaction`,`datetime_estimate`,`status`,`remark_returan`,`created_at`,`updated_at`) values 
(1,'PJ11111',2,'2017-03-16 23:07:01','2017-03-17 23:07:01',1,'yes','2017-03-16 23:07:27','2017-08-07 17:28:47'),
(2,'PJ22222',3,'2017-03-16 23:07:27','2017-03-17 23:07:27',1,'yes','2017-03-16 23:07:53','2017-03-16 23:14:40'),
(3,'PJ33332',1,'2017-03-16 23:07:54','2017-03-17 23:07:54',1,'yes','2017-03-16 23:08:18','2017-03-16 23:14:40'),
(4,'PJ44442',2,'2017-03-16 23:08:18','2017-03-17 23:08:18',1,'yes','2017-03-16 23:08:47','2017-08-02 16:23:05'),
(5,'PJ55552',2,'2017-03-16 23:08:47','2017-03-17 23:08:47',1,'yes','2017-03-16 23:09:29','2017-04-27 10:54:25'),
(6,'PJ66662',1,'2017-03-16 23:16:09','2017-03-17 23:16:09',1,'yes','2017-03-16 23:16:30','2017-08-02 16:22:42'),
(7,'PJ767676',1,'2017-04-15 15:59:32','2017-04-15 15:58:44',1,'no','2017-04-15 15:59:32','2017-04-15 15:59:32'),
(8,'PJ45455',1,'2017-04-23 23:30:49','2017-04-23 23:29:42',1,'yes','2017-04-23 23:30:49','2017-04-27 10:54:26'),
(9,'PJ5454',3,'2017-04-23 23:31:12','2017-04-24 23:30:00',1,'no','2017-04-23 23:31:12','2017-04-23 23:31:12'),
(10,'PJ5455',1,'2017-04-23 23:31:38','2017-04-25 23:31:00',1,'no','2017-04-23 23:31:38','2017-04-23 23:31:38'),
(17,'PJ1',2,'2017-04-28 01:10:48','2017-01-13 01:10:00',1,'no','2017-04-28 01:10:48','2017-04-28 01:10:48'),
(18,'PJ1232',1,'2017-07-13 10:20:02','2017-07-13 10:19:45',1,'yes','2017-07-13 10:20:02','2017-07-24 18:33:01'),
(19,'dfafafaf',4,'2017-07-13 11:21:24','2017-07-13 11:20:43',1,'yes','2017-07-13 11:21:24','2017-07-24 18:28:45'),
(20,'asfasdfaf',3,'2017-07-14 11:56:26','2017-07-14 11:56:10',1,'yes','2017-07-14 11:56:26','2017-07-24 18:28:45'),
(21,'PJ9999',2,'2017-08-07 13:28:07','2017-08-07 13:27:27',1,'no','2017-08-07 13:28:07','2017-08-07 13:28:07'),
(22,'afafaf',1,'2017-08-09 17:10:07','2017-08-09 17:09:53',1,'no','2017-08-09 17:10:07','2017-08-09 17:10:07'),
(23,'zvzvz',1,'2017-08-09 17:11:37','2017-08-09 17:10:53',1,'no','2017-08-09 17:11:37','2017-08-09 17:11:37');

/*Table structure for table `returan_detail` */

DROP TABLE IF EXISTS `returan_detail`;

CREATE TABLE `returan_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_returan` int(10) unsigned DEFAULT NULL,
  `id_detail_penjualan` int(10) unsigned DEFAULT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `item_id` int(10) unsigned DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_id` int(10) unsigned DEFAULT NULL,
  `qty_retur` int(11) NOT NULL,
  `datetime_transaction` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `returan_detail_id_returan_foreign` (`id_returan`),
  KEY `returan_detail_customer_id_foreign` (`customer_id`),
  KEY `returan_detail_item_id_foreign` (`item_id`),
  KEY `returan_detail_supplier_id_foreign` (`supplier_id`),
  KEY `id_detail_penjualan` (`id_detail_penjualan`),
  CONSTRAINT `returan_detail_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `returan_detail_id_detail_penjualan_foreign` FOREIGN KEY (`id_detail_penjualan`) REFERENCES `penjualan_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `returan_detail_id_returan_foreign` FOREIGN KEY (`id_returan`) REFERENCES `returans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `returan_detail_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `returan_detail_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `returan_detail` */

insert  into `returan_detail`(`id`,`id_returan`,`id_detail_penjualan`,`customer_id`,`item_id`,`item_name`,`supplier_id`,`qty_retur`,`datetime_transaction`,`status`,`created_at`,`updated_at`) values 
(1,1,3,3,6,'b6',24,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(2,1,4,1,1,'b1',23,2,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(3,1,5,1,3,'b3',23,2,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(4,1,6,1,5,'b5',24,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(5,2,9,2,1,'b1',23,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:25','2017-04-27 10:54:25'),
(6,2,10,2,2,'b22',23,1,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(7,2,11,2,4,'b4',24,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(8,2,12,2,6,'b6',24,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(9,2,18,1,1,'b1',23,4,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(10,3,39,4,12,'celana bahan kain',23,1,'2017-07-24 18:28:44',1,'2017-07-24 18:28:45','2017-07-24 18:28:45'),
(11,3,42,3,12,'celana bahan kain',23,1,'2017-07-24 18:28:44',1,'2017-07-24 18:28:45','2017-07-24 18:28:45'),
(12,4,37,1,12,'celana',23,2,'2017-07-24 18:33:01',1,'2017-07-24 18:33:01','2017-07-24 18:33:01'),
(13,4,7,2,2,'b22',23,1,'2017-08-02 16:11:53',1,'2017-08-02 16:11:53','2017-08-02 16:11:53'),
(14,4,8,2,3,'b3',23,2,'2017-08-02 16:11:53',1,'2017-08-02 16:11:53','2017-08-02 16:11:53'),
(15,4,13,1,1,'b1',23,1,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(16,4,14,1,2,'b22',23,2,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(17,4,7,2,2,'b22',23,1,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(18,4,8,2,3,'b3',23,2,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(19,4,13,1,1,'b1',23,2,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(20,4,14,1,2,'b22',23,3,'2017-08-02 16:22:41',1,'2017-08-02 16:22:42','2017-08-02 16:22:42'),
(21,4,7,2,2,'b22',23,1,'2017-08-02 16:23:04',1,'2017-08-02 16:23:04','2017-08-02 16:23:04'),
(22,4,8,2,3,'b3',23,2,'2017-08-02 16:23:04',1,'2017-08-02 16:23:04','2017-08-02 16:23:04'),
(23,5,1,2,2,'b22',23,1,'2017-08-07 17:28:18',1,'2017-08-07 17:28:18','2017-08-07 17:28:18'),
(24,5,2,2,5,'b5',24,1,'2017-08-07 17:28:18',1,'2017-08-07 17:28:19','2017-08-07 17:28:19'),
(25,6,1,2,2,'b22',23,0,'2017-08-07 17:28:36',1,'2017-08-07 17:28:36','2017-08-07 17:28:36'),
(26,6,2,2,5,'b5',24,3,'2017-08-07 17:28:36',1,'2017-08-07 17:28:36','2017-08-07 17:28:36'),
(27,7,1,2,2,'b22',23,1,'2017-08-07 17:28:47',1,'2017-08-07 17:28:47','2017-08-07 17:28:47'),
(28,7,2,2,5,'b5',24,1,'2017-08-07 17:28:47',1,'2017-08-07 17:28:47','2017-08-07 17:28:47'),
(29,8,45,1,6,'b6',24,1,'2017-08-21 18:40:21',1,'2017-08-21 18:40:21','2017-08-21 18:40:21'),
(30,8,46,1,10,'b8',23,1,'2017-08-21 18:40:21',1,'2017-08-21 18:40:21','2017-08-21 18:40:21'),
(31,9,45,1,6,'b6',24,0,'2017-08-21 18:40:44',1,'2017-08-21 18:40:44','2017-08-21 18:40:44'),
(32,9,46,1,10,'b8',23,0,'2017-08-21 18:40:44',1,'2017-08-21 18:40:44','2017-08-21 18:40:44'),
(33,10,45,1,6,'b6',24,1,'2017-08-21 18:41:49',1,'2017-08-21 18:41:49','2017-08-21 18:41:49'),
(34,10,46,1,10,'b8',23,0,'2017-08-21 18:41:49',1,'2017-08-21 18:41:49','2017-08-21 18:41:49');

/*Table structure for table `returan_detail_status` */

DROP TABLE IF EXISTS `returan_detail_status`;

CREATE TABLE `returan_detail_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_returan_detail` int(10) unsigned DEFAULT NULL,
  `qty_waste` int(11) NOT NULL,
  `qty_kembali` int(11) NOT NULL,
  `datetime_transaction` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `returan_detail_status_id_returan_detail_foreign` (`id_returan_detail`),
  CONSTRAINT `returan_detail_status_id_returan_detail_foreign` FOREIGN KEY (`id_returan_detail`) REFERENCES `returan_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `returan_detail_status` */

insert  into `returan_detail_status`(`id`,`id_returan_detail`,`qty_waste`,`qty_kembali`,`datetime_transaction`,`status`,`created_at`,`updated_at`) values 
(1,1,0,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(2,2,1,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(3,3,1,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(4,4,1,0,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(5,5,0,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:25','2017-04-27 10:54:25'),
(6,6,0,1,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(7,7,0,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(8,8,0,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(9,9,2,2,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(10,10,0,1,'2017-07-24 18:28:44',1,'2017-07-24 18:28:45','2017-07-24 18:28:45'),
(11,11,0,1,'2017-07-24 18:28:44',1,'2017-07-24 18:28:45','2017-07-24 18:28:45'),
(12,12,1,1,'2017-07-24 18:33:01',1,'2017-07-24 18:33:01','2017-07-24 18:33:01'),
(13,13,0,1,'2017-08-02 16:11:53',1,'2017-08-02 16:11:53','2017-08-02 16:11:53'),
(14,14,0,2,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(15,15,1,0,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(16,16,2,0,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(17,17,0,1,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(18,18,1,1,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(19,19,0,2,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(20,20,3,0,'2017-08-02 16:22:41',1,'2017-08-02 16:22:42','2017-08-02 16:22:42'),
(21,21,0,1,'2017-08-02 16:23:04',1,'2017-08-02 16:23:04','2017-08-02 16:23:04'),
(22,22,0,2,'2017-08-02 16:23:04',1,'2017-08-02 16:23:04','2017-08-02 16:23:04'),
(23,23,0,1,'2017-08-07 17:28:18',1,'2017-08-07 17:28:18','2017-08-07 17:28:18'),
(24,24,0,1,'2017-08-07 17:28:18',1,'2017-08-07 17:28:19','2017-08-07 17:28:19'),
(25,25,0,0,'2017-08-07 17:28:36',1,'2017-08-07 17:28:36','2017-08-07 17:28:36'),
(26,26,0,3,'2017-08-07 17:28:36',1,'2017-08-07 17:28:36','2017-08-07 17:28:36'),
(27,27,0,1,'2017-08-07 17:28:47',1,'2017-08-07 17:28:47','2017-08-07 17:28:47'),
(28,28,0,1,'2017-08-07 17:28:47',1,'2017-08-07 17:28:47','2017-08-07 17:28:47'),
(29,29,0,1,'2017-08-21 18:40:21',1,'2017-08-21 18:40:21','2017-08-21 18:40:21'),
(30,30,1,0,'2017-08-21 18:40:21',1,'2017-08-21 18:40:21','2017-08-21 18:40:21'),
(31,31,0,0,'2017-08-21 18:40:44',1,'2017-08-21 18:40:44','2017-08-21 18:40:44'),
(32,32,0,0,'2017-08-21 18:40:44',1,'2017-08-21 18:40:44','2017-08-21 18:40:44'),
(33,33,0,1,'2017-08-21 18:41:49',1,'2017-08-21 18:41:49','2017-08-21 18:41:49'),
(34,34,0,0,'2017-08-21 18:41:49',1,'2017-08-21 18:41:49','2017-08-21 18:41:49');

/*Table structure for table `returans` */

DROP TABLE IF EXISTS `returans`;

CREATE TABLE `returans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_retur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_transaction` datetime NOT NULL,
  `datetime_return` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `returans` */

insert  into `returans`(`id`,`no_retur`,`datetime_transaction`,`datetime_return`,`status`,`created_at`,`updated_at`) values 
(1,'RT52488','2017-03-16 23:14:40','2017-03-16 23:13:54',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(2,'RT75812','2017-04-27 10:54:25','2017-04-27 10:53:14',1,'2017-04-27 10:54:25','2017-04-27 10:54:25'),
(3,'RT63455','2017-07-24 18:28:44','2017-07-24 18:28:33',1,'2017-07-24 18:28:44','2017-07-24 18:28:44'),
(4,'RT62377','2017-07-24 18:33:01','2017-07-24 18:32:52',1,'2017-07-24 18:33:01','2017-07-24 18:33:01'),
(5,'RT38768','2017-08-07 17:28:18','2017-08-07 17:28:09',1,'2017-08-07 17:28:18','2017-08-07 17:28:18'),
(6,'RT61469','2017-08-07 17:28:36','2017-08-07 17:28:19',1,'2017-08-07 17:28:36','2017-08-07 17:28:36'),
(7,'RT98835','2017-08-07 17:28:47','2017-08-07 17:28:37',1,'2017-08-07 17:28:47','2017-08-07 17:28:47'),
(8,'RT96294','2017-08-21 18:40:21','2017-08-21 18:40:13',1,'2017-08-21 18:40:21','2017-08-21 18:40:21'),
(9,'RT25435','2017-08-21 18:40:44','2017-08-21 18:40:36',1,'2017-08-21 18:40:44','2017-08-21 18:40:44'),
(10,'RT83308','2017-08-21 18:41:49','2017-08-21 18:41:22',1,'2017-08-21 18:41:49','2017-08-21 18:41:49');

/*Table structure for table `suppliers` */

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pic_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pic_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pic_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pic_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `suppliers` */

insert  into `suppliers`(`id`,`supplier_code`,`supplier_name`,`pic_name`,`pic_contact`,`pic_email`,`pic_phone`,`supplier_location`,`supplier_description`,`status`,`created_at`,`updated_at`) values 
(23,'SU1213','sup1','picsup1','123412341234','sup1@gmail.com','','lokasi sup1','desc sup1',1,'2017-03-16 00:00:00','2017-08-09 16:47:03'),
(24,'SU12332','sup2','picsup2','123412341234','sup2@gmail.com','','lokasi sup2','desc sup2',1,'2017-03-16 00:00:00','2017-03-16 00:00:00'),
(25,'zxcv','zxcv','zxcv','1234','','','zxcv','zxcv',0,'2017-08-07 13:33:47','2017-08-07 13:33:55'),
(26,'SU1212','qwerq','qerqwr','12341234','','','asdfasdfas','fasdfasdf',1,'2017-08-09 16:45:11','2017-08-09 16:45:11');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'admin','admin@gmail.com','$2y$10$dawAwYkCz8EOIjPC3CRTEuXTKsQb3QsfgDPtzHOQvSvQ5u8gyiyBS','YBbhkYUqNkH77EPLopmhSJzgTcvrNunRVvUaErJffeg43gGgDbaIdVPWFklO','2017-01-25 08:29:08','2017-04-27 16:31:45');

/*Table structure for table `waste_list` */

DROP TABLE IF EXISTS `waste_list`;

CREATE TABLE `waste_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_returan` int(10) unsigned DEFAULT NULL,
  `item_id` int(10) unsigned DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_id` int(10) unsigned DEFAULT NULL,
  `qty_waste` int(11) NOT NULL,
  `datetime_transaction` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `waste_list_item_id_foreign` (`item_id`),
  KEY `waste_list_supplier_id_foreign` (`supplier_id`),
  KEY `waste_list_id_returan_foreign` (`id_returan`),
  CONSTRAINT `waste_list_id_returan_foreign` FOREIGN KEY (`id_returan`) REFERENCES `returan_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `waste_list_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `waste_list_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `waste_list` */

insert  into `waste_list`(`id`,`id_returan`,`item_id`,`item_name`,`supplier_id`,`qty_waste`,`datetime_transaction`,`status`,`created_at`,`updated_at`) values 
(1,1,6,'b6',24,0,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(2,2,1,'b1',23,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(3,3,3,'b3',23,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(4,4,5,'b5',24,1,'2017-03-16 23:14:40',1,'2017-03-16 23:14:40','2017-03-16 23:14:40'),
(5,5,1,'b1',23,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:25','2017-04-27 10:54:25'),
(6,6,2,'b22',23,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(7,7,4,'b4',24,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(8,8,6,'b6',24,0,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(9,9,1,'b1',23,2,'2017-04-27 10:54:25',1,'2017-04-27 10:54:26','2017-04-27 10:54:26'),
(10,10,12,'celana bahan kain',23,0,'2017-07-24 18:28:44',1,'2017-07-24 18:28:45','2017-07-24 18:28:45'),
(11,11,12,'celana bahan kain',23,0,'2017-07-24 18:28:44',1,'2017-07-24 18:28:45','2017-07-24 18:28:45'),
(12,12,12,'celana',23,1,'2017-07-24 18:33:01',1,'2017-07-24 18:33:02','2017-07-24 18:33:02'),
(13,13,2,'b22',23,0,'2017-08-02 16:11:53',1,'2017-08-02 16:11:53','2017-08-02 16:11:53'),
(14,14,3,'b3',23,0,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(15,15,1,'b1',23,1,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(16,16,2,'b22',23,2,'2017-08-02 16:11:53',1,'2017-08-02 16:11:54','2017-08-02 16:11:54'),
(17,17,2,'b22',23,0,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(18,18,3,'b3',23,1,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(19,19,1,'b1',23,0,'2017-08-02 16:22:41',1,'2017-08-02 16:22:41','2017-08-02 16:22:41'),
(20,20,2,'b22',23,3,'2017-08-02 16:22:41',1,'2017-08-02 16:22:42','2017-08-02 16:22:42'),
(21,21,2,'b22',23,0,'2017-08-02 16:23:04',1,'2017-08-02 16:23:04','2017-08-02 16:23:04'),
(22,22,3,'b3',23,0,'2017-08-02 16:23:04',1,'2017-08-02 16:23:04','2017-08-02 16:23:04'),
(23,23,2,'b22',23,0,'2017-08-07 17:28:18',1,'2017-08-07 17:28:18','2017-08-07 17:28:18'),
(24,24,5,'b5',24,0,'2017-08-07 17:28:18',1,'2017-08-07 17:28:19','2017-08-07 17:28:19'),
(25,25,2,'b22',23,0,'2017-08-07 17:28:36',1,'2017-08-07 17:28:36','2017-08-07 17:28:36'),
(26,26,5,'b5',24,0,'2017-08-07 17:28:36',1,'2017-08-07 17:28:37','2017-08-07 17:28:37'),
(27,27,2,'b22',23,0,'2017-08-07 17:28:47',1,'2017-08-07 17:28:47','2017-08-07 17:28:47'),
(28,28,5,'b5',24,0,'2017-08-07 17:28:47',1,'2017-08-07 17:28:47','2017-08-07 17:28:47'),
(29,29,6,'b6',24,0,'2017-08-21 18:40:21',1,'2017-08-21 18:40:21','2017-08-21 18:40:21'),
(30,30,10,'b8',23,1,'2017-08-21 18:40:21',1,'2017-08-21 18:40:21','2017-08-21 18:40:21'),
(31,31,6,'b6',24,0,'2017-08-21 18:40:44',1,'2017-08-21 18:40:44','2017-08-21 18:40:44'),
(32,32,10,'b8',23,0,'2017-08-21 18:40:44',1,'2017-08-21 18:40:44','2017-08-21 18:40:44'),
(33,33,6,'b6',24,0,'2017-08-21 18:41:49',1,'2017-08-21 18:41:49','2017-08-21 18:41:49'),
(34,34,10,'b8',23,0,'2017-08-21 18:41:49',1,'2017-08-21 18:41:49','2017-08-21 18:41:49');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
