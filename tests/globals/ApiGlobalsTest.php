<?php

namespace Tests\globals;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Database\Seeder;
use Api\Helpers\UserHelper;
use Api\Models\GlobalUserModel;

class ApiGlobalsTest extends TestCase
{
	protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    public function Login()
	{
		$data = ['email'=>'dev@bugginho.com', 'password'=>'admin'];

		$token = $this->post('/api/login', $data)
					  ->assertResponseStatus(200);

		return $token->response->original['token'];
	}

    public function testCreateOrderConfigsGlobals()
    {
    	$token = $this->Login();

    	$data = ["global"=> 1,  "option"=> 1];

    	$this->post('/api/configs/global', $data, array("Authorization" => 'Bearer '.$token))
        	 ->assertResponseStatus(200)
        	 ->seeJson(["status"=> true]);

    }

    public function testCreateConfigsGlobalsValue()
    {
        $token = $this->Login();

        $data = ["global"=> 1,  "value"=> "teste"];

        $this->post('/api/configs/global', $data, array("Authorization" => 'Bearer '.$token))
             ->assertResponseStatus(200)
             ->seeJson(["status"=> true]);

    }

    public function testErroCreateConfigsGlobalsNotGlobal()
    {
        $token = $this->Login();

        $data = ["option"=> 1,  "value"=> "teste"];

        $this->post('/api/configs/global', $data, array("Authorization" => 'Bearer '.$token))
             ->assertResponseStatus(400)
             ->seeJson(["error"=> "globalId required"]);
    }

    public function testErroCreateConfigsGlobalsNotOptionNotValue()
    {
        $token = $this->Login();

        $data = ["global"=> 1];

        $this->post('/api/configs/global', $data, array("Authorization" => 'Bearer '.$token))
             ->assertResponseStatus(400)
             ->seeJson(["error"=> "option or value required"]);
    }

    public function testCreateOrderConfigsGlobalsOptionInvalid()
    {
        $token = $this->Login();

        $data = ["global"=> 1,  "option"=> 6];

        $this->post('/api/configs/global', $data, array("Authorization" => 'Bearer '.$token))
             ->assertResponseStatus(400)
             ->seeJson(["error"=> "option invalid"]);

    }

    public function testAlterOrderConfigsGlobals()
    {
    	$token = $this->Login();

    	$data = ["id"=> 3, "global"=> 1,  "option"=> 1];

    
    	$this->post('/api/configs/global', $data, array("Authorization" => 'Bearer '.$token))
        	 ->assertResponseStatus(200)
        	 ->seeJson(["status"=> true]);

    }

    public function testAlterOrderConfigsGlobalsValue()
    {
        $token = $this->Login();

        $data = ["id"=> 6, "global"=> 2,  "Value"=> "VALOR DE"];

    
        $this->post('/api/configs/global', $data, array("Authorization" => 'Bearer '.$token))
             ->assertResponseStatus(200)
             ->seeJson(["status"=> true]);

    }

    public function testListConfigsGlobals()
    {
        $token = $this->Login();


        $this->get('/api/configs/global', array("Authorization" => 'Bearer '.$token))
             ->assertResponseStatus(200)
             ->seeJsonStructure(["data"=>[["id", "name", "value"]],"globals"=>[["id", "name", "title","type", 'options'=>[["id", "alias", "value"]]]]]);
    }

}