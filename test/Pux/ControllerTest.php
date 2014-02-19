<?php
use Pux\Mux;
use Pux\Executor;
use Pux\Controller;

class CRUDProductController extends Controller
{
    public function indexAction() 
    {

    }

    public function addAction() {

    }

    public function delAction() {

    }

}

class ControllerTest extends PHPUnit_Framework_TestCase
{

    public function testControllerConstructor() {
        $controller = new CRUDProductController;
        ok($controller);
        return $controller;
    }

    /**
     * @depends testControllerConstructor
     */
    public function testGetActionMethods($controller)
    {
        $actions = $controller->getActionMethods();
        ok($actions);
        ok( is_array($actions), 'is array' );
        count_ok( 3, $actions);
    }

    /**
     * @depends testControllerConstructor
     */
    public function testGetActionRoutes($controller) {
        $paths = $controller->getActionRoutes();
        ok($paths);
        count_ok(3, $paths);
        ok( is_array($paths[0]) );
        ok( is_array($paths[1]) );
        ok( is_array($paths[2]) );
    }

    /**
     * @depends testControllerConstructor
     */
    public function testExpand($controller)
    {
        $mux = $controller->expand();
        ok($mux);
        ok( $routes = $mux->getRoutes() );
        count_ok( 3, $routes );
    }

    /**
     * @depends testControllerConstructor
     */
    public function testToJson($controller)
    {
        ok( $controller->toJson(array('foo' => 1) ) );
    }

    /**
     * @depends testControllerConstructor
     */
    public function testMount($controller) {
        $mainMux = new Mux;
        $mainMux->mount( '/product' , $controller->expand() );
        ok( $mainMux->getRoutes() ); 
        ok( $mainMux->dispatch('/product') );
        ok( $mainMux->dispatch('/product/add') );
        ok( $mainMux->dispatch('/product/del') );
    }

    /**
     * @depends testControllerConstructor
     */
    public function testMountNoExpand($controller) {
        $mainMux = new Mux;
        $mainMux->expand = false;
        $mainMux->mount( '/product' , $controller->expand() );
        ok( $mainMux->getRoutes() ); 
        ok( $r = $mainMux->dispatch('/product') );
        ok( $r = $mainMux->dispatch('/product/add') );
        ok( $r = $mainMux->dispatch('/product/del') );
    }

}

