#
# Table structure for table 'tx_ecomnewslettersubscription_domain_model_subscription'
#
CREATE TABLE tx_ecomnewslettersubscription_domain_model_subscription (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name tinytext NOT NULL,
	gender tinyint(4) unsigned DEFAULT '0' NOT NULL,
	first_name tinytext NOT NULL,
	middle_name tinytext NOT NULL,
	last_name tinytext NOT NULL,
	birthday int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	phone varchar(30) DEFAULT '' NOT NULL,
	fax varchar(30) DEFAULT '' NOT NULL,
	mobile varchar(30) DEFAULT '' NOT NULL,
	www varchar(255) DEFAULT '' NOT NULL,
	address tinytext NOT NULL,
	building varchar(20) DEFAULT '' NOT NULL,
	room varchar(15) DEFAULT '' NOT NULL,
	company varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	zip varchar(20) DEFAULT '' NOT NULL,
	country varchar(128) DEFAULT '' NOT NULL,
	state varchar(255) DEFAULT '' NOT NULL,
	image tinyblob NOT NULL,
	description text NOT NULL,
	hash varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)

);