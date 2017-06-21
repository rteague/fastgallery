
create table `accounts` (
    `id` int(6) unsigned not null auto_increment,
    `modified_by` int(6) unsigned not null,
    `username` varchar(32) default null,
    `email` varchar(255) default null,
    `password` text,
    `first_name` varchar(255) default null,
    `last_name` varchar(255) default null,
    `permissions` enum('S','A','E') default null,
    `status` enum('A','S') default null,
    `deleted` tinyint(1) unsigned default '0',
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
    `uri` varchar(255) default null,
    `content` mediumtext,
    `postition` int(10) unsigned default '0',
    `deleted` tinyint(1) unsigned default '0',
    `is_published` tinyint(1) unsigned default '0',
    `publish_date` datetime default null,
    `create_date` datetime default null,
    `modified_date` datetime default null,
    `delete_date` datetime default null,
    primary key (`id`),
    fulltext `title_content` (`title`, `content`),
    foreign key (`modified_by`) references `accounts` (`id`) 
) default charset=utf8;

create table `categories` (
    `id` tinyint(2) unsigned not null auto_increment,
    `modified_by` int(6) unsigned not null,
    `title` varchar(255) default null,
    `description` text,
    `deleted` tinyint(1) unsigned default '0',
    `create_date` datetime default null,
    `modified_date` datetime default null,
    `delete_date` datetime default null,
    primary key (`id`),
    fulltext `title_description` (`title`, `description`),
    foreign key (`modified_by`) references `accounts` (`id`)
) default charset=utf8;

create table `photos` (
    `id` int(10) unsigned not null auto_increment,
    `modified_by` int(6) unsigned not null,
    `category_id` tinyint(2) unsigned not null,
    `title` varchar(255) default null,
    `description` text,
    `store_link` text,
    `original_image` text default null,
    `large_image` text default null,
    `medium_image` text default null,
    `small_image` text default null,
    `thumbnail_image` text default null,
    `deleted` tinyint(1) unsigned default '0',
    `is_published` tinyint(1) unsigned default '0',
    `publish_date` datetime default null,
    `create_date` datetime default null,
    `modified_date` datetime default null,
    `delete_date` datetime default null,
    primary key (`id`),
    fulltext `title_description` (`title`, `description`), 
    foreign key (`modified_by`) references `accounts` (`id`),
    foreign key (`category_id`) references `categories` (`id`)
) default charset=utf8;

create table `galleries` (
    `id` int(10) unsigned not null auto_increment,
    `modified_by` int(6) unsigned not null,
    `title` varchar(255) default null,
    `description` mediumtext,
    `store_link` text,
    `deleted` tinyint(1) unsigned default '0',
    `is_published` tinyint(1) unsigned default '0',
    `publish_date` datetime default null,
    `create_date` datetime default null,
    `modified_date` datetime default null,
    `delete_date` datetime default null,
    primary key (`id`),
    fulltext `title_description` (`title`, `description`),
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

create table `tags_photos` (
    `id` bigint(12) unsigned not null auto_increment,
    `tag_id` int(10) unsigned not null,
    `photo_id` int(10) unsigned not null,
    primary key (`id`),
    foreign key (`tag_id`) references `tags` (`id`),
    foreign key (`photo_id`) references `photos` (`id`)
) default charset=utf8;

create table `tags_galleries` (
    `id` bigint(12) unsigned not null auto_increment,
    `tag_id` int(10) unsigned not null,
    `gallery_id` int(10) unsigned not null,
    primary key (`id`),
    foreign key (`tag_id`) references `tags` (`id`),
    foreign key (`gallery_id`) references `galleries` (`id`)
) default charset=utf8;

create table `subscribers` (
    `id` int(10) unsigned not null auto_increment,
    `modified_by` int(6) unsigned not null,
    `email` varchar(255) default null,
    `subscribed` tinyint(1) unsigned default '0',
    `deleted` tinyint(1) unsigned default '0',
    `create_date` datetime default null,
    `modified_date` datetime default null,
    `delete_date` datetime default null,
    primary key (`id`),
    foreign key (`modified_by`) references `accounts` (`id`)
) default charset=utf8;

create table `settings` (
    `key` varchar(32) not null,
    `value` text,
    `label` varchar(64) not null default '',
    `description` text,
    `category` enum('Meta', 'Proprietor', 'Application', 'Copyright', 'Terms', 'Privacy') not null,
    primary key (`key`)
) default charset=utf8;


