<?php
/*
 * Copyright (C) 2013 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
//  Author: Jenny Murphy - http://google.com/+JennyMurphy

// TODO: You must configure these fields for the starter project to function.
// Visit https://developers.google.com/glass/getting-started to learn more

require_once(dirname(__FILE__) . '/../../../wp-load.php');
require_once(dirname(__FILE__) . '/../../../wp-admin/includes/upgrade.php');

$domain_name = 'http://www.avsaro.com';

$application_name = "GlassPress";
$api_client_id = get_option('glasspress_api_client_id');
$api_client_secret = get_option('glasspress_api_client_secret');
$api_simple_key = get_option('glasspress_api_key');

$base_url = plugins_url().'/glasspress';


// This should be writable by your web server's user
global $wpdb;
$table_name = $wpdb->prefix . "glasspress_subscribers";
