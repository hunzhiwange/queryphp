<?php
use PHPUnit\Framework\TestCase;
class ExampleTest2 extends TestCase 

{
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample() {
        
        // echo log::runs('222','debug');
        $this->assertEquals ( "say", 'say' );
    }
}
