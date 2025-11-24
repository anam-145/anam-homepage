<?php
// Rhymix System Configuration

// Load environment variables from .env file
function loadEnv($path) {
	if (!file_exists($path)) {
		throw new Exception('.env file not found at: ' . $path);
	}
	$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lines as $line) {
		if (strpos(trim($line), '#') === 0) continue;
		list($name, $value) = explode('=', $line, 2);
		$name = trim($name);
		$value = trim($value);
		if (!array_key_exists($name, $_ENV) && !getenv($name)) {
			putenv("$name=$value");
			$_ENV[$name] = $value;
		}
	}
}

// Load .env file if exists (optional - can use system environment variables instead)
$envFile = __DIR__ . '/../../.env';
if (file_exists($envFile)) {
	loadEnv($envFile);
}

return array(
	'config_version' => '2.0',
	'db' => array(
		'master' => array(
			'type' => getenv('DB_TYPE') ?: 'mysql',
			'host' => getenv('DB_HOST') ?: 'localhost',
			'port' => getenv('DB_PORT') ?: '3306',
			'user' => getenv('DB_USER'),
			'pass' => getenv('DB_PASS'),
			'database' => getenv('DB_NAME'),
			'prefix' => getenv('DB_PREFIX') ?: 'wp_',
			'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
			'engine' => getenv('DB_ENGINE') ?: 'innodb',
		),
	),
	'cache' => array(
		'type' => 'apc',
		'ttl' => 86400,
		'servers' => array(),
		'truncate_method' => 'delete',
		'cache_control' => 'must-revalidate, no-store, no-cache',
	),
	'ftp' => array(
		'host' => 'localhost',
		'port' => 21,
		'path' => NULL,
		'user' => NULL,
		'pass' => NULL,
		'pasv' => true,
		'sftp' => false,
	),
	'crypto' => array(
		'encryption_key' => getenv('CRYPTO_ENCRYPTION_KEY'),
		'authentication_key' => getenv('CRYPTO_AUTHENTICATION_KEY'),
		'session_key' => getenv('CRYPTO_SESSION_KEY'),
	),
	'locale' => array(
		'default_lang' => getenv('APP_DEFAULT_LANG') ?: 'en',
		'enabled_lang' => array(
			'ko',
			'en',
		),
		'auto_select_lang' => false,
		'default_timezone' => getenv('APP_TIMEZONE') ?: 'Asia/Seoul',
		'internal_timezone' => 32400,
	),
	'url' => array(
		'default' => isset($_SERVER['HTTP_HOST']) ? '//'.$_SERVER['HTTP_HOST'].'/' : '/',
		'unregistered_domain_action' => 'display',
		'http_port' => NULL,
		'https_port' => NULL,
		'ssl' => 'none',
		'rewrite' => 0,
	),
	'session' => array(
		'autologin_lifetime' => 365,
		'autologin_refresh' => true,
		'delay' => false,
		'use_db' => false,
		'use_ssl' => false,
		'use_ssl_cookies' => false,
		'httponly' => true,
		'samesite' => 'Lax',
		'domain' => NULL,
		'path' => NULL,
		'lifetime' => 0,
		'refresh' => 300,
	),
	'cookie' => array(
		'domain' => NULL,
		'path' => NULL,
		'secure' => NULL,
		'httponly' => NULL,
		'samesite' => 'Lax',
	),
	'file' => array(
		'folder_structure' => 2,
		'umask' => '0022',
	),
	'mail' => array(
		'type' => getenv('MAIL_TYPE') ?: 'mailfunction',
		'default_name' => getenv('MAIL_DEFAULT_NAME') ?: '안암145',
		'default_from' => getenv('MAIL_DEFAULT_FROM'),
		'default_force' => true,
		'default_reply_to' => getenv('MAIL_DEFAULT_REPLY_TO'),
		'mailfunction' => array(),
	),
	'view' => array(
		'partial_page_rendering' => 'internal_only',
		'manager_layout' => 'module',
		'minify_scripts' => 'all',
		'concat_scripts' => 'css,js',
		'delay_compile' => 0,
		'jquery_version' => 2,
	),
	'admin' => array(
		'allow' => array(),
		'deny' => array(),
	),
	'lock' => array(
		'locked' => false,
		'title' => 'Maintenance',
		'message' => '',
		'allow' => array(),
	),
	'debug' => array(
		'enabled' => getenv('APP_DEBUG') === 'true' ? true : false,
		'log_slow_queries' => 0.25,
		'log_slow_triggers' => 0.25,
		'log_slow_widgets' => 0.25,
		'log_slow_remote_requests' => 1.25,
		'log_filename' => 'files/debug/YYYYMMDD.php',
		'display_type' => array(
			'comment',
		),
		'display_content' => array(
			'request_info',
			'entries',
			'errors',
			'queries',
		),
		'display_to' => 'admin',
		'query_comment' => false,
		'query_full_stack' => false,
		'consolidate' => true,
		'write_error_log' => 'fatal',
		'allow' => array(),
	),
	'seo' => array(
		'main_title' => '',
		'subpage_title' => '',
		'document_title' => '',
		'og_enabled' => false,
		'og_extract_description' => false,
		'og_extract_images' => false,
		'og_extract_hashtags' => false,
		'og_use_nick_name' => false,
		'og_use_timestamps' => false,
	),
	'mediafilter' => array(
		'whitelist' => array(),
		'classes' => array(),
	),
	'security' => array(
		'robot_user_agents' => array(),
		'check_csrf_token' => false,
		'nofollow' => false,
		'x_frame_options' => 'SAMEORIGIN',
		'x_content_type_options' => 'nosniff',
	),
	'mobile' => array(
		'enabled' => false,
		'tablets' => false,
		'viewport' => 'width=device-width, initial-scale=1.0, user-scalable=yes',
	),
	'namespaces' => array(
		'mapping' => array(),
		'regexp' => '',
	),
	'use_rewrite' => false,
	'use_sso' => false,
	'other' => array(
		'proxy' => '',
	),
	'sms' => array(
		'default_from' => '',
		'default_force' => true,
		'type' => 'dummy',
		'dummy' => array(),
		'allow_split' => array(
			'sms' => true,
			'lms' => true,
		),
	),
	'push' => array(
		'types' => array(),
		'allow_guest_device' => false,
		'apns' => array(
			'certificate' => NULL,
			'passphrase' => NULL,
		),
		'fcm' => array(
			'api_key' => NULL,
		),
		'fcmv1' => array(
			'service_account' => NULL,
		),
	),
);
