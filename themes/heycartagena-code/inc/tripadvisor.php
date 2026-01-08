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

	// TODO: Map schema here once we have a sample response
	// For now, return raw data in a safe wrapper
	// Expected structure (to be confirmed):
	// - If data contains 'data' array: normalize items with title, image, rating, link
	// - Otherwise: return raw structure for inspection

	$experiences = [];

	// Defensive parsing: only normalize if obvious fields exist
	if ( isset( $data['data'] ) && is_array( $data['data'] ) ) {
		foreach ( $data['data'] as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}

			$experience = [
				'title' => isset( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '',
				'image' => isset( $item['image'] ) ? esc_url_raw( $item['image'] ) : '',
				'rating' => isset( $item['rating'] ) ? floatval( $item['rating'] ) : 0,
				'link'   => isset( $item['link'] ) ? esc_url_raw( $item['link'] ) : '',
			];

			// Only add if we have at least a title
			if ( ! empty( $experience['title'] ) ) {
				$experiences[] = $experience;
			}
		}
	} else {
		// Schema unknown - return raw data wrapped safely
		// This allows inspection while we determine the actual schema
		$experiences = [
			'_raw' => $data,
			'_note' => 'Schema mapping needed - see inc/tripadvisor.php',
		];
	}

	// Cache for 6 hours
	set_transient( $cache_key, $experiences, 6 * HOUR_IN_SECONDS );

	return $experiences;
}

