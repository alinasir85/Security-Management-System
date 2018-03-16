/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.13-MariaDB : Database - sms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sms` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `sms`;

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `country` */

insert  into `country`(`id`,`name`) values (1,'Pakistan'),(2,'India'),(3,'China'),(4,'USA'),(5,'Turkey');

/*Table structure for table `loginhistory` */

DROP TABLE IF EXISTS `loginhistory`;

CREATE TABLE `loginhistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `logintime` datetime DEFAULT NULL,
  `machineip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `loginhistory` */

insert  into `loginhistory`(`id`,`userid`,`login`,`logintime`,`machineip`) values (1,0,'admin','2018-03-16 17:49:26','::1'),(2,0,'1','2018-03-16 17:52:34','::1'),(3,8,'hassan','2018-03-16 17:53:26','::1'),(4,1,'admin','2018-03-16 17:58:20','::1'),(5,1,'admin','2018-03-16 18:16:54','::1'),(6,8,'hassan','2018-03-16 20:20:02','::1'),(7,8,'hassan','2018-03-16 20:21:46','::1'),(8,8,'hassan','2018-03-16 22:33:03','::1'),(9,1,'admin','2018-03-16 22:40:05','::1'),(10,10,'bilal','2018-03-16 22:41:31','::1'),(11,1,'admin','2018-03-16 22:42:07','::1'),(12,10,'bilal','2018-03-16 22:44:21','::1'),(13,1,'admin','2018-03-16 23:34:29','::1'),(14,10,'bilal','2018-03-16 23:34:59','::1'),(15,1,'admin','2018-03-16 23:35:06','::1'),(16,10,'bilal','2018-03-16 23:36:24','::1'),(17,10,'bilal','2018-03-16 23:36:53','::1'),(18,1,'admin','2018-03-17 00:04:36','::1'),(19,11,'komal','2018-03-17 00:12:23','::1'),(20,7,'ali','2018-03-17 00:14:48','::1'),(21,10,'bilal','2018-03-17 00:19:34','::1'),(22,7,'ali','2018-03-17 00:19:48','::1'),(23,10,'bilal','2018-03-17 00:56:32','::1'),(24,7,'ali','2018-03-17 01:00:27','::1'),(25,10,'bilal','2018-03-17 01:00:53','::1'),(26,10,'bilal','2018-03-17 01:08:30','::1');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `permissionid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  PRIMARY KEY (`permissionid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `permissions` */

insert  into `permissions`(`permissionid`,`name`,`description`,`createdon`,`createdby`) values (1,'perm1','perm1','2018-03-16 17:11:52',1),(3,'perm3','masadja','2018-03-16 17:12:51',1),(6,'perm4','perm4','2018-03-16 23:35:29',1),(7,'perm5','perm5','2018-03-17 00:11:48',1),(8,'perm6','perm6','2018-03-17 00:48:45',7);

/*Table structure for table `role_permission` */

DROP TABLE IF EXISTS `role_permission`;

CREATE TABLE `role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleid` int(11) DEFAULT NULL,
  `permissionid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roleid` (`roleid`),
  KEY `permissionid` (`permissionid`),
  CONSTRAINT `role_permission_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `roles` (`roleid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_permission_ibfk_2` FOREIGN KEY (`permissionid`) REFERENCES `permissions` (`permissionid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `role_permission` */

insert  into `role_permission`(`id`,`roleid`,`permissionid`) values (3,1,3),(12,6,1),(13,6,3),(15,3,6),(16,1,7);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`roleid`,`name`,`description`,`createdon`,`createdby`) values (1,'manager','manages','2018-03-16 16:22:43',1),(3,'principal','dances','2018-03-16 16:49:16',1),(6,'employee','do tasks','2018-03-16 16:58:46',1),(10,'leader','leads','2018-03-17 00:49:04',7);

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `roleid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `roleid` (`roleid`),
  CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`roleid`) REFERENCES `roles` (`roleid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `user_role` */

insert  into `user_role`(`id`,`userid`,`roleid`) values (18,10,3),(19,10,6);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `countryid` int(11) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `isadmin` int(1) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`userid`,`login`,`password`,`name`,`email`,`countryid`,`createdon`,`createdby`,`isadmin`) values (1,'admin','admin','admin','admin',1,'2018-03-16 23:23:22',0,1),(7,'ali','12345678','ali nasir','alinasir@live.com',3,'2018-03-16 15:48:46',1,1),(8,'hassan','123','hassan mirza','hassan@yahoo.com',2,'2018-03-16 17:35:40',1,0),(10,'bilal','123','bilal','bilal@live.com',4,'2018-03-17 00:56:16',7,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
