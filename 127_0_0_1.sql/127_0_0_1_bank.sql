
USE `db109`;

CREATE TABLE `account` (`accountId` int(10) UNSIGNED NOT NULL,`firstName` varchar(64) NOT NULL,`lastName` varchar(256) NOT NULL,`accountNumber` int(10) UNSIGNED NOT NULL,`balance` double NOT NULL DEFAULT 0,`password` varchar(50) NOT NULL);

CREATE TABLE `transactions` (`transactionId` int(11) NOT NULL,`accountNumber` int(11) NOT NULL,`date` timestamp NOT NULL DEFAULT current_timestamp(),`amount` double NOT NULL) ;


ALTER TABLE `account`ADD PRIMARY KEY (`accountId`),ADD UNIQUE KEY `accountNumber` (`accountNumber`);

ALTER TABLE `transactions`ADD PRIMARY KEY (`transactionId`);


ALTER TABLE `account`MODIFY `accountId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `transactions`MODIFY `transactionId` int(11) NOT NULL AUTO_INCREMENT;
