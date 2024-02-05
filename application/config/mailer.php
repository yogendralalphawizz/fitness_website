<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	Send Message Method
	mail = Send messages using PHP's mail() function.
	smtp = Send messages using SMTP.
	sendmail = Send messages using $Sendmail.
	qmail = Send messages using qmail.
*/
$config['method'] = 'smtp';

/*
	Enable verbose debug output (for SMTP)
	0 = Debug level for no output
	1 = Debug level to show client -> server messages.
	2 = Debug level to show client -> server and server -> client messages.
	3 = Debug level to show connection status, client -> server and server -> client messages.
	4 = Debug level to show all messages.
*/
$config['SMTPDebug'] = 0;

// Set the SMTP server to send through
$config['Host'] = 'jobs.xeniumbiocorp.com';

// SMTP username
$config['Username'] = 'info@jobs.xeniumbiocorp.com';

// SMTP password
$config['Password'] = 'info@jobs.xeniumbiocorp.com';

// TCP port to connect to, use 25, 465 or 587
$config['Port'] = 465;

/*
	Enable TLS encryption
	for port 465, use 'ssl'
	for port 587, use 'tls'
*/
$config['SMTPSecure'] = 'ssl';

// Enable SMTP authentication (true or false)
$config['SMTPAuth'] = true;

// Timeout
$config['Timeout'] = 10;

// Charset
$config['CharSet'] = 'UTF-8';

// From Config
$config['fromName'] = 'Cosec';
$config['fromEmail'] = 'info@jobs.xeniumbiocorp.com';