<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Overview : agm,cem , rhm
$route['overview/(:any)'] = 'overview/view/$1';
$route['overview'] = 'overview/view';

// Research 
$route['research']['post'] = 'restsearch/index_post';
$route['research']['get'] = 'restsearch/index_get';
$route['research'] = 'restsearch/index_get';
$route['restsearchdetail']['post'] = 'restsearchdetail/index_post';

// Fastq
$route['fastq/download'] = 'fastq/download';
$route['fastqfile']['post'] = 'fastqfile/index_post';
$route['fastq'] = 'fastq/index';

// Contact
$route['contact'] = 'contact/index';

//UserMng
$route['usermng'] = 'usermng/index_get';

$route['default_controller'] = 'pages/view';

$route['(:any)'] = 'pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
