<?php
// defined('BASEPATH') or exit('No direct script access allowed');
// // DataTables PHP library
// var_dump(require( "../../vendor/datatables.net/editor-php/DataTables.php" ));
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$path=dirname( __FILE__, 3 );
// echo $path.'\vendor\datatables.net\editor-php\DataTables.php';
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
    $id=array_keys($_POST['data']);
    $bid=$id[0];
    // var_dump($id[0]);
    // die;
    //     print_r($_POST['data'][$id]);
    //     die;

    Editor::inst( $db, 'geopos_product_cat' )
    ->debug()
        ->fields(
            Field::inst( 'geopos_product_cat.id as cat_id' )->set( false ),
            Field::inst( 'geopos_product_cat.title' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'geopos_product_cat.extra' )->validator( 'Validate::notEmpty' ),
            Field::inst( 'geopos_product_cat.rel_id')->setValue($_POST['data'][$bid]['rel_id'])->validator( 'Validate::notEmpty' ),
            Field::inst( 'geopos_product_cat.c_type' )->setValue($_POST['data'][$bid]['c_type'])
        )
        ->leftJoin( 'geopos_product_cat as rel_id', 'geopos_product_cat.rel_id', '=', 'rel_id.id' )
        ->process( $_POST )
        ->json();
       

?>
