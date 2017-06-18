
create table `accounts` (
    `id` int(6) unsigned not null auto_increment,
    `modified_by` int(6) unsigned NOT NULL,
    `username` varchar(32) default null,
    `email` varchar(255) default null,
    `password` text,
    `first_name` varchar(255) default null,
    `last_name` varchar(255) default null,
    `permissions` enum('S','A','E','W') default null,
    `status` enum('A','S') default null,
    `deleted` tinyint(1) unsigned DEFAULT '0',
    `create_date` datetime default null,
    `modified_date` datetime default null,
    `delete_date` datetime default null,
    primary key (`id`),
    foreign key (`modified_by`) references `accounts` (`id`)
) default charset=utf8;

create table `pages` (
    `id` smallint(3) unsigned not null auto_increment,
    `modified_by` int(6) unsigned not null,
    `title` varchar(255) default null,
    `slug` varchar(255) default null,
    `content` mediumtext,
    `deleted` tinyint(1) unsigned default '0',
    `publish_date` datetime default null,
    `create_date` datetime default null,
    `modified_date` datetime default null,
    `delete_date` datetime default null,
    primary key (`id`),
    foreign key (`modified_by`) references `accounts` (`id`) 
) default charset=utf8;

create table `photos` (
    `id` int(10) unsigned not null auto_increment,
    `modified_by` int(6) unsigned not null,
    `title` varchar(255) default null,
    `description` mediumtext,
    `original_image` text default null,
    `resized_image` text default null,
    `thumbnail_image` text default null,
    `deleted` tinyint(1) unsigned default '0',
    `publish_date` datetime default null,
    `create_date` datetime default null,
    `modified_date` datetime default null,
    `delete_date` datetime default null,
    primary key (`id`),
    foreign key (`modified_by`) references `accounts` (`id`)
) default charset=utf8;

create table `galleries` (
    `id` int(10) unsigned not null auto_increment,
    `modified_by` int(6) unsigned not null,
    `title` varchar(255) default null,
    `description` mediumtext,
    `deleted` tinyint(1) unsigned default '0',
    `create_date` datetime default null,
    `modified_date` datetime default null,
    `delete_date` datetime default null,
    primary key (`id`),
    foreign key (`modified_by`) references `accounts` (`id`) 
) default charset=utf8;

create table `galleries_photos` (
    `id` bigint(12) unsigned not null auto_increment,
    `gallery_id` int(10) unsigned not null,
    `photo_id` int(10) unsigned not null,
    `is_cover` tinyint(1) unsigned default '0',
    `postition` int(10) unsigned default '0',
    primary key (`id`),
    foreign key (`gallery_id`) references `galleries` (`id`),
    foreign key (`photo_id`) references `photos` (`id`)
) default charset=utf8;

create table `tags` (
    `id` int(10) unsigned not null auto_increment,
    `modified_by` int(6) unsigned not null,
    `title` varchar(255) default null,
    `create_date` datetime default null,
    `modified_date` datetime default null,
    primary key (`id`),
    foreign key (`modified_by`) references `accounts` (`id`) 
) default charset=utf8;

create table `settings` (
    `key` varchar(32) not null,
    `value` text,
    primary key (`key`)
) default charset=utf8;


