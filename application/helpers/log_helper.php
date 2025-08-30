<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_client_ip() {
    return $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
}

function get_browser_info() {
    return $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
}

function log_action($CI, $action, $details = '') {
    $user = $CI->session->userdata('user');

    // Don't log Super Admin
    if (!$user || $user['em_role'] === 'SUPER ADMIN') return;

    $data = [
        'emp_id'       => $user['em_id'], // Assuming em_id comes from employee table
        'emp_name'     => $user['first_name'] . ' ' . $user['last_name'],
        'role'         => $user['em_role'],
        'action'       => $action,
        'details'      => $details,
        'ip_address'   => get_client_ip(),
        'browser_info' => get_browser_info()
    ];

    $CI->db->insert('logs', $data);
}
