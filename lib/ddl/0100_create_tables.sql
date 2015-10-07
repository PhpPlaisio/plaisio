/*================================================================================*/
/* DDL SCRIPT                                                                     */
/*================================================================================*/
/*  Title    : Abc                                                          */
/*  FileName : abc.ecm                                                      */
/*  Platform : MySQL 5                                                            */
/*  Version  : Concept                                                            */
/*  Date     : zondag 27 september 2015                                           */
/*================================================================================*/
/*================================================================================*/
/* CREATE TABLES                                                                  */
/*================================================================================*/

CREATE TABLE `AUT_COMPANY` (
  `cmp_id` SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `cmp_abbr` VARCHAR(15) NOT NULL,
  `cmp_label` VARCHAR(20) CHARACTER SET ascii NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`cmp_id`)
);

CREATE TABLE `ABC_BLOB_DATA` (
  `bdt_id` INTEGER UNSIGNED AUTO_INCREMENT NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `bdt_inserted` DATETIME NOT NULL,
  `bdt_crc32` INT UNSIGNED NOT NULL,
  `bdt_size` INTEGER UNSIGNED NOT NULL,
  `bdt_mime_type` VARCHAR(48) NOT NULL,
  `bdt_data` LONGBLOB NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`bdt_id`)
);

CREATE TABLE `ABC_BLOB` (
  `blb_id` INTEGER UNSIGNED AUTO_INCREMENT NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `bdt_id` INTEGER UNSIGNED NOT NULL,
  `blb_inserted` DATETIME NOT NULL,
  `blb_crc32` INT UNSIGNED NOT NULL,
  `blb_file_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `blb_mime_type` VARCHAR(48) NOT NULL,
  `blb_size` INTEGER UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`blb_id`)
);

CREATE TABLE `AUT_CONFIG_CLASS` (
  `ccl_id` SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `ccl_type` VARCHAR(10) NOT NULL,
  `ccl_class` VARCHAR(128) NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`ccl_id`)
)
engine=innodb;

/*
COMMENT ON COLUMN `AUT_CONFIG_CLASS`.`ccl_type`
The PHP type of the parameter value.
*/

/*
COMMENT ON COLUMN `AUT_CONFIG_CLASS`.`ccl_class`
The class for showing and modifying the parameter value.
*/

CREATE TABLE `AUT_CONFIG` (
  `cfg_id` SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `ccl_id` SMALLINT UNSIGNED NOT NULL,
  `cfg_mandatory` BOOL DEFAULT 1 NOT NULL,
  `cfg_show_to_company` BOOL DEFAULT 0 NOT NULL,
  `cfg_modify_by_company` BOOL DEFAULT 0 NOT NULL,
  `cfg_description` VARCHAR(400) NOT NULL,
  `cfg_label` VARCHAR(48) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`cfg_id`)
)
engine=innodb;

/*
COMMENT ON COLUMN `AUT_CONFIG`.`cfg_mandatory`
If true: this parameter must have a value.
*/

/*
COMMENT ON COLUMN `AUT_CONFIG`.`cfg_show_to_company`
If true: this parameter is visible by the administrator of the company. Otherwise this parameter is visible to the system administrator.
*/

/*
COMMENT ON COLUMN `AUT_CONFIG`.`cfg_modify_by_company`
If true: the value of this parameter can be modified by the administrator of the company.
*/

CREATE TABLE `AUT_CONFIG_VALUE` (
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `cfg_id` SMALLINT UNSIGNED NOT NULL,
  `cfg_value` VARCHAR(4000),
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`cmp_id`, `cfg_id`)
)
engine=innodb;

CREATE TABLE `BBL_WORD_GROUP` (
  `wdg_id` TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `wdg_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `wdg_label` VARCHAR(32) CHARACTER SET ascii,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`wdg_id`)
);

CREATE TABLE `BBL_WORD` (
  `wrd_id` SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `wdg_id` TINYINT UNSIGNED NOT NULL,
  `wrd_modified` DATETIME NOT NULL,
  `wrd_comment` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `wrd_label` VARCHAR(48) CHARACTER SET ascii,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`wrd_id`),
  CONSTRAINT `wrd_label` UNIQUE (`wrd_label`)
);

CREATE TABLE `BBL_LANGUAGE` (
  `lan_id` TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  `lan_code` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lan_locale` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lan_date_format_full` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lan_date_format_abbr1` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lan_date_format_abbr2` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lan_date_format_compact` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lan_date_format_compact_weekday_abbr` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lan_date_time_format_full` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`lan_id`)
);

CREATE TABLE `AUT_USER` (
  `usr_id` INTEGER UNSIGNED AUTO_INCREMENT NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `lan_id` TINYINT UNSIGNED NOT NULL,
  `usr_name` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `usr_password_hash` VARCHAR(60) CHARACTER SET ascii COLLATE ascii_bin,
  `usr_anonymous` BOOL,
  `usr_blocked` BOOL DEFAULT 0 NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`usr_id`),
  CONSTRAINT `usr_name` UNIQUE (`cmp_id`, `usr_name`)
);

/*
COMMENT ON COLUMN `AUT_USER`.`usr_anonymous`
If set this user is an anonymous user. Per company there can be only one anonymous user.
*/

CREATE TABLE `AUT_SESSION` (
  `ses_id` INTEGER UNSIGNED AUTO_INCREMENT NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `usr_id` INTEGER UNSIGNED NOT NULL,
  `ses_session_token` VARCHAR(64) CHARACTER SET ascii COLLATE ascii_bin,
  `ses_csrf_token` VARCHAR(64) CHARACTER SET ascii COLLATE ascii_bin,
  `ses_start` DATETIME NOT NULL,
  `ses_last_request` DATETIME NOT NULL,
  `ses_number_of_requests` SMALLINT(5) DEFAULT 0 NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`ses_id`),
  CONSTRAINT `ses_csrf_token` UNIQUE (`ses_csrf_token`),
  CONSTRAINT `ses_session_token` UNIQUE (`ses_session_token`)
);

CREATE TABLE `AUT_CROSS_DOMAIN_REDIRECT` (
  `cdr_token1` VARCHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `cdr_token2` VARCHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `ses_id` INTEGER UNSIGNED NOT NULL,
  `cdr_timestamp_created` TIMESTAMP NOT NULL,
  CONSTRAINT `PK_AUT_CROSS_DOMAIN_REDIRECT` PRIMARY KEY (`cdr_token1`)
);

CREATE TABLE `AUT_MODULE` (
  `mdl_id` SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`mdl_id`)
)
engine=innodb;

CREATE TABLE `AUT_FUNCTIONALITY` (
  `fun_id` SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `mdl_id` SMALLINT UNSIGNED NOT NULL,
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`fun_id`)
)
engine=innodb;

CREATE TABLE `AUT_LOGIN_RESPONSE` (
  `lgr_id` TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  `lgr_label` VARCHAR(40) CHARACTER SET ascii NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`lgr_id`)
);

CREATE TABLE `AUT_PAGE_TAB` (
  `ptb_id` TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  `ptb_label` VARCHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`ptb_id`)
)
engine=innodb;

CREATE TABLE `AUT_PAGE` (
  `pag_id` SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `pag_id_org` SMALLINT UNSIGNED,
  `ptb_id` TINYINT UNSIGNED,
  `mnu_id` SMALLINT UNSIGNED,
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  `pag_class` VARCHAR(128) NOT NULL,
  `pag_label` VARCHAR(128) CHARACTER SET ascii,
  `pag_weight` INT,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`pag_id`)
);

CREATE TABLE `AUT_MENU` (
  `mnu_id` SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  `pag_id` SMALLINT UNSIGNED NOT NULL,
  `mnu_level` TINYINT NOT NULL,
  `mnu_group` SMALLINT NOT NULL,
  `mnu_weight` SMALLINT NOT NULL,
  `mnu_link` VARCHAR(64),
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`mnu_id`)
);

CREATE TABLE `AUT_MODULE_COMPANY` (
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `mdl_id` SMALLINT UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`cmp_id`, `mdl_id`),
  CONSTRAINT `SECONDARY` UNIQUE (`mdl_id`, `cmp_id`)
)
engine=innodb;

CREATE TABLE `AUT_PAG_FUN` (
  `pag_id` SMALLINT UNSIGNED NOT NULL,
  `fun_id` SMALLINT UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`fun_id`, `pag_id`),
  CONSTRAINT `SECONDARY` UNIQUE (`pag_id`, `fun_id`)
)
engine=innodb;

CREATE TABLE `AUT_PAGE_COMPANY` (
  `pag_id` SMALLINT UNSIGNED NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `pag_class` VARCHAR(128) NOT NULL,
  CONSTRAINT `PK_AUT_PAGE_COMPANY` PRIMARY KEY (`pag_id`, `cmp_id`)
)
engine=innodb;

CREATE TABLE `AUT_ROLE` (
  `rol_id` SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `rol_weight` SMALLINT NOT NULL,
  `rol_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`rol_id`)
);

CREATE TABLE `AUT_ROL_FUN` (
  `rol_id` SMALLINT UNSIGNED NOT NULL,
  `fun_id` SMALLINT UNSIGNED NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`rol_id`, `fun_id`),
  CONSTRAINT `SECONDARY` UNIQUE (`fun_id`, `rol_id`)
)
engine=innodb;

CREATE TABLE `AUT_USR_ROL` (
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `usr_id` INTEGER UNSIGNED NOT NULL,
  `rol_id` SMALLINT UNSIGNED NOT NULL,
  `aur_date_start` DATE NOT NULL,
  `aur_date_stop` DATE NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`usr_id`, `rol_id`),
  CONSTRAINT `SECONDAY` UNIQUE (`rol_id`, `usr_id`)
);

CREATE TABLE `BBL_WORD_TEXT` (
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  `lan_id` TINYINT UNSIGNED NOT NULL,
  `wdt_text` VARCHAR(80) NOT NULL,
  `wdt_modified` DATETIME NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`wrd_id`, `lan_id`)
);

CREATE TABLE `BBL_WORD_TRANSLATE_HISTORY` (
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  `lan_id` TINYINT UNSIGNED NOT NULL,
  `usr_id` INTEGER UNSIGNED NOT NULL,
  `wth_datetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  `wth_text` TINYTEXT NOT NULL
)
engine=innodb;

CREATE TABLE `DEV_UUID_KEY` (
  `uid_table_name` VARCHAR(64) NOT NULL,
  `uid_key` BIGINT NOT NULL,
  `uid_uuid` VARCHAR(32) NOT NULL,
  CONSTRAINT `PK_DEV_UUID_KEY` PRIMARY KEY (`uid_table_name`, `uid_key`)
);

CREATE TABLE `ELM_ATTRIBUTE` (
  `mat_id` TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `mat_label` VARCHAR(32) CHARACTER SET ascii NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`mat_id`)
);

CREATE TABLE `ELM_AUTHORIZED_DOMAIN` (
  `atd_domain_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`atd_domain_name`)
);

CREATE TABLE `LOG_SESSION` (
  `ses_id` INTEGER UNSIGNED AUTO_INCREMENT NOT NULL,
  `ses_datetime` DATETIME NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`ses_id`)
);

CREATE TABLE `LOG_EVENT_TYPE` (
  `let_id` TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `wrd_id` SMALLINT UNSIGNED NOT NULL,
  `let_label` VARCHAR(48) CHARACTER SET ascii NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`let_id`)
)
engine=innodb;

CREATE TABLE `LOG_EVENT` (
  `lev_id` INTEGER UNSIGNED AUTO_INCREMENT NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `usr_id` INTEGER UNSIGNED ZEROFILL NOT NULL,
  `let_id` TINYINT UNSIGNED NOT NULL,
  `ses_id` INTEGER UNSIGNED NOT NULL,
  `lgr_id` TINYINT UNSIGNED,
  `lev_datetime` DATETIME NOT NULL,
  `lev_ip` INTEGER UNSIGNED,
  `lev_arg1` VARCHAR(64),
  `lev_arg2` VARCHAR(64),
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`lev_id`)
)
engine=innodb;

CREATE TABLE `LOG_LOGIN` (
  `lli_id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `ses_id` INTEGER UNSIGNED NOT NULL,
  `lgr_id` TINYINT UNSIGNED NOT NULL,
  `cmp_id` SMALLINT UNSIGNED,
  `usr_id` INTEGER UNSIGNED,
  `llg_date_time` DATETIME NOT NULL,
  `llg_user_name` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `llg_company_abbr` VARCHAR(15) CHARACTER SET ascii NOT NULL,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`lli_id`)
);

CREATE TABLE `LOG_REQUEST` (
  `rql_id` INTEGER UNSIGNED AUTO_INCREMENT NOT NULL,
  `cmp_id` SMALLINT UNSIGNED NOT NULL,
  `pag_id` SMALLINT UNSIGNED NOT NULL,
  `ses_id` INTEGER UNSIGNED NOT NULL,
  `usr_id` INTEGER UNSIGNED NOT NULL,
  `rql_datetime` DATETIME NOT NULL,
  `rql_request` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `rql_method` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `rql_referer` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `rql_ip` INTEGER UNSIGNED,
  `rql_host_name` VARCHAR(80) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `rql_language` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `rql_user_agent` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
  `rql_number_of_queries` SMALLINT,
  `rql_time` FLOAT,
  `rql_size` MEDIUMINT,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`rql_id`)
);

CREATE TABLE `LOG_REQUEST_COOKIE` (
  `rql_id` INTEGER UNSIGNED NOT NULL,
  `rcl_variable` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rcl_value` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci
);

CREATE TABLE `LOG_REQUEST_POST` (
  `rql_id` INTEGER UNSIGNED NOT NULL,
  `rlp_variable` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rlp_value` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci
);

CREATE TABLE `LOG_REQUEST_QUERY` (
  `rqq_id` INTEGER UNSIGNED AUTO_INCREMENT NOT NULL,
  `rql_id` INTEGER UNSIGNED NOT NULL,
  `rqq_query` MEDIUMBLOB NOT NULL,
  `rqq_time` FLOAT NOT NULL,
  `rqq_routine` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
  CONSTRAINT `PRIMARY_KEY` PRIMARY KEY (`rqq_id`)
);

/*================================================================================*/
/* CREATE INDEXES                                                                 */
/*================================================================================*/

CREATE INDEX `bdt_crc32` ON `ABC_BLOB_DATA` (`bdt_crc32`);

CREATE INDEX `bdt_inserted` ON `ABC_BLOB_DATA` (`bdt_inserted`);

CREATE INDEX `bdt_mime_type` ON `ABC_BLOB_DATA` (`bdt_mime_type`);

CREATE INDEX `bdt_size` ON `ABC_BLOB_DATA` (`bdt_size`);

CREATE INDEX `cmp_id` ON `ABC_BLOB_DATA` (`cmp_id`);

CREATE INDEX `bdt_id` ON `ABC_BLOB` (`bdt_id`);

CREATE INDEX `cmp_id` ON `ABC_BLOB` (`cmp_id`);

CREATE INDEX `IX_AUT_CONFIG1` ON `AUT_CONFIG` (`cmp_id`);

CREATE INDEX `IX_AUT_CONFIG2` ON `AUT_CONFIG` (`ccl_id`);

CREATE INDEX `CFG_ID` ON `AUT_CONFIG_VALUE` (`cfg_id`);

CREATE INDEX `wdg_id` ON `BBL_WORD` (`wdg_id`);

CREATE INDEX `wrd_id` ON `BBL_LANGUAGE` (`wrd_id`);

CREATE INDEX `cmp_id` ON `AUT_USER` (`cmp_id`);

CREATE INDEX `lan_id` ON `AUT_USER` (`lan_id`);

CREATE INDEX `cmp_id` ON `AUT_SESSION` (`cmp_id`);

CREATE INDEX `usr_id` ON `AUT_SESSION` (`usr_id`);

CREATE INDEX `IX_AUT_CROSS_DOMAIN_REDIRECT1` ON `AUT_CROSS_DOMAIN_REDIRECT` (`ses_id`);

CREATE INDEX `IX_AUT_MODULE1` ON `AUT_MODULE` (`wrd_id`);

CREATE INDEX `IX_AUT_FUNCTIONALITY1` ON `AUT_FUNCTIONALITY` (`mdl_id`);

CREATE INDEX `IX_AUT_FUNCTIONALITY2` ON `AUT_FUNCTIONALITY` (`wrd_id`);

CREATE INDEX `wrd_id` ON `AUT_LOGIN_RESPONSE` (`wrd_id`);

CREATE INDEX `IX_AUT_PAGE_TAB1` ON `AUT_PAGE_TAB` (`wrd_id`);

CREATE INDEX `IX_AUT_PAGE1` ON `AUT_PAGE` (`ptb_id`);

CREATE INDEX `IX_AUT_PAGE2` ON `AUT_PAGE` (`pag_id_org`);

CREATE INDEX `mnu_id` ON `AUT_PAGE` (`mnu_id`);

CREATE INDEX `wrd_id` ON `AUT_PAGE` (`wrd_id`);

CREATE INDEX `pag_id` ON `AUT_MENU` (`pag_id`);

CREATE INDEX `wrd_id` ON `AUT_MENU` (`wrd_id`);

CREATE INDEX `IX_AUT_MODULE_COMPANY1` ON `AUT_MODULE_COMPANY` (`mdl_id`);

CREATE INDEX `IX_AUT_MODULE_COMPANY2` ON `AUT_MODULE_COMPANY` (`cmp_id`);

CREATE INDEX `IX_AUT_PAGE_COMPANY1` ON `AUT_PAGE_COMPANY` (`pag_id`);

CREATE INDEX `IX_AUT_PAGE_COMPANY2` ON `AUT_PAGE_COMPANY` (`cmp_id`);

CREATE INDEX `cmp_id` ON `AUT_ROLE` (`cmp_id`);

CREATE INDEX `IX_AUT_ROL_FUN3` ON `AUT_ROL_FUN` (`cmp_id`);

CREATE INDEX `cmp_id` ON `AUT_USR_ROL` (`cmp_id`);

CREATE INDEX `lan_id` ON `BBL_WORD_TEXT` (`lan_id`);

CREATE INDEX `IX_BBL_WORD_TRANSLATE_HISTORY1` ON `BBL_WORD_TRANSLATE_HISTORY` (`wrd_id`);

CREATE INDEX `IX_BBL_WORD_TRANSLATE_HISTORY2` ON `BBL_WORD_TRANSLATE_HISTORY` (`usr_id`);

CREATE INDEX `IX_BBL_WORD_TRANSLATE_HISTORY3` ON `BBL_WORD_TRANSLATE_HISTORY` (`lan_id`);

CREATE INDEX `IX_DEV_UUID_KEY1` ON `DEV_UUID_KEY` (`uid_uuid`);

CREATE INDEX `ses_datetime` ON `LOG_SESSION` (`ses_datetime`);

CREATE INDEX `WRD_ID` ON `LOG_EVENT_TYPE` (`wrd_id`);

CREATE INDEX `cmp_id` ON `LOG_EVENT` (`cmp_id`);

CREATE INDEX `lgr_id` ON `LOG_EVENT` (`lgr_id`);

CREATE INDEX `ses_id` ON `LOG_EVENT` (`ses_id`);

CREATE INDEX `usr_id` ON `LOG_EVENT` (`usr_id`);

CREATE INDEX `cmp_id` ON `LOG_LOGIN` (`cmp_id`);

CREATE INDEX `lgr_id` ON `LOG_LOGIN` (`lgr_id`);

CREATE INDEX `llg_date_time` ON `LOG_LOGIN` (`llg_date_time`);

CREATE INDEX `llg_user_name` ON `LOG_LOGIN` (`llg_user_name`);

CREATE INDEX `ses_id` ON `LOG_LOGIN` (`ses_id`);

CREATE INDEX `usr_id` ON `LOG_LOGIN` (`usr_id`);

CREATE INDEX `cmp_id` ON `LOG_REQUEST` (`cmp_id`);

CREATE INDEX `pag_id` ON `LOG_REQUEST` (`pag_id`);

CREATE INDEX `ses_id` ON `LOG_REQUEST` (`ses_id`);

CREATE INDEX `usr_id` ON `LOG_REQUEST` (`usr_id`);

CREATE INDEX `rql_id` ON `LOG_REQUEST_COOKIE` (`rql_id`);

CREATE INDEX `rql_id` ON `LOG_REQUEST_POST` (`rql_id`);

CREATE INDEX `rql_id` ON `LOG_REQUEST_QUERY` (`rql_id`);

/*================================================================================*/
/* CREATE FOREIGN KEYS                                                            */
/*================================================================================*/

ALTER TABLE `ABC_BLOB_DATA`
  ADD CONSTRAINT `FK_ABC_BLOB_DATA_AUT_COMPANY`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `ABC_BLOB`
  ADD CONSTRAINT `FK_ABC_BLOB_AUT_COMPANY`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `ABC_BLOB`
  ADD CONSTRAINT `FK_ABC_BLOB_ABC_BLOB_DATA`
  FOREIGN KEY (`bdt_id`) REFERENCES `ABC_BLOB_DATA` (`bdt_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_CONFIG`
  ADD CONSTRAINT `FK_AUT_CONFIG_AUT_CONFIG_CLASS`
  FOREIGN KEY (`ccl_id`) REFERENCES `AUT_CONFIG_CLASS` (`ccl_id`);

ALTER TABLE `AUT_CONFIG`
  ADD CONSTRAINT `FK_AUT_CONFIG_AUT_COMPANY`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`);

ALTER TABLE `AUT_CONFIG_VALUE`
  ADD CONSTRAINT `AUT_CONFIG_VALUE_ibfk_2`
  FOREIGN KEY (`cfg_id`) REFERENCES `AUT_CONFIG` (`cfg_id`);

ALTER TABLE `BBL_WORD`
  ADD CONSTRAINT `BBL_WORD_ibfk_1`
  FOREIGN KEY (`wdg_id`) REFERENCES `BBL_WORD_GROUP` (`wdg_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `BBL_LANGUAGE`
  ADD CONSTRAINT `FK_BBL_LANGUAGE_BBL_WORD`
  FOREIGN KEY (`wrd_id`) REFERENCES `BBL_WORD` (`wrd_id`);

ALTER TABLE `AUT_USER`
  ADD CONSTRAINT `AUT_USER_ibfk_1`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_USER`
  ADD CONSTRAINT `AUT_USER_ibfk_2`
  FOREIGN KEY (`lan_id`) REFERENCES `BBL_LANGUAGE` (`lan_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_SESSION`
  ADD CONSTRAINT `AUT_SESSION_ibfk_1`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_SESSION`
  ADD CONSTRAINT `AUT_SESSION_ibfk_2`
  FOREIGN KEY (`usr_id`) REFERENCES `AUT_USER` (`usr_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_CROSS_DOMAIN_REDIRECT`
  ADD CONSTRAINT `FK_AUT_CROSS_DOMAIN_REDIRECT_AUT_SESSION`
  FOREIGN KEY (`ses_id`) REFERENCES `AUT_SESSION` (`ses_id`);

ALTER TABLE `AUT_MODULE`
  ADD CONSTRAINT `FK_AUT_MODULE_BBL_WORD`
  FOREIGN KEY (`wrd_id`) REFERENCES `BBL_WORD` (`wrd_id`);

ALTER TABLE `AUT_FUNCTIONALITY`
  ADD CONSTRAINT `FK_AUT_FUNCTIONALITY_BBL_WORD`
  FOREIGN KEY (`wrd_id`) REFERENCES `BBL_WORD` (`wrd_id`);

ALTER TABLE `AUT_FUNCTIONALITY`
  ADD CONSTRAINT `FK_AUT_FUNCTIONALITY_AUT_MODULE`
  FOREIGN KEY (`mdl_id`) REFERENCES `AUT_MODULE` (`mdl_id`);

ALTER TABLE `AUT_LOGIN_RESPONSE`
  ADD CONSTRAINT `FK_AUT_LOGIN_RESPONSE_BBL_WORD`
  FOREIGN KEY (`wrd_id`) REFERENCES `BBL_WORD` (`wrd_id`);

ALTER TABLE `AUT_PAGE_TAB`
  ADD CONSTRAINT `FK_AUT_PAGE_TAB_BBL_WORD`
  FOREIGN KEY (`wrd_id`) REFERENCES `BBL_WORD` (`wrd_id`);

ALTER TABLE `AUT_PAGE`
  ADD CONSTRAINT `AUT_PAGE_ibfk_4`
  FOREIGN KEY (`mnu_id`) REFERENCES `AUT_MENU` (`mnu_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_PAGE`
  ADD CONSTRAINT `FK_AUT_PAGE_AUT_PAGE`
  FOREIGN KEY (`pag_id_org`) REFERENCES `AUT_PAGE` (`pag_id`);

ALTER TABLE `AUT_PAGE`
  ADD CONSTRAINT `AUT_PAGE_ibfk_3`
  FOREIGN KEY (`wrd_id`) REFERENCES `BBL_WORD` (`wrd_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_PAGE`
  ADD CONSTRAINT `FK_AUT_PAGE_AUT_PAGE_TAB`
  FOREIGN KEY (`ptb_id`) REFERENCES `AUT_PAGE_TAB` (`ptb_id`);

ALTER TABLE `AUT_MENU`
  ADD CONSTRAINT `AUT_MENU_ibfk_4`
  FOREIGN KEY (`wrd_id`) REFERENCES `BBL_WORD` (`wrd_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_MENU`
  ADD CONSTRAINT `AUT_MENU_ibfk_5`
  FOREIGN KEY (`pag_id`) REFERENCES `AUT_PAGE` (`pag_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_MODULE_COMPANY`
  ADD CONSTRAINT `FK_AUT_MODULE_COMPANY_AUT_COMPANY`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`);

ALTER TABLE `AUT_MODULE_COMPANY`
  ADD CONSTRAINT `FK_AUT_MODULE_COMPANY_AUT_MODULE`
  FOREIGN KEY (`mdl_id`) REFERENCES `AUT_MODULE` (`mdl_id`);

ALTER TABLE `AUT_PAG_FUN`
  ADD CONSTRAINT `FK_AUT_PAG_FUN_AUT_FUNCTIONALITY`
  FOREIGN KEY (`fun_id`) REFERENCES `AUT_FUNCTIONALITY` (`fun_id`);

ALTER TABLE `AUT_PAG_FUN`
  ADD CONSTRAINT `FK_AUT_PAG_FUN_AUT_PAGE`
  FOREIGN KEY (`pag_id`) REFERENCES `AUT_PAGE` (`pag_id`);

ALTER TABLE `AUT_PAGE_COMPANY`
  ADD CONSTRAINT `FK_AUT_PAGE_COMPANY_AUT_COMPANY`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`);

ALTER TABLE `AUT_PAGE_COMPANY`
  ADD CONSTRAINT `FK_AUT_PAGE_COMPANY_AUT_PAGE`
  FOREIGN KEY (`pag_id`) REFERENCES `AUT_PAGE` (`pag_id`);

ALTER TABLE `AUT_ROLE`
  ADD CONSTRAINT `AUT_ROLE_ibfk_1`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_ROL_FUN`
  ADD CONSTRAINT `FK_AUT_ROL_FUN_AUT_COMPANY`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`);

ALTER TABLE `AUT_ROL_FUN`
  ADD CONSTRAINT `FK_AUT_ROL_FUN_AUT_FUNCTIONALITY`
  FOREIGN KEY (`fun_id`) REFERENCES `AUT_FUNCTIONALITY` (`fun_id`);

ALTER TABLE `AUT_ROL_FUN`
  ADD CONSTRAINT `FK_AUT_ROL_FUN_AUT_ROLE`
  FOREIGN KEY (`rol_id`) REFERENCES `AUT_ROLE` (`rol_id`);

ALTER TABLE `AUT_USR_ROL`
  ADD CONSTRAINT `AUT_USR_ROL_ibfk_1`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_USR_ROL`
  ADD CONSTRAINT `AUT_USR_ROL_ibfk_3`
  FOREIGN KEY (`rol_id`) REFERENCES `AUT_ROLE` (`rol_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `AUT_USR_ROL`
  ADD CONSTRAINT `AUT_USR_ROL_ibfk_2`
  FOREIGN KEY (`usr_id`) REFERENCES `AUT_USER` (`usr_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `BBL_WORD_TEXT`
  ADD CONSTRAINT `BBL_WORD_TEXT_ibfk_2`
  FOREIGN KEY (`lan_id`) REFERENCES `BBL_LANGUAGE` (`lan_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `BBL_WORD_TEXT`
  ADD CONSTRAINT `BBL_WORD_TEXT_ibfk_1`
  FOREIGN KEY (`wrd_id`) REFERENCES `BBL_WORD` (`wrd_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `BBL_WORD_TRANSLATE_HISTORY`
  ADD CONSTRAINT `FK_BBL_WORD_TRANSLATE_HISTORY_AUT_USER`
  FOREIGN KEY (`usr_id`) REFERENCES `AUT_USER` (`usr_id`);

ALTER TABLE `BBL_WORD_TRANSLATE_HISTORY`
  ADD CONSTRAINT `FK_BBL_WORD_TRANSLATE_HISTORY_BBL_LANGUAGE`
  FOREIGN KEY (`lan_id`) REFERENCES `BBL_LANGUAGE` (`lan_id`);

ALTER TABLE `BBL_WORD_TRANSLATE_HISTORY`
  ADD CONSTRAINT `FK_BBL_WORD_TRANSLATE_HISTORY_BBL_WORD`
  FOREIGN KEY (`wrd_id`) REFERENCES `BBL_WORD` (`wrd_id`);

ALTER TABLE `LOG_EVENT`
  ADD CONSTRAINT `FK_LOG_EVENT_AUT_COMPANY`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`);

ALTER TABLE `LOG_EVENT`
  ADD CONSTRAINT `FK_LOG_EVENT_AUT_LOGIN_RESPONSE`
  FOREIGN KEY (`lgr_id`) REFERENCES `AUT_LOGIN_RESPONSE` (`lgr_id`);

ALTER TABLE `LOG_EVENT`
  ADD CONSTRAINT `FK_LOG_EVENT_AUT_USER`
  FOREIGN KEY (`usr_id`) REFERENCES `AUT_USER` (`usr_id`);

ALTER TABLE `LOG_EVENT`
  ADD CONSTRAINT `FK_LOG_EVENT_LOG_SESSION`
  FOREIGN KEY (`ses_id`) REFERENCES `LOG_SESSION` (`ses_id`);

ALTER TABLE `LOG_EVENT`
  ADD CONSTRAINT `LOG_EVENT_ibfk_3`
  FOREIGN KEY (`let_id`) REFERENCES `LOG_EVENT_TYPE` (`let_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `LOG_LOGIN`
  ADD CONSTRAINT `LOG_LOGIN_ibfk_6`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `LOG_LOGIN`
  ADD CONSTRAINT `LOG_LOGIN_ibfk_5`
  FOREIGN KEY (`lgr_id`) REFERENCES `AUT_LOGIN_RESPONSE` (`lgr_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `LOG_LOGIN`
  ADD CONSTRAINT `FK_LOG_LOGIN_AUT_SESSION`
  FOREIGN KEY (`ses_id`) REFERENCES `AUT_SESSION` (`ses_id`);

ALTER TABLE `LOG_LOGIN`
  ADD CONSTRAINT `LOG_LOGIN_ibfk_7`
  FOREIGN KEY (`usr_id`) REFERENCES `AUT_USER` (`usr_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `LOG_LOGIN`
  ADD CONSTRAINT `LOG_LOGIN_ibfk_4`
  FOREIGN KEY (`ses_id`) REFERENCES `LOG_SESSION` (`ses_id`)
  ON UPDATE NO ACTION
  ON DELETE NO ACTION;

ALTER TABLE `LOG_REQUEST`
  ADD CONSTRAINT `FK_LOG_REQUEST_AUT_COMPANY`
  FOREIGN KEY (`cmp_id`) REFERENCES `AUT_COMPANY` (`cmp_id`);

ALTER TABLE `LOG_REQUEST`
  ADD CONSTRAINT `FK_LOG_REQUEST_AUT_PAGE`
  FOREIGN KEY (`pag_id`) REFERENCES `AUT_PAGE` (`pag_id`);

ALTER TABLE `LOG_REQUEST`
  ADD CONSTRAINT `FK_LOG_REQUEST_AUT_USER`
  FOREIGN KEY (`usr_id`) REFERENCES `AUT_USER` (`usr_id`);

ALTER TABLE `LOG_REQUEST`
  ADD CONSTRAINT `FK_LOG_REQUEST_LOG_SESSION`
  FOREIGN KEY (`ses_id`) REFERENCES `LOG_SESSION` (`ses_id`);

ALTER TABLE `LOG_REQUEST_COOKIE`
  ADD CONSTRAINT `FK_LOG_REQUEST_COOKIE_LOG_REQUEST`
  FOREIGN KEY (`rql_id`) REFERENCES `LOG_REQUEST` (`rql_id`);

ALTER TABLE `LOG_REQUEST_POST`
  ADD CONSTRAINT `FK_LOG_REQUEST_POST_LOG_REQUEST`
  FOREIGN KEY (`rql_id`) REFERENCES `LOG_REQUEST` (`rql_id`);

ALTER TABLE `LOG_REQUEST_QUERY`
  ADD CONSTRAINT `FK_LOG_REQUEST_QUERY_LOG_REQUEST`
  FOREIGN KEY (`rql_id`) REFERENCES `LOG_REQUEST` (`rql_id`);
