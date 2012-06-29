<?php
class JsonHandlerTest extends SapphireTest {
	function testcloneJson() {
		$repo = $this->getMock('VcsRepository');
		
		$driver = $repo->getDriver();
		$this->assertType('VcsRepository', $driver); 
	}
}		