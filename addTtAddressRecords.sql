INSERT INTO `tx_ecomnewslettersubscription_domain_model_subscription` (`tstamp`,`crdate`,`hidden`,`deleted`,`name`,`gender`,`first_name`,`middle_name`,`last_name`,`birthday`,`title`,`email`,`phone`,`fax`,`mobile`,`www`,`address`,`building`,`room`,`company`,`city`,`zip`,`description`)
SELECT `tstamp`,`tstamp`,`hidden`,`deleted`,`name`,`gender`,`first_name`,`middle_name`,`last_name`,`birthday`,`title`,`email`,`phone`,`fax`,`mobile`,`www`,`address`,`building`,`room`,`company`,`city`,`zip`,`description` FROM `tt_address`