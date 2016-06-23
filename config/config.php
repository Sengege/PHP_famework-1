<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 22/03/2016
 * Time: 22:11
 *
 * Configuration for: Database Connection
 * This is the place where database login constants are saved.
 *
 * DB_TYPE: type of the database used
 * DB_HOST: database host, usually it's "127.0.0.1" or "localhost", some servers also need port info
 * DB_NAME: name of the database.
 * DB_USER: user for database.
 * DB_PASS: the password of the above user
 *
 * @link https://github.com/panique/php-login-advanced/
 */

define('DB_TYPE', 'mysql');
define("DB_HOST", "localhost");
define("DB_NAME", "igpSwopeDB");
define("DB_USER", "root");
define("DB_PASS", "igp2015");

/**
 * Configuration for: Hashing strength
 * This is the place where you define the strength of your password hashing/salting
 *
 * To make password encryption very safe and future-proof, the PHP 5.5 hashing/salting functions
 * come with a clever so called COST FACTOR. This number defines the base-2 logarithm of the rounds of hashing,
 * something like 2^12 if your cost factor is 12. By the way, 2^12 would be 4096 rounds of hashing, doubling the
 * round with each increase of the cost factor and therefore doubling the CPU power it needs.
 * Currently, in 2013, the developers of this functions have chosen a cost factor of 10, which fits most standard
 * server setups. When time goes by and server power becomes much more powerful, it might be useful to increase
 * the cost factor, to make the password hashing one step more secure. Have a look here
 * (@see https://github.com/panique/php-login/wiki/Which-hashing-&-salting-algorithm-should-be-used-%3F)
 * in the BLOWFISH benchmark table to get an idea how this factor behaves. For most people this is irrelevant,
 * but after some years this might be very very useful to keep the encryption of your database up to date.
 *
 * Remember: Every time a user registers or tries to log in (!) this calculation will be done.
 * Don't change this if you don't know what you do.
 *
 * To get more information about the best cost factor please have a look here
 * @see http://stackoverflow.com/q/4443476/1114320
 *
 * This constant will be used in the login and the registration class.
 */
define("HASH_COST_FACTOR", "10");

/**
 * Configuration for: Email server credentials
 *
 * Here you can define how you want to send emails.
 * If you have successfully set up a mail server on your linux server and you know
 * what you do, then you can skip this section. Otherwise please set EMAIL_USE_SMTP to true
 * and fill in your SMTP provider account data.
 *
 * An example setup for using gmail.com [Google Mail] as email sending service,
 * works perfectly in August 2013. Change the "xxx" to your needs.
 * Please note that there are several issues with gmail, like gmail will block your server
 * for "spam" reasons or you'll have a daily sending limit. See the readme.md for more info.
 *
 * define("EMAIL_USE_SMTP", true);
 * define("EMAIL_SMTP_HOST", "ssl://smtp.gmail.com");
 * define("EMAIL_SMTP_AUTH", true);
 * define("EMAIL_SMTP_USERNAME", "xxxxxxxxxx@gmail.com");
 * define("EMAIL_SMTP_PASSWORD", "xxxxxxxxxxxxxxxxxxxx");
 * define("EMAIL_SMTP_PORT", 465);
 * define("EMAIL_SMTP_ENCRYPTION", "ssl");
 *
 * It's really recommended to use SMTP!
 *
 */
define("EMAIL_USE_SMTP", true);
define("EMAIL_SMTP_HOST", 'tls://smtp.163.com');
define("EMAIL_SMTP_AUTH", true);
define("EMAIL_SMTP_USERNAME", '13303859657@163.com');
define("EMAIL_SMTP_PASSWORD", 'zht123');
define("EMAIL_SMTP_PORT", 25);
define("EMAIL_SMTP_ENCRYPTION", 'tls');

/**
 * Configuration for: verification email data
 * Set the absolute URL to register.php, necessary for email verification links
 */
define("EMAIL_VERIFICATION_URL", "http://202.196.1.141/classes/routers/registration_confirmation_router.php");
define("EMAIL_VERIFICATION_FROM", '13303859657@163.com');

define("EMAIL_VERIFICATION_FROM_NAME", "Swope");
define("EMAIL_VERIFICATION_SUBJECT", "Account activation for Swope");
define("EMAIL_VERIFICATION_CONTENT", "Please paste this code into the browser: ");

/**
 * Configuration for: verification routing
 */
define("EMAIL_VERIFICATION_PATH_EN", "../../views/confirm_page_english.php");
define("EMAIL_VERIFICATION_PATH_CN", "../../views/confirm_page_chinese.php");
define("HOME_PAGE_PATH", "../../views/home.php");
define("PATH_TO_VIEWS", "../../views/");

