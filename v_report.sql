-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 12, 2023 at 05:16 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev_pitjarus`
--

-- --------------------------------------------------------

--
-- Structure for view `v_report`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_report`  AS SELECT `store_area`.`area_name` AS `area_name`, `store_area`.`area_id` AS `area_id`, ((sum(`report_product`.`compliance`) / count(0)) * 100) AS `percent`, `product_brand`.`brand_name` AS `brand_name`, `product_brand`.`brand_id` AS `brand_id`, `report_product`.`tanggal` AS `tanggal` FROM ((((`report_product` join `product` on((`product`.`product_id` = `report_product`.`product_id`))) join `product_brand` on((`product_brand`.`brand_id` = `product`.`brand_id`))) join `store` on((`store`.`store_id` = `report_product`.`store_id`))) join `store_area` on((`store_area`.`area_id` = `store`.`area_id`))) WHERE (`report_product`.`store_id` is not null) GROUP BY `store_area`.`area_name`, `product_brand`.`brand_name`, `report_product`.`tanggal`, `product_brand`.`brand_id`, `store_area`.`area_id``area_id`  ;

--
-- VIEW `v_report`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
