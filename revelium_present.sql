CREATE DATABASE  IF NOT EXISTS `revelium_present` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `revelium_present`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: revelium_present
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance` (
  `student_id` int(10) NOT NULL,
  `subject_id` int(10) NOT NULL,
  `state` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (10,0,'ausente','2024-11-27'),(10,0,'ausente','2024-11-27'),(10,0,'ausente','2024-11-27'),(10,1,'presente','2024-11-27'),(10,0,'ausente','2024-11-26'),(10,0,'ausente','2024-11-27'),(11,0,'ausente','2024-11-27'),(10,0,'ausente','2024-11-29'),(11,0,'ausente','2024-11-29'),(10,0,'ausente','2024-11-29'),(11,0,'ausente','2024-11-29'),(11,2,'presente','2024-11-29'),(11,1,'presente','2024-11-29'),(10,1,'ausente','2024-11-29');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_subject`
--

DROP TABLE IF EXISTS `student_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_subject` (
  `student_id` int(10) NOT NULL,
  `subject_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_subject`
--

LOCK TABLES `student_subject` WRITE;
/*!40000 ALTER TABLE `student_subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_teacher`
--

DROP TABLE IF EXISTS `student_teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_teacher` (
  `student_id` int(10) NOT NULL,
  `teacher_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_teacher`
--

LOCK TABLES `student_teacher` WRITE;
/*!40000 ALTER TABLE `student_teacher` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `student_id` int(10) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `DNI` int(10) NOT NULL,
  `career` varchar(255) NOT NULL,
  `year` int(4) NOT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `student_id` (`student_id`,`mail`,`DNI`),
  UNIQUE KEY `student_id_2` (`student_id`,`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (10,'sunaoniiloveyou@gmail.com','$2y$10$4UsqFVGkSlufDlfStG6Jt.lHDaWh1rX469CpbX7cu85PRdgfL5Fca','Goro','Majima',19881205,'DS',2),(11,'46216590@terciariourquiza.edu.ar','$2y$10$ASbAT93DkXvWwN7.KuTvoOw/y1RjpSPzf2lONXmnCA307UkHQOPW.','Mauro','Corbari',46216590,'DS',2);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject` (
  `subject_id` int(10) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `career` varchar(255) NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (0,'Ingenieria',8,2,'DS'),(1,'Base de Datos',8,2,'DS'),(2,'Sufrimiento',8,2,'DS'),(4,'Programacion',7,2,'DS');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_subject`
--

DROP TABLE IF EXISTS `teacher_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teacher_subject` (
  `subject_id` int(10) NOT NULL,
  `teacher_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_subject`
--

LOCK TABLES `teacher_subject` WRITE;
/*!40000 ALTER TABLE `teacher_subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `teacher_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teachers` (
  `teacher_id` int(10) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `DNI` int(10) NOT NULL,
  PRIMARY KEY (`teacher_id`),
  UNIQUE KEY `teacher_id` (`teacher_id`,`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (7,'pla.marcelo@terciariourquiza.edu.ar','$2y$10$VMUyGGHhDVv95mQsbq/.d.SCuNPKeiX5APRhemI8hvP/kn1hx/tCm','Pla','Marcelo',16603049),(8,'servan.diego@terciariourquiza.edu.ar','$2y$10$U1X1YoiDFSn49mFdCZrDeOYrNG/GPdL0TXwlxWWkJibyAJhVK.Ed2','Servan','Diego',55555555);
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-04 18:58:18
