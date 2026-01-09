<?php
/**
 * Tripadvisor API integration
 *
 * Fetches and caches featured experiences from Tripadvisor API.
 */

/**
 * Get featured experiences from Tripadvisor API
 *
 * @return array Array of experience items, or empty array on failure
 */
function heycartagena_tripadvisor_get_featured_experiences(): array {
	// Check if API is configured
	if ( ! defined( 'HEY_TRIPADVISOR_ENDPOINT' ) || ! defined( 'HEY_TRIPADVISOR_KEY' ) ) {
		return [];
	}

	$endpoint = HEY_TRIPADVISOR_ENDPOINT;
	$key      = HEY_TRIPADVISOR_KEY;

	if ( empty( $endpoint ) || empty( $key ) ) {
		return [];
	}

	// Check cache first (6 hours)
	$cache_key = 'heycartagena_tripadvisor_experiences';
	$cached    = get_transient( $cache_key );

	if ( false !== $cached ) {
		return $cached;
	}

	// Fetch from API
	$response = wp_remote_get(
		$endpoint,
		[
			'timeout' => 10,
			'headers' => [
				'Authorization' => 'Bearer ' . $key,
				'Accept'        => 'application/json',
			],
		]
	);

	// Check for errors
	if ( is_wp_error( $response ) ) {
		return [];
	}

	$status_code = wp_remote_retrieve_response_code( $response );
	if ( $status_code < 200 || $status_code >= 300 ) {
		return [];
	}

	// Parse JSON
	$body = wp_remote_retrieve_body( $response );
	$data = json_decode( $body, true );

	if ( json_last_error() !== JSON_ERROR_NONE || ! is_array( $data ) ) {
		return [];
	}

	// Intentionally return raw decoded JSON without schema normalization.
	// This function is schema-agnostic and makes no assumptions about the API response structure.
	// Schema mapping will be added once a real sample response is confirmed.
	$result = [
		'_raw' => $data,
	];

	// Cache for 6 hours
	set_transient( $cache_key, $result, 6 * HOUR_IN_SECONDS );

	return $result;
}

