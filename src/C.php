<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc;

//----------------------------------------------------------------------------------------------------------------------
class C
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Manual defined constants.
   */
  const KNAS_EPOCH = '2014-01-01';

  // Reference language for translators.
  const LAN_ID_BABEL_REFERENCE = 1;

  // Maximum length of a password.
  const LEN_PASSWORD = 1014;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Database connection parameters.
   */
  const DB_HOSTNAME = 'localhost';
  const DB_USERNAME = 'rank_user';
  const DB_PASSWORD = 'rank_user';
  const DB_DATABASE = 'rank_data';
  const DB_PORT = '3306';

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @setbased.stratum.constants
   *
   * Below this doc block constants will be inserted by PhpStratum.
   */
  const CFG_ID_CONTACT = 1;
  const CMP_ID_KNAS = 2;
  const CMP_ID_SYSTEM = 1;
  const LEN_CMP_ABBR = 15;
  const LEN_CMP_LABEL = 20;
  const LEN_CNT_IOC_ABBR = 3;
  const LEN_KNAS_TRN_LOCATION = 40;
  const LEN_KNAS_TRN_NAME = 40;
  const LEN_MNU_GROUP = 5;
  const LEN_MNU_LEVEL = 3;
  const LEN_MNU_LINK = 64;
  const LEN_MNU_WEIGHT = 5;
  const LEN_PAG_CLASS = 128;
  const LEN_PAG_LABEL = 128;
  const LEN_PAG_WEIGHT = 10;
  const LEN_PTB_LABEL = 32;
  const LEN_RL2_FIRST_NAME = 40;
  const LEN_RL2_NAME = 80;
  const LEN_RL2_PREFIX = 15;
  const LEN_RL2_REGISTRATION_NUMBER_INT = 12;
  const LEN_RL2_REGISTRATION_NUMBER_NAT = 12;
  const LEN_ROL_NAME = 32;
  const LEN_ROL_WEIGHT = 5;
  const LEN_TRS_RANK = 5;
  const LEN_USR_NAME = 64;
  const LEN_WDG_LABEL = 32;
  const LEN_WDG_NAME = 32;
  const LEN_WDT_TEXT = 80;
  const LEN_WRD_COMMENT = 255;
  const LEN_WRD_LABEL = 48;
  const LET_ID_LOGIN_FAILED = 3;
  const LET_ID_LOGIN_GRANTED = 1;
  const LET_ID_LOGOUT = 2;
  const LGR_ID_BLOCKED = 4;
  const LGR_ID_GRANTED = 1;
  const LGR_ID_NO_ROLE = 6;
  const LGR_ID_UNKNOWN_COMPANY = 2;
  const LGR_ID_UNKNOWN_USER = 3;
  const LGR_ID_WRONG_PASSWORD = 5;
  const PAG_ID_BABEL_WORD_DELETE = 54;
  const PAG_ID_BABEL_WORD_GROUP_DETAILS = 10;
  const PAG_ID_BABEL_WORD_GROUP_INSERT = 13;
  const PAG_ID_BABEL_WORD_GROUP_OVERVIEW = 9;
  const PAG_ID_BABEL_WORD_GROUP_UPDATE = 14;
  const PAG_ID_BABEL_WORD_INSERT = 12;
  const PAG_ID_BABEL_WORD_TRANSLATE = 11;
  const PAG_ID_BABEL_WORD_TRANSLATE_WORDS = 55;
  const PAG_ID_BABEL_WORD_UPDATE = 15;
  const PAG_ID_BACK_INDEX = 56;
  const PAG_ID_COMPANY_DETAILS = 19;
  const PAG_ID_COMPANY_INSERT = 17;
  const PAG_ID_COMPANY_MODULE_OVERVIEW = 45;
  const PAG_ID_COMPANY_MODULE_UPDATE = 46;
  const PAG_ID_COMPANY_OVERVIEW = 16;
  const PAG_ID_COMPANY_ROLE_DETAILS = 22;
  const PAG_ID_COMPANY_ROLE_INSERT = 23;
  const PAG_ID_COMPANY_ROLE_OVERVIEW = 20;
  const PAG_ID_COMPANY_ROLE_UPDATE = 24;
  const PAG_ID_COMPANY_ROLE_UPDATE_FUNCTIONALITIES = 44;
  const PAG_ID_COMPANY_SPECIFIC_PAGE_DELETE = 50;
  const PAG_ID_COMPANY_SPECIFIC_PAGE_INSERT = 49;
  const PAG_ID_COMPANY_SPECIFIC_PAGE_OVERVIEW = 47;
  const PAG_ID_COMPANY_SPECIFIC_PAGE_UPDATE = 48;
  const PAG_ID_COMPANY_UPDATE = 18;
  const PAG_ID_KNAS_BACK_ADMIN_AGE_CROSSING_OVERVIEW = 60;
  const PAG_ID_KNAS_BACK_ADMIN_AGE_CROSSING_UPDATE = 61;
  const PAG_ID_KNAS_BACK_ADMIN_PARTICIPANT_CONSTANT_OVERVIEW = 85;
  const PAG_ID_KNAS_BACK_ADMIN_PARTICIPANT_CONSTANT_UPDATE = 86;
  const PAG_ID_KNAS_BACK_ADMIN_POINT_SCHEME_DETAILS = 79;
  const PAG_ID_KNAS_BACK_ADMIN_POINT_SCHEME_OVERVIEW = 78;
  const PAG_ID_KNAS_BACK_RANK_LISTS_OVERVIEW = 31;
  const PAG_ID_KNAS_BACK_RANK_LIST_RELEASES = 57;
  const PAG_ID_KNAS_BACK_RANK_LIST_RELEASE_DELETE = 100;
  const PAG_ID_KNAS_BACK_RANK_LIST_RELEASE_DETAILS = 58;
  const PAG_ID_KNAS_BACK_RANK_LIST_RELEASE_INSERT = 101;
  const PAG_ID_KNAS_BACK_RANK_LIST_RELEASE_PUBLISH = 120;
  const PAG_ID_KNAS_BACK_RANK_LIST_RELEASE_TOURNAMENTS = 102;
  const PAG_ID_KNAS_BACK_RANK_LIST_RELEASE_UPDATE = 62;
  const PAG_ID_KNAS_BACK_RANK_SYSTEM_WORD_TOP_DETAILS = 90;
  const PAG_ID_KNAS_BACK_RANK_SYSTEM_WORD_TOP_OVERVIEW = 89;
  const PAG_ID_KNAS_BACK_RANK_SYSTEM_WORD_TOP_UPLOAD = 91;
  const PAG_ID_KNAS_BACK_TOOLS_GRAB_FIE_RANK_LIST = 88;
  const PAG_ID_KNAS_BACK_TOOLS_OVERVIEW = 87;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT = 64;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_DETAILS = 65;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_INPUT = 94;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_INPUT_ENGARDE_HTML = 110;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_INPUT_ENGARDE_PDF = 111;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_INPUT_ENGARDE_XML = 113;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_INPUT_FIE_GRABBER = 95;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_INPUT_OPHARDT_PDF = 112;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_PARTICIPANTS = 93;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_PARTICIPANTS_DELETE = 106;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_PARTICIPANTS_INSERT = 107;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_PARTICIPANTS_UPDATE = 108;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_PARTICIPANTS_WORLD_RANKING = 109;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_POINTS = 96;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_PREVIOUS = 97;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_INSERT_TOURNAMENT_STEP_SYSTEM = 92;
  const PAG_ID_KNAS_BACK_TOURNAMENTS_UPDATE_TOURNAMENT = 123;
  const PAG_ID_KNAS_BACK_TOURNAMENT_ATTACHMENT_DELETE = 119;
  const PAG_ID_KNAS_BACK_TOURNAMENT_ATTACHMENT_INSERT = 118;
  const PAG_ID_KNAS_BACK_TOURNAMENT_ATTACHMENT_OVERVIEW = 84;
  const PAG_ID_KNAS_BACK_TOURNAMENT_ATTACHMENT_UPDATE = 117;
  const PAG_ID_KNAS_BACK_TOURNAMENT_ATTACHMENT_VIEW = 116;
  const PAG_ID_KNAS_BACK_TOURNAMENT_DELETE = 99;
  const PAG_ID_KNAS_BACK_TOURNAMENT_DETAILS = 80;
  const PAG_ID_KNAS_BACK_TOURNAMENT_NOT_LINKED = 114;
  const PAG_ID_KNAS_BACK_TOURNAMENT_OVERVIEW = 63;
  const PAG_ID_KNAS_BACK_TOURNAMENT_RANK_LISTS = 83;
  const PAG_ID_KNAS_BACK_TOURNAMENT_RESULTS = 81;
  const PAG_ID_KNAS_BACK_TOURNAMENT_WORLD_RANK = 82;
  const PAG_ID_KNAS_FRONT_MISC_CONTACT = 103;
  const PAG_ID_KNAS_FRONT_PARTICIPANT_DETAILS = 75;
  const PAG_ID_KNAS_FRONT_PARTICIPANT_RANK_LISTS = 76;
  const PAG_ID_KNAS_FRONT_PARTICIPANT_TOURNAMENTS = 77;
  const PAG_ID_KNAS_FRONT_RANK_LIST_DETAIL_EXAPLAIN = 70;
  const PAG_ID_KNAS_FRONT_RANK_LIST_RELEASES = 71;
  const PAG_ID_KNAS_FRONT_RANK_LIST_RELEASE_DETAILS = 69;
  const PAG_ID_KNAS_FRONT_RANK_LIST_RELEASE_DOCUMENTS = 121;
  const PAG_ID_KNAS_FRONT_RANK_LIST_RELEASE_ENTRIES = 30;
  const PAG_ID_KNAS_FRONT_RANK_LIST_RELEASE_TOURNAMENTS = 67;
  const PAG_ID_KNAS_FRONT_RANK_LIST_VIEW_DOCUMENT = 122;
  const PAG_ID_KNAS_FRONT_TOURNAMENT_DETAILS = 72;
  const PAG_ID_KNAS_FRONT_TOURNAMENT_PERCENTAGE = 73;
  const PAG_ID_KNAS_FRONT_TOURNAMENT_POINTS = 98;
  const PAG_ID_KNAS_FRONT_TOURNAMENT_RANK_LISTS = 74;
  const PAG_ID_KNAS_FRONT_TOURNAMENT_RESULT = 66;
  const PAG_ID_KNAS_FRONT_TOURNAMENT_VIEW_ATTACHMENT = 115;
  const PAG_ID_MISC_INDEX = 1;
  const PAG_ID_MISC_LOGIN = 2;
  const PAG_ID_MISC_LOGOUT = 3;
  const PAG_ID_MISC_W3C_VALIDATE = 4;
  const PAG_ID_PAGE_DELETE_PAGE = 28;
  const PAG_ID_RANK_BACK_ADMIN_CONTACT_UPDATE = 104;
  const PAG_ID_RANK_BACK_RELATION_RELATION2_COMPLETION = 105;
  const PAG_ID_RANK_SYSTEM_SYSTEM_OVERVIEW = 59;
  const PAG_ID_SYSTEM_FUNCTIONALITY_DETAILS = 39;
  const PAG_ID_SYSTEM_FUNCTIONALITY_INSERT = 40;
  const PAG_ID_SYSTEM_FUNCTIONALITY_OVERVIEW = 38;
  const PAG_ID_SYSTEM_FUNCTIONALITY_UPDATE = 41;
  const PAG_ID_SYSTEM_FUNCTIONALITY_UPDATE_PAGES = 42;
  const PAG_ID_SYSTEM_MENU_INSERT = 53;
  const PAG_ID_SYSTEM_MENU_MODIFY = 52;
  const PAG_ID_SYSTEM_MENU_OVERVIEW = 51;
  const PAG_ID_SYSTEM_MODULE_DETAILS = 43;
  const PAG_ID_SYSTEM_MODULE_INSERT = 33;
  const PAG_ID_SYSTEM_MODULE_OVERVIEW = 27;
  const PAG_ID_SYSTEM_MODULE_UPDATE = 32;
  const PAG_ID_SYSTEM_PAGE_DETAILS = 6;
  const PAG_ID_SYSTEM_PAGE_INSERT = 8;
  const PAG_ID_SYSTEM_PAGE_OVERVIEW = 5;
  const PAG_ID_SYSTEM_PAGE_UPDATE = 7;
  const PAG_ID_SYSTEM_PAGE_UPDATE_FUNCTIONALITIES = 68;
  const PAG_ID_SYSTEM_TAB_DETAILS = 35;
  const PAG_ID_SYSTEM_TAB_INSERT = 37;
  const PAG_ID_SYSTEM_TAB_OVERVIEW = 34;
  const PAG_ID_SYSTEM_TAB_UPDATE = 36;
  const PTB_ID_ADMIN = 5;
  const PTB_ID_BABEL = 2;
  const PTB_ID_BACK_KNAS_RANK_LIST = 4;
  const PTB_ID_BACK_RANK_SYSTEM = 11;
  const PTB_ID_COMPANY = 3;
  const PTB_ID_FRONT_RANK_LIST = 7;
  const PTB_ID_KNAS_BACK_TOURNAMENT = 10;
  const PTB_ID_KNAS_BACK_TOURNAMENTS = 6;
  const PTB_ID_KNAS_FRONT_TOURNAMENT = 8;
  const PTB_ID_KNAS_PARTICIPANT = 9;
  const PTB_ID_SYSTEM = 1;
  const RLG_ID_KNAS_INDIVIDUEEL = 1;
  const RLG_ID_KNAS_KNAS_CUP = 2;
  const SG1_ID_KNAS_BENJAMIN = 3;
  const SG1_ID_KNAS_CADET = 5;
  const SG1_ID_KNAS_JUNIOR = 6;
  const SG1_ID_KNAS_KUIKEN = 2;
  const SG1_ID_KNAS_PUPIL = 4;
  const SG1_ID_KNAS_SENIOR = 1;
  const SG1_ID_KNAS_VETERAAN = 7;
  const SG1_ID_KNAS_VETERAAN_A = 8;
  const SG1_ID_KNAS_VETERAAN_B = 9;
  const SG1_ID_KNAS_VETERAAN_C = 10;
  const SG1_ID_KNAS_VETERAAN_D = 11;
  const SG2_ID_KNAS_FEMALE = 2;
  const SG2_ID_KNAS_MALE = 1;
  const SG3_ID_KNAS_EPEE = 3;
  const SG3_ID_KNAS_FOIL = 2;
  const SG3_ID_KNAS_SABRE = 1;
  const SG4_ID_KNAS_INDIVIDUAL = 1;
  const SG4_ID_KNAS_TEAM = 2;
  const TP1_ID_KNAS_ECC = 5;
  const TP1_ID_KNAS_FIE_A = 2;
  const TP1_ID_KNAS_FIE_GP = 3;
  const TP1_ID_KNAS_FIE_SA = 4;
  const TP1_ID_KNAS_NK = 6;
  const TP1_ID_KNAS_NONE = 1;
  const TP2_ID_KNAS_KEURMERK = 2;
  const TP2_ID_KNAS_KEURMERK_PLUS = 3;
  const TP2_ID_KNAS_NONE = 1;
  const WDG_ID_BUTTON = 5;
  const WDG_ID_FUNCTIONALITIES = 7;
  const WDG_ID_LANGUAGE = 1;
  const WDG_ID_MENU = 8;
  const WDG_ID_MODULE = 2;
  const WDG_ID_PAGE_GROUP_TITLE = 4;
  const WDG_ID_PAGE_TITLE = 3;
  const WRD_ID_AGE = 136;
  const WRD_ID_BIRTHDAY = 1427;
  const WRD_ID_BUTTON_CANCEL = 1478;
  const WRD_ID_BUTTON_INSERT = 107;
  const WRD_ID_BUTTON_OK = 3;
  const WRD_ID_BUTTON_SAVE = 1477;
  const WRD_ID_BUTTON_UPDATE = 108;
  const WRD_ID_CLUB = 1426;
  const WRD_ID_COMPATIBILITY = 1467;
  const WRD_ID_COUNTRY = 148;
  const WRD_ID_DATE = 118;
  const WRD_ID_DEFAULT = 1466;
  const WRD_ID_DESCRIPTION = 1436;
  const WRD_ID_DOCUMENTS = 1441;
  const WRD_ID_DUTCH = 29;
  const WRD_ID_ENGLISH = 1;
  const WRD_ID_FENCER = 122;
  const WRD_ID_FILE = 1471;
  const WRD_ID_FIRST_NAME = 1488;
  const WRD_ID_GENDER = 1452;
  const WRD_ID_GRADE = 134;
  const WRD_ID_GROUP = 1443;
  const WRD_ID_INPUT = 144;
  const WRD_ID_LANGUAGE = 18;
  const WRD_ID_LICENSE = 1468;
  const WRD_ID_LINKS = 1496;
  const WRD_ID_LOCATION = 132;
  const WRD_ID_METHOD = 1474;
  const WRD_ID_NAME = 44;
  const WRD_ID_NATIONALITY = 1469;
  const WRD_ID_N_USERS = 46;
  const WRD_ID_PARAMETER = 1435;
  const WRD_ID_PARTICIPANTS = 145;
  const WRD_ID_PERCENTAGE = 133;
  const WRD_ID_PERIOD = 1445;
  const WRD_ID_POINTS = 121;
  const WRD_ID_PREVIOUS_EDITION = 146;
  const WRD_ID_PUBLIC = 1499;
  const WRD_ID_RANK = 120;
  const WRD_ID_RANK_LIST = 1444;
  const WRD_ID_RELATION_NUMBER = 1434;
  const WRD_ID_RELEASE = 1439;
  const WRD_ID_RULE = 1438;
  const WRD_ID_SCHEMA = 1450;
  const WRD_ID_SIZE = 1498;
  const WRD_ID_SUBSYSTEM = 1460;
  const WRD_ID_SYSTEM = 143;
  const WRD_ID_TOURNAMENT = 131;
  const WRD_ID_TOURNAMENTS = 135;
  const WRD_ID_TYPING = 137;
  const WRD_ID_VALUE = 1437;
  const WRD_ID_WEAPON = 149;
  const WRD_ID_WEIGHT = 45;

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
