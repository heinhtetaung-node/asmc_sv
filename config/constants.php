<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('WEB_TITLE', 'sds');
define('BASE_PATH', '/home/sgdatacrm//public_html/asmc/');

define('CONTRACT_PATH', BASE_PATH.'pdf/contract/');
define('RISK_PATH', BASE_PATH.'pdf/risk/');
define('IRAS_PATH', BASE_PATH.'pdf/iras/');
define('RECEIPT_PATH', BASE_PATH.'pdf/receipts/');
define('AGREEMENT_PATH', BASE_PATH.'pdf/agreements/');
define('PAYOUT_PATH', BASE_PATH.'pdf/payout/');
define('NRIC_PATH', BASE_PATH.'pdf/nric/');
define('WORKSHEET_PATH', BASE_PATH.'pdf/worksheet/');
define('BANK_PATH', BASE_PATH.'pdf/bank/');
define('COMFORT_PATH', BASE_PATH.'pdf/comfort/');

define('BASE_URL', 'http://localhost/asmc/crm/');
define('CONTRACT_URL', BASE_URL.'pdf/contract/');
define('RISK_URL', BASE_URL.'pdf/risk/');
define('IRAS_URL', BASE_URL.'pdf/iras/');
define('AGREEMENT_URL', BASE_URL.'pdf/agreements/');
define('PAYOUT_URL', BASE_URL.'pdf/payout/');
define('NRIC_URL', BASE_URL.'pdf/nric/');
define('WORKSHEET_URL', BASE_URL.'pdf/worksheet/');
define('BANK_URL', BASE_URL.'pdf/bank/');
define('COMFORT_URL', BASE_URL.'pdf/comfort/');
define('RECEIPT_URL', BASE_URL.'pdf/receipts/');

define('LOGO_PATH', BASE_PATH.'images/logo.png');


define('RECEIPT_PREFIX', 'BM');
define('EMAIL_SENDER', 'mailer@asmc.com.sg');


define('SMTP_HOST', 'cpanel2.sgdatahub.com');
define('SMTP_PORT', '465'); 
define('SMTP_CRYPTO', 'tls');
define('SMTP_USER', 'testmail@sgdatacrm.com');
define('SMTP_PASS', 'testmail');


/* End of file constants.php */
/* Location: ./application/config/constants.php */