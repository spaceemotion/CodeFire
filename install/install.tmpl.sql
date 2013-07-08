-- --------------------------------------------------------
-- Create table structure
-- --------------------------------------------------------

	-- Meta table
	CREATE TABLE IF NOT EXISTS `%prefix%settings` (
		`key` varchar(32) NOT NULL,
		`value` text NOT NULL,

		PRIMARY KEY (`key`)
	) DEFAULT CHARSET=utf8;

	-- Session table
	CREATE TABLE IF NOT EXISTS `%prefix%sessions` (
		`session_id` varchar(40) DEFAULT '0' NOT NULL,
		`ip_address` varchar(45) DEFAULT '0' NOT NULL,
		`user_agent` varchar(120) NOT NULL,
		`last_activity` int(10) unsigned DEFAULT 0 NOT NULL,
		`user_data` text NOT NULL,

		KEY `last_activity_idx` (`last_activity`),

		PRIMARY KEY (`session_id`)
	) DEFAULT CHARSET=utf8;

	-- User groups
	CREATE TABLE IF NOT EXISTS `%prefix%groups` (
		`id` int NOT NULL AUTO_INCREMENT,
		`rank` int NOT NULL,
		`title` varchar(20) NOT NULL DEFAULT '',
		`description` varchar(100) NOT NULL DEFAULT '',

		PRIMARY KEY (`id`)
	) DEFAULT CHARSET=utf8;

	-- User table
	CREATE TABLE IF NOT EXISTS `%prefix%users` (
		`id` int NOT NULL AUTO_INCREMENT,
		`username` varchar(24) NOT NULL,
		`email` varchar(32) NOT NULL,
		`password` varchar(60) NOT NULL,
		`group_id` int NOT NULL,
		`registered`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`last_login` timestamp DEFAULT 0,
		`banned` tinyint(1) NOT NULL DEFAULT 0,
		`ban_reason` varchar(128) DEFAULT '',
		`activated` tinyint(1) NOT NULL DEFAULT 0,
		`activate_key` varchar(32),
		
		-- currently unsupported:
		-- `token` varchar(255) NOT NULL, 
		-- `identifier` varchar(255) NOT NULL,

		KEY `name` (`username`),
		KEY `group` (`group_id`),
		KEY `activate` (`activate_key`),

		PRIMARY KEY (`id`)
	) DEFAULT CHARSET=utf8;

	-- Custom user data
	CREATE TABLE IF NOT EXISTS `%prefix%user_fields` (
		`id` int NOT NULL AUTO_INCREMENT,
		`key` varchar(24) NOT NULL,
		`name` varchar(32) NOT NULL,
		`type` int NOT NULL,
		`required` tinyint(1) NOT NULL DEFAULT 0,
		`minlength` int NOT NULL DEFAULT 0,
		`maxlength` int NOT NULL DEFAULT 255,
		`default` varchar(255),

		PRIMARY KEY (`id`)
	) DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `%prefix%user_data` (
		`id` int NOT NULL,
		`user_id` int NOT NULL,
		`data` varchar(255) NOT NULL,

		KEY `field` (`id`),
		KEY `user` (`user_id`)
	) DEFAULT CHARSET=utf8;

	-- Priviliges
	CREATE TABLE IF NOT EXISTS `%prefix%access_keys` (
		`id` int NOT NULL AUTO_INCREMENT,
		`key` varchar(24) NOT NULL,
		`name` varchar(32) NOT NULL,
		`description` varchar(64) DEFAULT NULL,

		KEY `key` (`key`),

		PRIMARY KEY (`id`)
	) DEFAULT CHARSET=utf8;

	-- Group/User Privileges
	CREATE TABLE IF NOT EXISTS `%prefix%access` (
		`key_id` int NOT NULL,
		`id` int NOT NULL,
		`allow` tinyint(1) NOT NULL DEFAULT 1,
		`group` tinyint(1) NOT NULL,

		KEY `group` (`group`),
		KEY `id` (`id`),

		UNIQUE KEY (`id`, `key_id`, `group`)
	);

	-- Captcha table
	CREATE TABLE IF NOT EXISTS `%prefix%captchas` (
		`captcha_id` BIGINT NOT NULL AUTO_INCREMENT,
		`time` INT NOT NULL,
		`ip_address` varchar(16) NOT NULL DEFAULT '0',
		`secret` varchar(20) NOT NULL,

		KEY `secret` (`secret`),

		PRIMARY KEY `id` (`captcha_id`)
	);


-- --------------------------------------------------------
-- Add foreign keys
-- --------------------------------------------------------

	ALTER TABLE `%prefix%access`
	ADD CONSTRAINT `%prefix%access_foreign_1`
		FOREIGN KEY (`key_id`) REFERENCES `%prefix%access_keys` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE;

	ALTER TABLE `%prefix%user_data`
	ADD CONSTRAINT `%prefix%users_forgein_1`
		FOREIGN KEY (`user_id`) REFERENCES `%prefix%users` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE;

	ALTER TABLE `%prefix%user_fields`
	ADD CONSTRAINT `%prefix%users_forgein_2`
		FOREIGN KEY (`id`) REFERENCES `%prefix%user_data` (`id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE;


-- --------------------------------------------------------
-- Insert default values
-- --------------------------------------------------------

	-- Meta table
	INSERT INTO `%prefix%settings` (`key`, `value`)
	VALUES	('auth.incorrect_login', 'users/login'),
			('auth.login', 'admin/dashboard'),
			('auth.logout', 'users/login'),		
			('auth.remember', 'true'),

			('user.captcha', 'none'),
			('user.defaultGroup', 3), -- User group
			('user.guestGroup', 4), -- Guest group
			('user.letterRegister', 'Thank you for registering at %website%. Click here to activate your account: %link%.'),
			('user.letterRecovery', 'Somebody (probably you) requested a password recovery. Click here to change your password now: %link%.'),
			('user.needsActivation', 'true'),
			('user.registrationEnabled', 'true');

	-- User groups
	INSERT INTO `%prefix%groups` (`id`, `rank`, `title`, `description`)
	VALUES	(1, 1, 'Admin', 'Super-Administrator'),
			(2, 10, 'Editor', 'Content publisher'),
			(3, 100, 'User', 'Default registered user group'),
			(4, 1000, 'Guest', 'Unregistered user group');

	-- Access keys
	INSERT INTO `%prefix%access_keys` (`id`, `key`, `name`, `description`)
	VALUES	(1, 'createUser', 'Create user', 'Create new user'),
			(2, 'editUser', 'Edit user', 'Edit user information'),
			(3, 'deleteUser', 'Delete user', 'Completely remove a user and all associated data');

	INSERT INTO `%prefix%access` (`key_id`, `id`, `allow`, `group`)
	VALUES	(1, 1, 1, 1), -- Admin
			(2, 1, 1, 1),
			(3, 1, 1, 1);

