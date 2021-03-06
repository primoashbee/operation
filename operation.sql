/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.21-MariaDB : Database - lmi_operations
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lmi_operations` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `lmi_operations`;

/*Table structure for table `branches` */

DROP TABLE IF EXISTS `branches`;

CREATE TABLE `branches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `operation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `branches` */

insert  into `branches`(`id`,`operation`,`name`,`deleted_at`,`created_at`,`updated_at`) values (1,'SLO','OLONGAPO',NULL,NULL,NULL),(2,'NLO','PAMPANGA',NULL,NULL,NULL),(3,'SLO','TARLAC',NULL,NULL,NULL),(4,'VIZMIN','CEBU',NULL,NULL,NULL);

/*Table structure for table `capital_build_ups` */

DROP TABLE IF EXISTS `capital_build_ups`;

CREATE TABLE `capital_build_ups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amort_id` int(10) unsigned DEFAULT NULL,
  `disbursement_id` int(10) unsigned DEFAULT NULL,
  `client_id` int(10) unsigned DEFAULT NULL,
  `amount` int(10) unsigned DEFAULT NULL,
  `transaction_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `capital_build_ups` */

insert  into `capital_build_ups`(`id`,`amort_id`,`disbursement_id`,`client_id`,`amount`,`transaction_type`) values (1,2,1,1,0,'deposit'),(2,27,1,2,0,'deposit'),(3,52,1,3,0,'deposit'),(4,77,1,4,0,'deposit'),(5,3,1,1,0,'deposit'),(6,28,1,2,0,'deposit'),(7,53,1,3,0,'deposit'),(8,78,1,4,0,'deposit');

/*Table structure for table `cbu_collections` */

DROP TABLE IF EXISTS `cbu_collections`;

CREATE TABLE `cbu_collections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_summaries_id` int(10) unsigned NOT NULL,
  `amort_id` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cbu_collections` */

/*Table structure for table `client_businesses` */

DROP TABLE IF EXISTS `client_businesses`;

CREATE TABLE `client_businesses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `main_business` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `secondary_business` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `main_business_years` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_paid_employees` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_place_characteristic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `client_businesses` */

insert  into `client_businesses`(`id`,`client_id`,`main_business`,`secondary_business`,`main_business_years`,`number_of_paid_employees`,`business_place_characteristic`,`created_at`,`updated_at`) values (1,1,'Druuuuuuuuuuuuuuuuuuuugz','None','5','0','Owned','2017-01-04 14:26:23','2017-01-04 14:26:23'),(2,2,'Softwares and Hardwares','','5','0','Owned','2017-01-04 15:18:19','2017-01-04 15:18:19'),(3,3,'Phone Repair','','10','0','Owned','2017-01-04 15:25:35','2017-01-04 15:25:35'),(4,4,'Poultry','','5','','Ambulant','2017-01-06 15:32:29','2017-01-06 15:32:29'),(5,5,'FVDICQpW3s','cT0qndeKS3','1990','55','gufVuRpPmK',NULL,NULL),(6,6,'mAE0hCfRjN','9eLoDLGuUm','1990','53','byEgrsjQAC',NULL,NULL),(7,7,'PLIlYV8RtY','Yd1SE7et9l','2013','5','erG0yygW82',NULL,NULL),(8,8,'4IyuJOw9gm','SHVJ4cvMUP','1990','76','K6xuRaGfZb',NULL,NULL),(9,9,'CTkITXe06E','L9uP501gdh','2012','23','Zxow29PHwq',NULL,NULL),(10,10,'rkj1mCtw7d','L5fvqRPPro','2012','29','T03dEjY2ef',NULL,NULL),(11,11,'fBAYWhGMlm','GniefaHGQc','2010','23','kz6UAOKZKr',NULL,NULL),(12,12,'53gvSxJZcX','JdwhGKXkQk','1991','4','ypGeFNNI7N',NULL,NULL),(13,13,'T5BSegAtRR','dPsHn8WtA6','2015','71','j77RSQtMSZ',NULL,NULL),(14,14,'Jie5qlmkAY','4yPApSskNe','2009','42','eS09qggMof',NULL,NULL),(15,15,'p2rStkBz1u','kFiyD3JhPD','1992','84','rCmfudZYtB',NULL,NULL),(16,16,'jweT7dJdfm','EYp3yL7444','1998','32','3djNzGEtLi',NULL,NULL),(17,17,'06s3GfgIt0','v9mpknP3d7','2004','25','jVDm0D4cwN',NULL,NULL),(18,18,'tyhykDcuLD','apdA4rb2uI','2015','16','qmHVVlr4Mr',NULL,NULL),(19,19,'rOE1KWm31x','fviORDLOdZ','1991','11','yZWSBwI50C',NULL,NULL),(20,20,'o0PdMswofL','fu7nTT5fVa','1991','85','IyV2A2TVBZ',NULL,NULL),(21,21,'loEjf0Iqha','7gHtFD2TD8','2015','9','wuNqLMNtRY',NULL,NULL),(22,22,'bg4jUGMAcv','jshiqjzI74','2009','78','SB77fgGreh',NULL,NULL),(23,23,'qZNh94wsZw','g8W3xUEQoM','2014','33','Q2hCRTsQ13',NULL,NULL),(24,24,'YFz1eKReF1','cnAQRJT93K','2003','87','IHOarV9sxR',NULL,NULL),(25,25,'zVIbOV15Qb','ulHKvJ3hyF','1999','49','3m3pAh3m26',NULL,NULL),(26,26,'EDaENFjeri','hDKavtca0Q','2000','51','O5YFdYcadW',NULL,NULL),(27,27,'6h6MEAInPV','FqKnuNhyjj','2015','72','8fBg9zu6Gg',NULL,NULL),(28,28,'FhlP8D9go7','Zac2P88FuV','2014','62','jsqs6SN4O3',NULL,NULL),(29,29,'e5RDhhqDMJ','MxcF2bDQ06','1990','69','SxRmVW9Zf5',NULL,NULL),(30,30,'oHnq3vg4s9','a4k0p17zK7','1992','61','0jvZr46zA6',NULL,NULL),(31,31,'SyBdMhQwlm','ZswflHHfK5','1999','54','nFTXJLngri',NULL,NULL),(32,32,'h6fpnL3vqF','k1Dj4K0f1X','2003','37','rTptX3K5je',NULL,NULL),(33,33,'lsg6VuHudA','jqfWBw8aU0','1995','95','kKJpqpgDNO',NULL,NULL),(34,34,'2TM3D4t6Rp','6aLEO3IQAN','1994','32','20CqhmZxLe',NULL,NULL),(35,35,'EYWKkXCVds','Zj9vJIMnlR','2001','4','2xTF55RESi',NULL,NULL),(36,36,'8L82IQHFZi','Mn6eCbEKtH','2005','36','fJkoqcm3xu',NULL,NULL),(37,37,'JwApwuR5I4','kEwySLu8EP','1995','50','SHTCOjaaH1',NULL,NULL),(38,38,'vUWkbrV83c','vYDD5Gh5q3','2012','91','1GC92VZoTw',NULL,NULL),(39,39,'dOUN9vbbLp','rBoZsAYLGa','2000','47','bW5r17u79m',NULL,NULL),(40,40,'IfSSXIinZe','kZtokXnWXx','2000','85','K8bO9wxcep',NULL,NULL),(41,41,'ZP2SXPsi1s','YZAxkWGwss','1995','62','cVsm7hzPj3',NULL,NULL),(42,42,'BUOZu5vY3h','xSuVaSiqO9','1998','60','7B6Vh3XzRa',NULL,NULL),(43,43,'V7i789OUpy','jGAiOACNX2','2002','8','F5MKhaisHz',NULL,NULL),(44,44,'lO4N9vUyJ9','7DOgBYBT5j','1993','7','pz98RhUv5K',NULL,NULL),(45,45,'4OWqKHjZmH','tz0vbZyZhF','2002','54','lVhSO982xw',NULL,NULL),(46,46,'JRcYvOeWvC','4npjVFEDgC','2013','67','oOZb7a2DbK',NULL,NULL),(47,47,'2s5idq16hx','HiLjE40oe2','2016','12','Bf0zxvrZiy',NULL,NULL),(48,48,'r5oeuuTWrm','ao1RBFew4X','1992','29','j9HYoMn91l',NULL,NULL),(49,49,'lvKJDHfgzR','eKjYA7WIXR','1997','51','UQhWwPDjVG',NULL,NULL),(50,50,'L7IjMQZ4mb','ITuWLgPazU','2011','35','Vp5HV45uty',NULL,NULL),(51,51,'wr5v1bNgUz','KNnsmVPziR','1993','85','o8TGRvElig',NULL,NULL),(52,52,'SAq5T23wKh','uv3npA5jn8','2003','75','fzeYpgkvTv',NULL,NULL),(53,53,'xApLPJdB98','lOjIksCUUT','2012','79','vcID7UQVLG',NULL,NULL),(54,54,'NqpznyRxTL','sF1GMBqhjb','1997','90','fxGpTXKSEO',NULL,NULL),(55,55,'aPx39RgwzT','66fp9Kpvim','1995','49','wA9g54hE4p',NULL,NULL);

/*Table structure for table `client_incomes` */

DROP TABLE IF EXISTS `client_incomes`;

CREATE TABLE `client_incomes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `member_lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_middlename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_suffix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_age` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_relationship` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_occupation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_occupation_years` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_monthly_income` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `client_incomes` */

insert  into `client_incomes`(`id`,`client_id`,`member_lastname`,`member_firstname`,`member_middlename`,`member_suffix`,`member_age`,`member_relationship`,`member_occupation`,`member_occupation_years`,`member_monthly_income`,`member_address`,`created_at`,`updated_at`) values (1,1,'Morgado','BeeAsh','Microsoft','','20','Brother','Salesman','5','14000','1647 BALIC-BALIC STA RITA','2017-01-04 14:26:23','2017-01-04 14:26:23'),(2,2,'Melton','Alex','','','20','Sister','Saleslady','4','30000','1648 BALIC-BALIC STA RITA','2017-01-04 15:18:19','2017-01-04 15:18:19'),(3,3,'Bonyton','Doe','Jaxis','','20','Brother','Manager','10','50000','7th street, Class Field','2017-01-04 15:25:35','2017-01-04 15:25:35'),(4,4,'Doe','Johnnyyy','','','24','Brother','Gunman','10','1000000','Wicks Street v2','2017-01-06 15:32:29','2017-01-06 15:32:29'),(5,5,'OYG2RjIy9T','ZMy9cROmRr','MZtYaZLhR6','1','20','fPZg','fHjJvGv7rY','','7','wbVwM1pqiWw5Hbkl3ZOf',NULL,'2017-02-16 10:06:22'),(6,6,'ZLVCcFjLFT','pTUiX9MmiU','T36mxOs6qM','1','18','UtfZ','t4BP7uKtZf','','8','EexOeDAmvuAoDU9wH8gT',NULL,'2017-02-16 10:07:09'),(7,7,'hrBOTVQC22','8rSMhJ7P1Z','H2kkoEv10W','1','18','G9je','KdSXL9tuw5','','10','a2Hwx7HCaaU8DblT2PuZ',NULL,'2017-02-16 10:07:46'),(8,8,'VerD0AgGkf','VbS4nyoozc','FeNnzr9vJb','1','28','CNm3','yWSlqHvoE6','','5','tgV4E5AsitWz6jc3KfR0',NULL,'2017-02-16 10:08:09'),(9,9,'0zVBRARFSH','uQrkOFkQv0','Ikh8yy4J7U','1','25','tF22','Sq5xpmEijw','','1','SWpdqxbf7vy5fusdz2iB',NULL,'2017-02-16 10:08:31'),(10,10,'E9lqY4O5hg','A4wiT64DWm','h33FA42VIL','1','22','Ut3A','ghaISIxlNo','','0','lg148RBfXm59TwpJ6Y4o',NULL,'2017-02-16 10:08:49'),(11,11,'lcMqiuYb8l','rA6eVuUiXm','HqnxiIWr0z','1','23','nvop','klp69V6Xwk','','0','LQPeYYzTRt99PVOlzW7X',NULL,'2017-02-16 10:09:20'),(12,12,'NOhGA7lwe2','osvM9M3UNh','4qH35QIYaD','1','25','P3K9','j8SuJgR84o','','1','xtAulv4F22ltXwjLX9lp',NULL,'2017-02-16 10:09:45'),(13,13,'aAbmP7JytL','02zfmlzXFK','hnplLCgL7e','1','35','KrgG','gIYVn9JxGT','','2','Q4Khz9jOjQqpcTrDG9ze',NULL,'2017-02-16 10:10:33'),(14,14,'WIcsglz02A','mHDOON9qUz','2QDkmEfBwr','1','20','Ur30','5ccvFE2EuZ','','9','B9KwOywqBhDE4PgchHSq',NULL,'2017-02-16 10:11:25'),(15,15,'aqWGuHgdGK','IUnirmAtoc','tThCRmdyRj','1','22','OXNG','JqoXObtvtq','','4','FAzAGeYLqbuB2b9PPrB1',NULL,'2017-02-16 10:11:39'),(16,16,'HDAYJd8Pbv','b3Ao1HxKXT','Bn73mnlGsn','1','vO','cqnZ','cKYi7BNHXP','jloAxV9g67','0','xAmfTCWkmOcv5XRMsN6m',NULL,NULL),(17,17,'Qm0SH5bQfS','o0MnRHc2n5','WNw9G6ouen','1','Y3','MLuh','hmeGcRE99g','FDJ7FqF8TM','1','fKSuY911KdKwxAAXzVNI',NULL,NULL),(18,18,'0h7AaERCsm','rOergRms3m','thRvQGqLC5','1','EC','K94o','wrq520AZxE','oRoZE40qIx','7','2ciTousfyN4jczOeNosF',NULL,NULL),(19,19,'A6XDhbopZa','JS6Mt3XsbO','cCc8jRK0Yr','1','5E','cefw','63eNTIGUxc','lZ28b1gAI3','3','4XRVhRtTRaF8PTmYv0Yl',NULL,NULL),(20,20,'EJKhcq17Uk','WMqzCKPs8d','PvL2PRPHU4','1','cI','RzC6','r2P5JXXmEf','XXAVSfzehb','5','8vUxO4R4F6DGX5VXQ9sk',NULL,NULL),(21,21,'j7kuC2jqog','ovsdMocurd','uqiUAbEmNs','1','rh','uFlH','jhMW23nckz','KfFb5zw3LS','2','3BKeAXf9TURLtURKIej6',NULL,NULL),(22,22,'OWTty0HC1J','hrQpMymzZN','AsctNE0my6','1','JE','09xw','xc6nM0N8KE','0vvY68zGnl','7','eMpFjO7RqJhBeMIqSv6o',NULL,NULL),(23,23,'pt2jtDitD2','SI9t9Zlz5v','MtObd4T2Ao','1','Ce','W4SI','XgUr0QGDho','kwuFcGZpos','9','o4iqRBJe5SAasYi39jWE',NULL,NULL),(24,24,'rL2pCFo9UU','E9bvBNRcMm','ci2Npu4i4G','1','LC','LVPi','Xf2Mug4ktb','yzsUL6gFBm','9','XNewx5dNeUQ1dLz3cokq',NULL,NULL),(25,25,'GGNAi9a6Ib','AjYd16rvlX','FLmPnqD7UF','1','WN','6XDn','TRtT2TeiXg','V8wFsAmRX0','7','L3qho3au3G4Qxv5LkGSE',NULL,NULL),(26,26,'kG7TBldriO','NVuMsU2JAj','itF6rVoj71','1','41','60io','hUfPQPFaij','HitZho6Bwi','1','mo6PRjb3yzvmL4hIEZkx',NULL,NULL),(27,27,'lJrmlezSGd','m6JG2Y3fPC','TKpwjiEEEQ','1','oI','QjkR','J15McENzHW','W3QOJLjhp7','5','HIMtw5OWYnGFH05rQVGs',NULL,NULL),(28,28,'r9eHJuFVMb','Qnb4ZzsIRd','7kS4lkGpXG','1','gh','Aemt','CCCO8MLeq6','Ts8t3wEMiR','1','YTYopfmKiHk0PG4YVDpK',NULL,NULL),(29,29,'hUhYcAPzwJ','CUEnTjDi92','4pazkaAdeM','1','UX','z0Cn','9y4aR1LMWn','FDzcx3c26v','8','zCkwQ8tC6trzKnbSwu5N',NULL,NULL),(30,30,'XrvgPI9Yv1','1ZHfT6rX55','r4glBVtFty','1','bu','qGlu','uDwfZlFCOG','Gn30xMfbuO','2','xdoh84B9yMzQtn65XALu',NULL,NULL),(31,31,'Ye4IXO1vuI','Ht7lNeC9Gw','RnYEwUQxss','1','cL','yjHm','j7RsXBMUlf','VmJsJNpajP','3','vGY3zHvPz0PsJwKJIu0Z',NULL,NULL),(32,32,'gchyQuFOM7','GolmbNCQtn','0CDnhfICHY','1','iC','D1Vw','bX5Xizjz8h','v2BKXsUouy','9','lkw8o4gnwaqkkHOWigeS',NULL,NULL),(33,33,'SRFQWrD5Yg','IlSWWw4B5E','BpTHHK021d','1','Jh','xUo6','XhIq8lJdvT','hFR17l2WSL','7','OQwgAqSv3om7SgxjwF9y',NULL,NULL),(34,34,'VTYi7R8YUG','b3sLIVlJKl','gTd4a71gMH','1','yn','nW6S','yUysV0kQyK','y32QI31p14','2','tVuVOYrYUpW7WgAvyReR',NULL,NULL),(35,35,'CYDIZbaBHl','CsCJFmuYWW','tUx5abpgLg','1','wP','sUtW','MJYpOXm5h4','Vh5dsfOMlh','7','QXz9QKxqICmlNFUqjzM4',NULL,NULL),(36,36,'zuyLHQLZty','6bRNgubUik','Zzf97FUq7z','1','z6','b4At','Ctzh5qYB9L','lmo92gvIkg','0','DQLdZgA2kFjUEaJLWPR8',NULL,NULL),(37,37,'ViiJxIwvPp','0apATJL9lN','zDMXj6OGBX','1','Jc','oKoV','kyMLANYukj','yMgOjuDmfK','7','CSY2hqNCg2rsUxLEmkeI',NULL,NULL),(38,38,'zY5io8DoGj','zEEE3JjRF0','xe2qkjODw5','1','J2','ptic','kyN0ppHdFS','HSjmbv1PBZ','4','840wbXU80cZggIdp1hXh',NULL,NULL),(39,39,'NT9gabRGQz','94sScdQ6YU','yxnoUzNKvy','1','jP','uBFP','wfZhECC61A','ug5CEvm1m3','7','h5SNGl3OImDqWCV1f0Ko',NULL,NULL),(40,40,'wIgb2pBKBM','LBsObMjrCO','WkjcMoVXMP','1','23','QpUp','4nIkONDVnG','3v8JiQyPcV','0','3EY2Is9P5FLbT31vBYVv',NULL,NULL),(41,41,'Jv9Gx0qJWE','zp2ITs82K2','9Xfm3Qj8Ww','1','Qh','79Ps','XMBgifDOyY','jSjamzjeyq','1','i5lbKScheS66L63UzuN7',NULL,NULL),(42,42,'S8MBv0uqaB','5Ul0Jx86lO','wtYKDljr6a','1','CD','UuFC','z2XVeQS0GR','I3Xnii9ZmC','0','4oNgxtFv013yMjuy8eRT',NULL,NULL),(43,43,'X0eZpodlmh','gVEXth24dQ','FZkJAqkPZA','1','0T','gkvu','F6UzWMuZRo','0PO8jowiHi','8','oVSNBsqHGLTIGSBRztx8',NULL,NULL),(44,44,'OXDQqEslUx','NlJPyKGeTA','BLP6ET7Kny','1','vU','dXS1','G9twGPlqBn','X4XWmKeK7R','1','ExpzZjpTy0PwfNWklQcz',NULL,NULL),(45,45,'AZHvBsb882','dAB4sGQ0V3','fn3FYQPJeN','1','HK','2Z2l','otQRSbBGvF','0BU8poZI5C','1','F6Vk8miQBEJLIze1DKNk',NULL,NULL),(46,46,'M9eFdLCr40','9zmd5hiuqi','GlDeM9Bn5z','1','pl','0k84','Azh3ES0uaW','vItDhy24fu','4','b1i46ef4b2VgE0CnrTSY',NULL,NULL),(47,47,'VD6cyRJNf3','H1WQboQCeg','uons1IEXK8','1','bZ','lND3','JlcveBso8x','w1ss7nP5GI','0','9lA5I4g0zAIomDJh1d1Z',NULL,NULL),(48,48,'PQuvyZy4dn','2ScwvznIxe','uTyX03AcJe','1','uN','L3tE','UYa4xBZt7q','qKOebQsc25','5','MjaeeUNQw2Nlvh77AxUQ',NULL,NULL),(49,49,'ctqmBQPBpR','mL1vOMrVlG','gH2O8v3FBu','1','D3','unsR','X98K1toOMg','Ip1gVKFQCF','0','r5iRx00K0qvcGNp0t4ka',NULL,NULL),(50,50,'Hs8lNQxj5m','ggp1OKhlGE','3thWb8G37q','1','jc','JBzC','NWtWp8vHUu','Cgf6A5CGAq','6','ttF6m5sT2lmwkwZchoUd',NULL,NULL),(51,51,'07nK0QM2HD','iRCdii2oDx','jEqAJdW0uy','1','Tu','crxp','wUurRr3hHG','vsKudtWvSc','9','4Qk3h0iCMUee9GfexYM5',NULL,NULL),(52,52,'Qr60CCKOV8','VzAd6IY9EX','XKnL9gqXBn','1','OA','Nl45','jskqpzxOBE','UJVDG2yEAk','4','i3CaQ8wln6oRTatprgPc',NULL,NULL),(53,53,'GsoDAU9e8s','gfWBTnphYI','vgoUXFiJbe','1','4j','xXxq','TsS9ZliCE6','3deD7yF7FA','0','MAbG7Wxfanp06LVjNSxF',NULL,NULL),(54,54,'Ademj810A9','WWjyml6LTS','opI8lbeeKb','1','V9','rTnY','DgqDeWTRIW','WpFfhbZoBJ','0','MLSSzqrjHO8l1aEQpjvy',NULL,NULL),(55,55,'9wvggIYfY8','QT4no79j7y','WUtfbiqGJD','1','bl','EkV3','WXNxYOonTb','C4ykKsrrNU','4','VOypevl04SpkODotrHlr',NULL,NULL);

/*Table structure for table `clients` */

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suffix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spouse_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TIN` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_year` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_year` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `civil_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `education` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `house_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `clients` */

insert  into `clients`(`id`,`lastname`,`firstname`,`middlename`,`branch_id`,`suffix`,`nickname`,`mother_name`,`spouse_name`,`TIN`,`birthday`,`home_address`,`home_year`,`business_address`,`business_year`,`mobile_number`,`telephone_number`,`civil_status`,`sex`,`education`,`house_type`,`deleted_at`,`created_at`,`updated_at`) values (1,'Morgado','Ashbee','Allego','1','','Bee','Rosita Allego','','','1994-11-26','1647 BALIC-BALIC STA RITA','2016','1647 BALIC-BALIC STA RITA','2016','0910 110 1126','047 222 4495','Single','Male','Male','Owned',NULL,'2017-01-04 14:26:23','2017-01-04 14:26:23'),(2,'Melton','Barbara','None','2','I','Barb','Alexis Melton','','','1990-01-04','1648 BALIC-BALIC STA RITA','2016','1648 BALIC-BALIC STA RITA','2016','0909 090 0909','045 222 2852','Single','Male','Male','Owned',NULL,'2017-01-04 15:18:19','2017-01-04 15:18:19'),(3,'Bonyton','Ester','Jaxis','3','','Es','Lucinda Bonyton','','','1985-01-05','7th street, Class Field','2016','7th street, Class Field','2016','0918 554 8863','7th street, Class Field','Single','Male','Male','Owned',NULL,'2017-01-04 15:25:35','2017-01-04 15:25:35'),(4,'Wick','John','None','1','','John','None','','','1989-01-05','Wicks Street','2016','Wicks Street','2016','0909 987 5888','045 889 5555','Single','Male','Male','Owned',NULL,'2017-01-06 15:32:29','2017-01-06 15:32:29'),(5,'De Castro','Macario','DG','1','6S','9pr5','yPgDKX4WyE','VC7iEqbzC0','5','1994-11-26','KjqK6aO6gR','1991','1VZzK3HIUq','2000','9Qcl9EndPiG','FjTqrNsQPm','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:06:22'),(6,'Villacruz','Aleli','None','1','5h','vS05','QUgcERvlHY','3szS76csvn','8','1994-11-26','DXb0lGmoNf','2008','1mh0unmPnn','2011','3HETLiBJBvG','URNFgKJMNY','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:07:09'),(7,'Pamintuan','Jonathan Mary','Secret','1','ac','tczZ','kyu6YL2Feh','UFCkW0Lqjs','6','1994-11-26','rRJVojMPd7','2012','haWVQxtYuP','2013','9RCqZMt1M53','776SOenEeu','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:07:46'),(8,'Layawan','Charis Ken','Secret','1','x2','EWnm','HwrgejEPGf','ifFcjmDYqR','3','1994-11-26','hYIir84TgZ','1992','dZklUtT80I','1998','MUA32ip0aZN','sxq6QHakOK','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:08:09'),(9,'Eramis','King','Mario','1','BI','5cqw','CmT6blrhDB','ZoUEGHAx0c','4','1994-11-26','DIfp8WH6aU','2004','iI2nMxUcwT','1990','xvVWaHZiL7m','sq6A0SXo4s','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:08:31'),(10,'Alegre','Paolo','Yuyu','1','37','6BG3','ypTHXyy332','cKHTowRgO2','10','1994-11-26','kn1VRnhriv','2013','I67EfNUvXo','1992','MtUKmLXzTfx','VmqX6MPBMJ','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:08:49'),(11,'Bomlarda','Michael','Secret','1','vz','wU3x','TfuhzvrX3C','arfTmAtEmW','10','1994-11-26','Ymjk8RRC45','2013','nbKem23uFm','1999','bQYMPxTQ9pe','HyHA2fQqx0','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:09:20'),(12,'Libunao','Erwin','None','1','Uw','LXNa','7T4FgTwhiC','J8Ma3M7HXL','6','1994-11-26','btfbWhL7VW','2000','APi952myMF','2000','FQgBCJlZiki','Ve27pYukdD','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:10:15'),(13,'Lingat','Mary Jane','Pedragoza','1','Hu','21pX','MkUfza6iYP','qDOIqX8jdf','1','1994-11-26','3lyuzb3xvB','2015','a0iz1Vq5rE','2015','FSSdiBMxmDq','8ZISgtq8fH','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:10:33'),(14,'Isip','Edward','Angeles','1','nn','XDAF','HL4jU6ElaP','MZ6C57HpiU','8','1994-11-26','RXZqQRKBUO','2005','jc2dPpxO0R','1990','8wzYgrLGZFq','68c8L7VYTA','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:11:25'),(15,'Federico','Nina','None','1','kJ','lgRR','zChS1g2Ig0','6a2VpKPICQ','3','1994-11-26','p9WN981pnz','2001','0DvjF5ZCgp','1998','IfEwZbpjSMc','ieseqW2whg','Single','Male','Elementary','Rented',NULL,NULL,'2017-02-16 10:11:39'),(16,'eE15flMGlk','zvRO8bQwGc','g5AzPazlLd','1','Do','cagd','xva4fIWtGn','FYWdoSicaN','7','1994-11-26','EoLGyQMmBV','2012','9jHJvSapHr','1996','qyd5bmziMGh','kjMj4fcpAQ','Single','Male','Elementary','Rented',NULL,NULL,NULL),(17,'MF4LQCGowK','QZa7lnNH4E','Bt8kVgz7PR','1','im','KWi6','GikqznD5oE','R4icx2rrW2','1','1994-11-26','FGQteOnQG9','2004','xlj7jxTnf1','2002','DDcooF6V2q6','zDrlKkdl5h','Single','Male','Elementary','Rented',NULL,NULL,NULL),(18,'StDmutlbmE','otITiCePF2','dRDsb1luxJ','1','DO','Arwm','bkk1ofcL7h','R5L2pNCHtE','6','1994-11-26','Csa63ozw0X','1990','2POn8VWM9H','2013','py16L3LVDyR','gF54nZYweq','Single','Male','Elementary','Rented',NULL,NULL,NULL),(19,'FhlI0XWMdl','gwLRmCu7Uw','lXJKqzQfoS','1','va','PZUX','lKjJMASkmp','IsMzJQcDf1','10','1994-11-26','Y90rWewX2d','2012','fBu0Y2rxeG','2015','FpOoMIrxahk','4MWwP3QtaA','Single','Male','Elementary','Rented',NULL,NULL,NULL),(20,'I9d21Yezez','1ffkBzxCzx','mXtlbWcAoy','1','JO','NBxl','9XOnVHxvVO','mOndoJvFEI','8','1994-11-26','6g6WesQp93','2006','kMTgl4ToD0','1993','7seLHQsuuTr','YPcC8NmuNh','Single','Male','Elementary','Rented',NULL,NULL,NULL),(21,'8qjRK3KzdH','TwTOuanoTV','I05IKI52Lm','1','3s','T2RO','oHIOunwKfH','wgA8x4RK4l','5','1994-11-26','x65Yz4eqHC','2004','ASK2qmKn4U','2012','erUlD1folWx','5FjP0dSUEJ','Single','Male','Elementary','Rented',NULL,NULL,NULL),(22,'bGct4m6YIJ','HpUiSQKXZm','7bdFkDngRL','1','Cg','g0AI','z7P4vlgFD6','yr0wKnT5Pu','7','1994-11-26','HoiK6gS6Gq','2002','fS5lex2g8r','2012','KpcO9LyLP4a','HyPjV2rxqJ','Single','Male','Elementary','Rented',NULL,NULL,NULL),(23,'bcm7D3bsjF','ORR3KTCdvu','ASFcvOQEyT','1','VS','jONt','BBXHMH5SVJ','oR1zZEQD8U','0','1994-11-26','kGwNYl23Cg','1997','VUX822NYJY','2005','D1eq9aPAWi2','j4EWRtAzPa','Single','Male','Elementary','Rented',NULL,NULL,NULL),(24,'9fFxsLzCJZ','cSdEXpIvuo','gogNar4x2z','1','zO','nuTE','OXCffkwPXg','lJRi3ScCIk','3','1994-11-26','JUJaBeEPjC','1990','ULvvfLd9k1','1997','cneOElQQmMW','gduiHLQqWO','Single','Male','Elementary','Rented',NULL,NULL,NULL),(25,'L7lnJtu13u','j3ufiJg4sh','1cUe2Qnkz4','1','a2','y2Hz','8vEYZRSepd','hI2JjGvncY','5','1994-11-26','oR9isxr4QX','1995','MQK4UeXHUm','1997','2hA2gDS3cdx','XuRUq9wMCO','Single','Male','Elementary','Rented',NULL,NULL,NULL),(26,'B1i80tEwSU','BXEZjQ5YpX','5COOjyz43b','1','7B','lEIb','iPBzDBloo3','NccaXRAbIU','2','1994-11-26','AuwcCGCJTD','1993','vO8lywndcF','1996','7xyxR52YTSg','Vlh4zQypT6','Single','Male','Elementary','Rented',NULL,NULL,NULL),(27,'oyhufIDuRu','kdZcx8vJSv','lHnrKuD8sA','1','6Q','In8C','H4gsWkUvss','dNbKLgBEgz','10','1994-11-26','uSZADPK7jv','1990','IHQbFOIQIt','2001','5yUgBXcwJ8Q','XVmTmbVdl9','Single','Male','Elementary','Rented',NULL,NULL,NULL),(28,'KmC5JVqqH0','Mjlf9Pkq70','EdwXcvZHrU','1','AO','N5yX','SjcBnXrVET','XG63aAqphi','4','1994-11-26','JNEh9uwTNs','1997','JNa24Ox6it','2015','C8nA5M8b3PY','2RnFSIx2LL','Single','Male','Elementary','Rented',NULL,NULL,NULL),(29,'o1JthxD0HV','aOjms5u0Kv','zbj0XURgiu','1','bw','883x','hMoyqx1yeK','JJzmTvFuqc','4','1994-11-26','bKcJBLSauB','2012','AOMvmsacuR','1991','P3exqjxZ132','5yEuGJ59ny','Single','Male','Elementary','Rented',NULL,NULL,NULL),(30,'BcxCvrr6c8','U56buYq3ZY','vaDddplySp','1','at','R9KM','tA7G2o6uXM','76tCRse5r7','4','1994-11-26','S8qLayeIzk','1998','iI40XwapXT','1996','Rg0bBmdI37C','wcurvjx2zC','Single','Male','Elementary','Rented',NULL,NULL,NULL),(31,'myY0oNzJcP','kthOyF63JF','Pno7yfRlyE','1','JA','Ar4x','tQc7kcFKMs','x2tm8GwFK4','10','1994-11-26','SU8cu14pir','1998','DLDA05MUHS','2009','5MTkX9Op6oK','M3Xa29UyOP','Single','Male','Elementary','Rented',NULL,NULL,NULL),(32,'A1LosurShi','E6QLmmwzmm','0Th0Opghnx','1','bX','RWYC','exMdpls6uq','JujmThTGc0','3','1994-11-26','CivWwwPFCW','2007','h8xlj0SBuE','2000','f9MttG3M3sK','1xSUo5K9Mb','Single','Male','Elementary','Rented',NULL,NULL,NULL),(33,'qwFIV6CxTL','gvI5J9SMAR','uY4bJqFOYX','1','F0','BjgS','JW6rDdZsjh','ZXglw9qsZd','4','1994-11-26','ia38cugeaX','2007','Bl4l4XtLea','2001','NcJiIp8l3nu','wDAS21A8Aj','Single','Male','Elementary','Rented',NULL,NULL,NULL),(34,'WMkBb6069v','huA5qUfgPL','BL0Qwm74Ti','1','kb','j9Cl','K196MewyNH','MHRhVGcULE','6','1994-11-26','zImYyDDaNo','1996','8hv6KPNZbU','1994','jX994Zr16KD','CtMBZ0zZLi','Single','Male','Elementary','Rented',NULL,NULL,NULL),(35,'VweeokP1TA','dJ3S8yqVzB','Z0fQsmMPSH','1','vA','4zcb','k0ktCE65XD','9i8QxZaMWM','1','1994-11-26','Zzg0lRicAq','2001','RqC9yKPVA4','2009','7SiEm3CFYnU','r0nVldF8FK','Single','Male','Elementary','Rented',NULL,NULL,NULL),(36,'tJBYl5c50o','M6fPcCgclv','rkHc6Xeklq','1','fY','2TtI','84b5EXW2b7','lFte3h7IKY','3','1994-11-26','iMDGr1L8ZS','2001','8lu4EfK9fY','2013','mZFZX1Pdeej','B6fLlVpxuG','Single','Male','Elementary','Rented',NULL,NULL,NULL),(37,'R4c2CN7GFU','5gHtVZDzX6','lGz4ytb5Bc','1','KD','9CeM','Iw7XnNZV18','q4PoX8LIwF','9','1994-11-26','m0fhcrJeYo','2013','HHBxjRseWj','2006','0xNEjlHBlSZ','LTSEC6wt8X','Single','Male','Elementary','Rented',NULL,NULL,NULL),(38,'2hXC3by24w','i4hCCZvR4B','NqpA7C9rvH','1','Ye','tICt','bfV92b4hXv','8rxQmeLT6O','10','1994-11-26','AIdILS0zDI','1993','hxweDxZCrd','1996','oQNYbwhuUjo','ldvyWHZi57','Single','Male','Elementary','Rented',NULL,NULL,NULL),(39,'clAlqJxorf','WtzNJ5DcdZ','p05jMTzide','1','Zg','8ojr','hCJjfhNdmZ','RrqbacYvps','9','1994-11-26','wAHZe7n8tW','2005','PwkkHyyiSp','2008','P8oN7TJThDJ','o2XWMLg6gV','Single','Male','Elementary','Rented',NULL,NULL,NULL),(40,'YJSpSASO5O','CjgcZfwM5M','kZn1EsKgou','1','tM','y3S9','RSyXd0P51Z','cPno9qXv4g','7','1994-11-26','Hf4AwgbPRD','2011','0UY3TrF6Vx','2006','YQaSNA51dLt','kb8dEaZglR','Single','Male','Elementary','Rented',NULL,NULL,NULL),(41,'W3gzJLWd5I','REsG81BW0j','zbVlE3Rdwj','1','B6','0wp3','VsS2qrJJyE','tUtCgL8pfU','10','1994-11-26','4QG7zFGjWM','2010','Gdbvc7ixaB','2014','SGtwfrYm5Jw','nMYn0OMAIW','Single','Male','Elementary','Rented',NULL,NULL,NULL),(42,'MIIa2PxdCc','6AtBbSUUii','JmqVbAZuSE','1','sR','BZwd','JElDWlLFJd','RUdj2E167l','9','1994-11-26','UR8MYxlmoL','1997','FM6rU4AAdI','2009','AchJs3Znrls','ugIhmBm2Eq','Single','Male','Elementary','Rented',NULL,NULL,NULL),(43,'3yt2JA08PZ','N8HIr1JZD4','VSiMZ80UoQ','1','ri','DlGC','v8Y2oeooaD','VaVT5TvASg','4','1994-11-26','XhsVHXGCAh','1991','77EsuxVgE4','2013','ZY5CVkR947x','7tBBvc3i2X','Single','Male','Elementary','Rented',NULL,NULL,NULL),(44,'2MIlm9LVnm','vl0UgmBNJj','rEomb4caXm','1','Be','gzr1','PUhRJGZgIN','UsFuzMCcjP','6','1994-11-26','eKW4F1vb1P','1990','kV09URkgiX','2013','MIFY2q2nqAu','sRay9KrjQQ','Single','Male','Elementary','Rented',NULL,NULL,NULL),(45,'66MLYbLCD2','NBcMqU6nV8','HJET9gccsD','1','BL','u1cY','DubacHbUHX','QQGnduRVTj','10','1994-11-26','KNcMXxygUA','2006','9p4m5Qx90b','2004','RVVzFlM5ahF','Ds3xoYMHvQ','Single','Male','Elementary','Rented',NULL,NULL,NULL),(46,'ODNhgnSy71','XIKpToO7rt','KTSxCbnnlI','1','6p','IIDf','ecou6TVbKW','G4yX5FPm55','4','1994-11-26','59dyJROKAX','2014','aYRWgZxXXG','2013','H12pOhnUhZW','31T4r9VssR','Single','Male','Elementary','Rented',NULL,NULL,NULL),(47,'88kT9hNbgI','INLa43PgCQ','mLVK1Nj1ac','1','BA','TbAb','jQyRjc0dgc','eisEW5wKc5','9','1994-11-26','j83t4JGw8M','1992','WmnLfQO82x','2003','YrbiuQwoTnF','0s9977OS9i','Single','Male','Elementary','Rented',NULL,NULL,NULL),(48,'ZJY68qXUxF','ZrlIjTzpy2','501334ndoc','1','9y','2xDn','CfgYH9k12W','JwBVMQvKeh','3','1994-11-26','znGPbQXw0U','2000','yqdiUNZnTi','2014','SOBXOWmZa8m','CZ3XLgrLRg','Single','Male','Elementary','Rented',NULL,NULL,NULL),(49,'jqejiaYk1Q','DOZsJoG4O9','CDucpMORxE','1','Jn','4aSe','s8fdMnKTYs','AJw24gyRc1','0','1994-11-26','gVfi0DeZQG','2006','ttuTHfmmhW','2010','Q4rpECcljk9','wLAp2Xhh32','Single','Male','Elementary','Rented',NULL,NULL,NULL),(50,'OyiFHHbJXS','mGHFa8J7ky','DYnECtB3Bc','1','B8','ycIQ','a5GfKlJfN4','92bylt2194','10','1994-11-26','DBMwTKhS1M','1998','jTNsEAGMHN','2013','nO2BnltQTj0','1s5X9cky3T','Single','Male','Elementary','Rented',NULL,NULL,NULL),(51,'coLv3x6WUk','eCTANPq8yv','5Et0JcAmdR','1','Ue','myuK','PsHSNEa85P','fd3NAVVf0k','7','1994-11-26','gxm3vXisFL','2014','0fuPDBXqse','2012','fLOuuxkfUaz','Xa0Dtk4iTv','Single','Male','Elementary','Rented',NULL,NULL,NULL),(52,'qdFuNOwZwn','LKUWZXWo4O','dIcVdikvoa','1','Qu','xfhI','QRbSbQcSLC','62N1H4piYh','2','1994-11-26','lNqQwfYdnI','1992','7FW29F4JkM','2016','HiQUhAtB0gY','E9eq6t3ytN','Single','Male','Elementary','Rented',NULL,NULL,NULL),(53,'pZnPXDwIO4','ZdnrtQmavk','D0TCHFFUFN','1','WH','LsBD','8zDHSfjnJp','98pjuM0uAf','6','1994-11-26','MZtsLihzJX','1991','7t23X2RAAj','2011','KFWeOW5pEZW','4gNnnRp0ZB','Single','Male','Elementary','Rented',NULL,NULL,NULL),(54,'NQVPruvGIw','Shwl3gjwOM','yIvLQmCnIS','1','Xi','opRI','pNNYcSVpQL','XCFXpU1tAV','7','1994-11-26','MpV8nmUEBK','2008','jxMDMDejnM','1991','60b2uU3JLVR','Ggqk3oVg7y','Single','Male','Elementary','Rented',NULL,NULL,NULL),(55,'PMO8K9RKuw','iMAuHVo7PU','sZukyP6QaK','1','9c','1TAE','EFGsC0FA3P','E5xzwtXMYy','0','1994-11-26','IbzSFfkK8n','2011','xB05NN3NWG','1993','XEqjQmOkE3O','PoKtz18PUd','Single','Male','Elementary','Rented',NULL,NULL,NULL);

/*Table structure for table `cluster_members` */

DROP TABLE IF EXISTS `cluster_members`;

CREATE TABLE `cluster_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cluster_id` int(10) unsigned DEFAULT NULL,
  `client_id` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cluster_members` */

insert  into `cluster_members`(`id`,`cluster_id`,`client_id`,`deleted_at`,`created_at`,`updated_at`) values (1,1,1,NULL,'2017-01-12 13:20:39','2017-01-12 13:20:39'),(2,1,2,NULL,'2017-01-12 13:20:39','2017-01-12 13:20:39'),(3,1,3,NULL,'2017-01-12 13:20:39','2017-01-12 13:20:39'),(4,1,4,NULL,'2017-01-12 13:20:39','2017-01-12 13:20:39'),(5,2,20,'2017-02-16 10:04:35','2017-02-03 13:51:50','2017-02-16 10:04:35'),(6,2,21,'2017-02-16 10:04:39','2017-02-03 13:51:50','2017-02-16 10:04:39'),(7,2,22,'2017-02-16 10:04:41','2017-02-03 13:51:51','2017-02-16 10:04:41'),(8,2,23,'2017-02-16 10:04:43','2017-02-03 13:51:51','2017-02-16 10:04:43'),(9,2,24,'2017-02-16 10:04:44','2017-02-03 13:51:51','2017-02-16 10:04:44'),(10,2,25,'2017-02-16 10:04:45','2017-02-03 13:51:51','2017-02-16 10:04:45'),(11,2,53,'2017-02-16 10:04:47','2017-02-03 13:51:51','2017-02-16 10:04:47'),(12,2,54,'2017-02-16 10:04:48','2017-02-03 13:51:51','2017-02-16 10:04:48'),(13,2,55,'2017-02-16 10:04:49','2017-02-03 13:51:51','2017-02-16 10:04:49'),(14,2,39,'2017-02-16 10:04:51','2017-02-03 13:52:18','2017-02-16 10:04:51'),(15,2,40,'2017-02-16 10:04:52','2017-02-03 13:52:18','2017-02-16 10:04:52'),(16,2,41,'2017-02-16 10:04:55','2017-02-03 13:52:18','2017-02-16 10:04:55'),(17,2,42,'2017-02-16 10:04:56','2017-02-03 13:52:18','2017-02-16 10:04:56'),(18,2,44,'2017-02-16 10:05:01','2017-02-03 13:52:18','2017-02-16 10:05:01'),(19,2,45,'2017-02-16 10:05:18','2017-02-03 13:52:18','2017-02-16 10:05:18'),(20,2,46,'2017-02-16 10:05:22','2017-02-03 13:52:18','2017-02-16 10:05:22'),(21,2,49,'2017-02-16 10:05:25','2017-02-03 13:52:18','2017-02-16 10:05:25');

/*Table structure for table `clusters` */

DROP TABLE IF EXISTS `clusters`;

CREATE TABLE `clusters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `branch_id` int(10) unsigned NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pa_lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pa_firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clusters_code_unique` (`code`),
  KEY `clusters_branch_id_index` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `clusters` */

insert  into `clusters`(`id`,`code`,`branch_id`,`region`,`pa_lastname`,`pa_firstname`,`deleted_at`,`created_at`,`updated_at`) values (1,'OLO-11234',1,NULL,'Gates','Bill',NULL,'2017-01-12 13:20:20','2017-01-12 13:20:20'),(2,'PAMP-11234',2,NULL,'Jing','Tiang',NULL,'2017-02-03 13:51:32','2017-02-03 13:51:32');

/*Table structure for table `collections` */

DROP TABLE IF EXISTS `collections`;

CREATE TABLE `collections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amortization_id` int(10) unsigned NOT NULL,
  `principal` int(10) unsigned NOT NULL,
  `interest` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `collections` */

/*Table structure for table `credit_limit` */

DROP TABLE IF EXISTS `credit_limit`;

CREATE TABLE `credit_limit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned DEFAULT NULL,
  `co_maker_inside_cluster_id` int(10) unsigned DEFAULT NULL,
  `co_maker_outside_cluster_id` int(10) unsigned DEFAULT NULL,
  `business_net_disposable_income` bigint(20) DEFAULT NULL,
  `household_income` bigint(20) DEFAULT NULL,
  `household_expense` bigint(20) DEFAULT NULL,
  `financial_risk_assessment` bigint(20) DEFAULT NULL,
  `credit_limit` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `credit_limit` */

insert  into `credit_limit`(`id`,`client_id`,`co_maker_inside_cluster_id`,`co_maker_outside_cluster_id`,`business_net_disposable_income`,`household_income`,`household_expense`,`financial_risk_assessment`,`credit_limit`,`created_at`,`updated_at`,`deleted_at`) values (1,1,5,43,25000,1000,8000,2000,NULL,'2017-01-26 08:26:24','2017-01-26 08:26:59',NULL);

/*Table structure for table `disbursement` */

DROP TABLE IF EXISTS `disbursement`;

CREATE TABLE `disbursement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cluster_id` int(10) unsigned DEFAULT NULL,
  `cv_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payee_id` int(10) unsigned DEFAULT NULL,
  `loan_amount` bigint(20) unsigned DEFAULT NULL,
  `check_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `release_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_finished` tinyint(1) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_collection_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_collection_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maturity_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `disbursement` */

insert  into `disbursement`(`id`,`cluster_id`,`cv_number`,`payee_id`,`loan_amount`,`check_number`,`release_date`,`is_finished`,`status`,`first_collection_date`,`last_collection_date`,`maturity_date`,`created_at`,`updated_at`,`deleted_at`) values (1,1,'Cv-12312412312321',1,336000,'1111-2222-3333-4444-5555-6666-7777-8888-9999','2017-02-14',0,'on-going','2017-02-14','2017-08-01','2017-08-01','2017-02-16 09:20:28','2017-02-16 09:20:28',NULL);

/*Table structure for table `loan_summaries` */

DROP TABLE IF EXISTS `loan_summaries`;

CREATE TABLE `loan_summaries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `disbursement_id` int(10) unsigned DEFAULT NULL,
  `client_id` int(10) unsigned DEFAULT NULL,
  `loan_amount` int(10) unsigned DEFAULT NULL,
  `loan_term` int(10) unsigned DEFAULT NULL,
  `cbu_new` int(10) unsigned DEFAULT NULL,
  `cbu_reloan` int(10) unsigned DEFAULT NULL,
  `processing_fee` int(10) unsigned DEFAULT NULL,
  `doc_stamp_tax` int(10) unsigned DEFAULT NULL,
  `mi_premium` int(10) unsigned DEFAULT NULL,
  `cli_premium` int(10) unsigned DEFAULT NULL,
  `total_pre_deductions` int(10) unsigned DEFAULT NULL,
  `total_loan_amount` int(10) unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_payed` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `loan_summaries` */

insert  into `loan_summaries`(`id`,`disbursement_id`,`client_id`,`loan_amount`,`loan_term`,`cbu_new`,`cbu_reloan`,`processing_fee`,`doc_stamp_tax`,`mi_premium`,`cli_premium`,`total_pre_deductions`,`total_loan_amount`,`status`,`is_payed`,`deleted_at`,`created_at`,`updated_at`) values (1,1,1,97000,6,0,0,1455,0,0,0,0,0,'on-going',0,NULL,'2017-01-26 08:52:57','2017-01-26 08:52:57'),(2,1,2,6000,6,0,0,90,0,0,0,0,0,'on-going',0,NULL,'2017-01-26 08:52:57','2017-01-26 08:52:57'),(3,1,3,80000,6,0,0,1200,0,0,0,0,0,'on-going',0,NULL,'2017-01-26 08:52:57','2017-01-26 08:52:57'),(4,1,4,45000,6,0,0,675,0,0,0,0,0,'on-going',0,NULL,'2017-01-26 08:52:57','2017-01-26 08:52:57'),(5,1,1,99000,6,0,0,1485,0,0,0,0,0,'on-going',0,NULL,'2017-02-16 09:20:28','2017-02-16 09:20:28'),(6,1,2,89000,6,0,0,1335,0,0,0,0,0,'on-going',0,NULL,'2017-02-16 09:20:28','2017-02-16 09:20:28'),(7,1,3,79000,6,0,0,1185,0,0,0,0,0,'on-going',0,NULL,'2017-02-16 09:20:28','2017-02-16 09:20:28'),(8,1,4,69000,6,0,0,1035,0,0,0,0,0,'on-going',0,NULL,'2017-02-16 09:20:28','2017-02-16 09:20:28');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (20,'2014_10_12_000000_create_users_table',1),(21,'2014_10_12_100000_create_password_resets_table',1),(22,'2016_11_28_014426_create_clients_info_table',1),(42,'2016_11_29_010956_create_cluster_migration',2),(49,'2016_11_29_012620_create_branches',3),(50,'2016_12_05_022959_create_products-table',3),(52,'2017_01_11_143121_create-loan-table',3),(66,'2017_01_05_113200_create-disbursement-table',4),(67,'2017_01_16_145946_create-amortization',4),(68,'2017_01_23_141124_create-collection-table',4),(73,'2017_02_03_111336_create_payments_table',5),(74,'2017_02_09_025231_create_cbu_and_past_due_table',5);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `past_dues` */

DROP TABLE IF EXISTS `past_dues`;

CREATE TABLE `past_dues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amort_id` int(11) NOT NULL,
  `disbursement_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `principal` int(11) NOT NULL,
  `interest` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `week_to_be_paid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `to_be_collected_on` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `past_dues` */

insert  into `past_dues`(`id`,`amort_id`,`disbursement_id`,`client_id`,`principal`,`interest`,`total_amount`,`week_to_be_paid`,`to_be_collected_on`) values (1,2,1,1,626,242,868,'2','2017-02-21'),(2,27,1,2,0,0,0,'2','2017-02-21'),(3,52,1,3,0,0,0,'2','2017-02-21'),(4,77,1,4,0,0,0,'2','2017-02-21'),(5,3,1,1,0,0,0,'3','2017-02-28'),(6,28,1,2,0,0,0,'3','2017-02-28'),(7,53,1,3,0,0,0,'3','2017-02-28'),(8,78,1,4,0,0,0,'3','2017-02-28');

/*Table structure for table `payment_informations` */

DROP TABLE IF EXISTS `payment_informations`;

CREATE TABLE `payment_informations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_summary_id` int(10) unsigned DEFAULT NULL,
  `amort_id` int(10) unsigned DEFAULT NULL,
  `amount_paid` int(10) unsigned DEFAULT NULL,
  `principal_paid` int(10) unsigned DEFAULT NULL,
  `interest_paid` int(10) unsigned DEFAULT NULL,
  `this_week_balance` int(10) unsigned DEFAULT NULL,
  `week_interest_balance` int(10) unsigned DEFAULT NULL,
  `week_principal_balance` int(10) unsigned DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `payment_informations` */

insert  into `payment_informations`(`id`,`payment_summary_id`,`amort_id`,`amount_paid`,`principal_paid`,`interest_paid`,`this_week_balance`,`week_interest_balance`,`week_principal_balance`,`payment_type`) values (1,1,2,4000,3755,1113,868,242,626,'cash'),(2,1,27,4376,3158,1218,0,0,0,'cash'),(3,1,52,3884,2803,1081,0,0,0,'cash'),(4,1,77,3393,2449,944,0,0,0,'cash'),(5,2,3,5736,4187,1549,0,0,0,'cash'),(6,2,28,4376,3201,1175,0,0,0,'cash'),(7,2,53,3884,2841,1043,0,0,0,'cash'),(8,2,78,3393,2482,911,0,0,0,'cash');

/*Table structure for table `payment_summaries` */

DROP TABLE IF EXISTS `payment_summaries`;

CREATE TABLE `payment_summaries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `disbursement_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `collection_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `this_week_due` int(10) unsigned DEFAULT NULL,
  `this_week_total_amount_due` int(10) unsigned DEFAULT NULL,
  `last_week_past_due` int(10) unsigned DEFAULT NULL,
  `amount_paid` int(10) unsigned DEFAULT NULL,
  `principal_not_collected` int(10) unsigned DEFAULT NULL,
  `interest_not_collected` int(10) unsigned DEFAULT NULL,
  `uploader_id` int(10) unsigned DEFAULT NULL,
  `isFullyPaid` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `payment_summaries` */

insert  into `payment_summaries`(`id`,`disbursement_id`,`collection_date`,`this_week_due`,`this_week_total_amount_due`,`last_week_past_due`,`amount_paid`,`principal_not_collected`,`interest_not_collected`,`uploader_id`,`isFullyPaid`,`created_at`,`updated_at`) values (1,'1','2017-02-14',16521,16521,0,15653,626,242,1,0,'2017-02-16 09:27:14','2017-02-16 09:27:14'),(2,'1','2017-02-21',16521,17389,868,17389,0,0,1,1,'2017-02-16 09:28:28','2017-02-16 09:28:28');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interest_rate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `min` bigint(20) DEFAULT NULL,
  `max` bigint(20) DEFAULT NULL,
  `loan_term` bigint(20) DEFAULT NULL,
  `weeks_to_pay` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `weekly_compounding_rate` decimal(20,6) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `products` */

insert  into `products`(`id`,`name`,`interest_rate`,`min`,`max`,`loan_term`,`weeks_to_pay`,`created_at`,`updated_at`,`deleted_at`,`weekly_compounding_rate`) values (1,'MPL','0.03',2000,99000,6,24,NULL,NULL,NULL,'0.013688');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

/*Table structure for table `weekly_amortization` */

DROP TABLE IF EXISTS `weekly_amortization`;

CREATE TABLE `weekly_amortization` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `disbursement_id` int(10) unsigned DEFAULT NULL,
  `client_id` int(10) unsigned DEFAULT NULL,
  `week` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `principal_this_week` int(10) unsigned DEFAULT NULL,
  `interest_this_week` int(10) unsigned DEFAULT NULL,
  `principal_with_interest` int(10) unsigned DEFAULT NULL,
  `principal_balance` int(10) unsigned DEFAULT NULL,
  `interest_balance` int(10) unsigned DEFAULT NULL,
  `collection_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `weekly_amortization` */

insert  into `weekly_amortization`(`id`,`disbursement_id`,`client_id`,`week`,`principal_this_week`,`interest_this_week`,`principal_with_interest`,`principal_balance`,`interest_balance`,`collection_date`) values (1,1,1,'0',0,0,0,99000,17820,NULL),(2,1,1,'1',3513,1355,4868,95487,16465,'2017-02-14'),(3,1,1,'2',3561,1307,4868,91926,15158,'2017-02-21'),(4,1,1,'3',3610,1258,4868,88316,13900,'2017-02-28'),(5,1,1,'4',3659,1209,4868,84657,12691,'2017-03-07'),(6,1,1,'5',3709,1159,4868,80948,11532,'2017-03-14'),(7,1,1,'6',3760,1108,4868,77188,10424,'2017-03-21'),(8,1,1,'7',3811,1057,4868,73377,9367,'2017-03-28'),(9,1,1,'8',3864,1004,4868,69513,8363,'2017-04-04'),(10,1,1,'9',3917,951,4868,65596,7412,'2017-04-11'),(11,1,1,'10',3970,898,4868,61626,6514,'2017-04-18'),(12,1,1,'11',4024,844,4868,57602,5670,'2017-04-25'),(13,1,1,'12',4080,788,4868,53522,4882,'2017-05-02'),(14,1,1,'13',4135,733,4868,49387,4149,'2017-05-09'),(15,1,1,'14',4192,676,4868,45195,3473,'2017-05-16'),(16,1,1,'15',4249,619,4868,40946,2854,'2017-05-23'),(17,1,1,'16',4308,560,4868,36638,2294,'2017-05-30'),(18,1,1,'17',4366,502,4868,32272,1792,'2017-06-06'),(19,1,1,'18',4426,442,4868,27846,1350,'2017-06-13'),(20,1,1,'19',4487,381,4868,23359,969,'2017-06-20'),(21,1,1,'20',4548,320,4868,18811,649,'2017-06-27'),(22,1,1,'21',4611,257,4868,14200,392,'2017-07-04'),(23,1,1,'22',4674,194,4868,9526,198,'2017-07-11'),(24,1,1,'23',4738,130,4868,4788,68,'2017-07-18'),(25,1,1,'24',4788,68,4856,0,0,'2017-07-25'),(26,1,2,'0',0,0,0,89000,16020,NULL),(27,1,2,'1',3158,1218,4376,85842,14802,'2017-02-14'),(28,1,2,'2',3201,1175,4376,82641,13627,'2017-02-21'),(29,1,2,'3',3245,1131,4376,79396,12496,'2017-02-28'),(30,1,2,'4',3289,1087,4376,76107,11409,'2017-03-07'),(31,1,2,'5',3334,1042,4376,72773,10367,'2017-03-14'),(32,1,2,'6',3380,996,4376,69393,9371,'2017-03-21'),(33,1,2,'7',3426,950,4376,65967,8421,'2017-03-28'),(34,1,2,'8',3473,903,4376,62494,7518,'2017-04-04'),(35,1,2,'9',3521,855,4376,58973,6663,'2017-04-11'),(36,1,2,'10',3569,807,4376,55404,5856,'2017-04-18'),(37,1,2,'11',3618,758,4376,51786,5098,'2017-04-25'),(38,1,2,'12',3667,709,4376,48119,4389,'2017-05-02'),(39,1,2,'13',3717,659,4376,44402,3730,'2017-05-09'),(40,1,2,'14',3768,608,4376,40634,3122,'2017-05-16'),(41,1,2,'15',3820,556,4376,36814,2566,'2017-05-23'),(42,1,2,'16',3872,504,4376,32942,2062,'2017-05-30'),(43,1,2,'17',3925,451,4376,29017,1611,'2017-06-06'),(44,1,2,'18',3979,397,4376,25038,1214,'2017-06-13'),(45,1,2,'19',4033,343,4376,21005,871,'2017-06-20'),(46,1,2,'20',4088,288,4376,16917,583,'2017-06-27'),(47,1,2,'21',4144,232,4376,12773,351,'2017-07-04'),(48,1,2,'22',4201,175,4376,8572,176,'2017-07-11'),(49,1,2,'23',4259,117,4376,4313,59,'2017-07-18'),(50,1,2,'24',4313,59,4372,0,0,'2017-07-25'),(51,1,3,'0',0,0,0,79000,14220,NULL),(52,1,3,'1',2803,1081,3884,76197,13139,'2017-02-14'),(53,1,3,'2',2841,1043,3884,73356,12096,'2017-02-21'),(54,1,3,'3',2880,1004,3884,70476,11092,'2017-02-28'),(55,1,3,'4',2919,965,3884,67557,10127,'2017-03-07'),(56,1,3,'5',2959,925,3884,64598,9202,'2017-03-14'),(57,1,3,'6',3000,884,3884,61598,8318,'2017-03-21'),(58,1,3,'7',3041,843,3884,58557,7475,'2017-03-28'),(59,1,3,'8',3082,802,3884,55475,6673,'2017-04-04'),(60,1,3,'9',3125,759,3884,52350,5914,'2017-04-11'),(61,1,3,'10',3167,717,3884,49183,5197,'2017-04-18'),(62,1,3,'11',3211,673,3884,45972,4524,'2017-04-25'),(63,1,3,'12',3255,629,3884,42717,3895,'2017-05-02'),(64,1,3,'13',3299,585,3884,39418,3310,'2017-05-09'),(65,1,3,'14',3344,540,3884,36074,2770,'2017-05-16'),(66,1,3,'15',3390,494,3884,32684,2276,'2017-05-23'),(67,1,3,'16',3437,447,3884,29247,1829,'2017-05-30'),(68,1,3,'17',3484,400,3884,25763,1429,'2017-06-06'),(69,1,3,'18',3531,353,3884,22232,1076,'2017-06-13'),(70,1,3,'19',3580,304,3884,18652,772,'2017-06-20'),(71,1,3,'20',3629,255,3884,15023,517,'2017-06-27'),(72,1,3,'21',3678,206,3884,11345,311,'2017-07-04'),(73,1,3,'22',3729,155,3884,7616,156,'2017-07-11'),(74,1,3,'23',3780,104,3884,3836,52,'2017-07-18'),(75,1,3,'24',3836,52,3888,0,0,'2017-07-25'),(76,1,4,'0',0,0,0,69000,12420,NULL),(77,1,4,'1',2449,944,3393,66551,11476,'2017-02-14'),(78,1,4,'2',2482,911,3393,64069,10565,'2017-02-21'),(79,1,4,'3',2516,877,3393,61553,9688,'2017-02-28'),(80,1,4,'4',2550,843,3393,59003,8845,'2017-03-07'),(81,1,4,'5',2585,808,3393,56418,8037,'2017-03-14'),(82,1,4,'6',2621,772,3393,53797,7265,'2017-03-21'),(83,1,4,'7',2657,736,3393,51140,6529,'2017-03-28'),(84,1,4,'8',2693,700,3393,48447,5829,'2017-04-04'),(85,1,4,'9',2730,663,3393,45717,5166,'2017-04-11'),(86,1,4,'10',2767,626,3393,42950,4540,'2017-04-18'),(87,1,4,'11',2805,588,3393,40145,3952,'2017-04-25'),(88,1,4,'12',2843,550,3393,37302,3402,'2017-05-02'),(89,1,4,'13',2882,511,3393,34420,2891,'2017-05-09'),(90,1,4,'14',2922,471,3393,31498,2420,'2017-05-16'),(91,1,4,'15',2962,431,3393,28536,1989,'2017-05-23'),(92,1,4,'16',3002,391,3393,25534,1598,'2017-05-30'),(93,1,4,'17',3043,350,3393,22491,1248,'2017-06-06'),(94,1,4,'18',3085,308,3393,19406,940,'2017-06-13'),(95,1,4,'19',3127,266,3393,16279,674,'2017-06-20'),(96,1,4,'20',3170,223,3393,13109,451,'2017-06-27'),(97,1,4,'21',3214,179,3393,9895,272,'2017-07-04'),(98,1,4,'22',3258,135,3393,6637,137,'2017-07-11'),(99,1,4,'23',3302,91,3393,3335,46,'2017-07-18'),(100,1,4,'24',3335,46,3381,0,0,'2017-07-25');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
