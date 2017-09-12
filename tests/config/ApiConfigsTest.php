<?php

namespace Tests\config;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Database\Seeder;
use Api\Helpers\UserHelper;
use Api\Models\GlobalUserModel;

class ApiConfigsTest extends TestCase
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

    public function testAlterConfigs()
    {
    	$token = $this->Login();

    	$data = ["btg"=> 1,  "limit"=> 1];

    	$this->post('/api/config/', $data, array("Authorization" => 'Bearer '.$token))
        	 ->assertResponseStatus(200)
        	 ->seeJson(["status"=> true]);

    }

    public function testGetConfigs()
    {
        $token = $this->Login();

        $this->get('/api/config/', array("Authorization" => 'Bearer '.$token))
             ->assertResponseStatus(200)
             ->seeJson(["btg"=> 1, "limit"=> 1]);

    }
}