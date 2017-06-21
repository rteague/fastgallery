
# settings

insert into `settings` values
('site_name', 'fastgallery', 'Site Name', 'The site\'s name.', 'Meta'),
('site_desc', NULL, 'Site Description', 'The site\'s description.', 'Meta'),
('artist', NULL, 'Artist', 'The name of primary owner(s) of the site.', 'Proprietor'),
('artist_statement', NULL, 'Artist Statement', 'What do you have to say about your work?', 'Proprietor'),
('artist_phone', '(281) 330-8004', 'Artist Phone', '', 'Proprietor'),
('artist_email', NULL, 'Artist Email Address', '', 'Proprietor'),
('artist_address', NULL, 'Artist Address', '', 'Proprietor'),
('gallery_limit', 100, 'Gallery Limit', 'Max number of images per gallery.', 'Application'),
('image_view', 1, 'Image View', 'Image view with a panel to the right with image data, or no?', 'Application'),
('show_image_desc', 'a:2:{s:5:"title";i:1;s:4:"desc";i:1;}', 'Show Image Description', 'Show image description (No right panel view only).', 'Application'),
('show_image_meta', 1, 'Show Image Meta', 'Show show lens info, aperture, shutter speed, and ISO.', 'Application'),
('show_store_link', 0, 'Show Store Link', 'For each photo, show them where you can buy it!', 'Application'),
('thumbnail_size', '100x150', 'Thumbnail Size', 'How big do you want your thumbnails to display in galleries?', 'Application'),
('time_zone', NULL, 'Time Zone', 'Where on this planet do you live?', 'Application'),
('locale', NULL, 'Locale', 'What language does your primary audience speak, where a they from?', 'Application'),
('aws_access_key', NULL, 'AWS Access Key', '', 'Application'),
('aws_secret_key', NULL, 'AWS Secret Key', '', 'Application'),
('s3_storage', 0, 'AWS S3 Storage', 'Store all content in an aws bucket?', 'Application'),
('s3_bucket', NULL, 'AWS S3 Bucket', 'The bucket in which to store content.', 'Application'),
('flush_cache', NULL, 'Flush Cache', '', 'Application'),
('copyright', NULL, 'Copyright', 'What is copyrighted?', 'Copyright'),
('terms', NULL, 'Terms', 'What are your terms for using your site?', 'Terms'),
('privacy', NULL, 'Privacy', 'What is your privacy policy?', 'Privacy')
;

# default account
insert into accounts values
(null, 1, 'admin', null, '', null, null, 'S', 'A', 0, now(), now(), null)
;

# default gallery
insert into galleries values
(NULL, 1, 'Gallery', 'Default Gallery', '', 0, 1, now(), now(), now(), null)
;


