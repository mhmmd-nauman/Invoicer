<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['useragent'] = 'CodeIgniter';
$config['protocol'] = 'smtp';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['smtp_host'] = '';
$config['smtp_user'] = '';
$config['smtp_pass'] = '';
$config['smtp_port'] = 465;
$config['smtp_timeout'] = 5;
$config['smtp_keepalive'] = FALSE;
$config['smtp_crypto'] = '';
$config['wordwrap'] = TRUE;
$config['wrapchars'] = 76;
$config['mailtype'] = 'html';
$config['validate'] = FALSE;
$config['priority'] = 3;
$config['crlf'] = '\n';
$config['newline'] = '\n';
$config['bcc_batch_mode'] = FALSE;
$config['bcc_batch_size'] = 200;
$config['dsn'] = FALSE;
