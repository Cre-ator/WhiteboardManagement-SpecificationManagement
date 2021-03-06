<?php
require_once SPECMANAGEMENT_CORE_URI . 'specmanagement_database_api.php';

auth_reauthenticate();

$specmanagement_database_api = new specmanagement_database_api();
$version_id = gpc_get_int( 'version_id' );
$version = version_get( $version_id );

access_ensure_project_level( config_get( 'manage_project_threshold' ), $version->project_id );

helper_ensure_confirmed( lang_get( 'version_delete_sure' ) .
   '<br/>' . lang_get( 'word_separator' ) . string_display_line( $version->version ),
   lang_get( 'delete_version_button' ) );

$plugin_version_row = $specmanagement_database_api->get_plugin_version_row_by_version_id( $version_id );
$p_version_id = $plugin_version_row[0];

$specmanagement_database_api->update_source_version_set_null( $p_version_id );
$specmanagement_database_api->delete_version_row( $version_id );
version_remove( $version_id );

print_successful_redirect( plugin_page( 'manage_versions', true ) );