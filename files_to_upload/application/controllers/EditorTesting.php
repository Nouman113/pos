<?php
// // DataTables PHP library
$path=dirname( __FILE__, 3 );
require_once $path.'\vendor\datatables.net\editor-php\DataTables.php';

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;
        
    Editor::inst( $db, 'geopos_product_cat' )
        ->fields(
            Field::inst( 'id' )->set( false ),
            Field::inst( 'title' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'extra' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'c_type' )
        )
        ->process( $_POST )
        ->json();
       

?>