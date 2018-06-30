<?php
namespace Tests\Framework;

use Framework\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{

    private $renderer;


    public function setUp()
    {
        $this->renderer = new Renderer\PHPRenderer(__DIR__.'/views');
    }//end setUp()


    public function testRenderTheRightPath()
    {
        $this->renderer->addPath('blog', __DIR__.'/views');
        $content = $this->renderer->render('@blog/demo');
        $this->assertEquals('Salut les gens', $content);
    }//end testRenderTheRightPath()


    public function testRenderTheDefaultPath()
    {
        $content = $this->renderer->render('demo');
        $this->assertEquals('Salut les gens', $content);
    }//end testRenderTheDefaultPath()


    public function testRenderWithParams()
    {
        $content = $this->renderer->render('demoparams', ['nom' => 'Marc']);
        $this->assertEquals('Salut Marc', $content);
    }//end testRenderWithParams()


    public function testGlobalParameters()
    {
        $this->renderer->addGlobal('nom', 'Marc');
        $content = $this->renderer->render('demoparams');
        $this->assertEquals('Salut Marc', $content);
    }//end testGlobalParameters()
}//end class
