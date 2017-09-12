<?php

namespace Tests\theme;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Database\Seeder;
use Api\Helpers\UserHelper;
use Api\Models\ThemeModel;

class ApiThemeTest extends TestCase
{
	protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    public $data = ["userId"=>1, "name"=>"teste",'configs'=>'{"header":"<html> <\/html>","footer":"<html> <\/html>","font":"Arial Black","quantity":"11","backgroundColor":"#ffffff","borderColor":"#ffffff","titleSize":2,"titleColor":"#ff0000","priceSize":3,"priceColor":"#21618C","priceFromSize":3,"priceFromColor":"#850000","imageSize":350,"buttonType":1,"buttonText":"COMPRAR","buttonColor":"#fff333","buttonTextColor":"#000000","buttonImg":"http:\/\/img.comprarlipostabil.org\/2016\/04\/botao-quero-comprar-1024x200.png","buttonImgSize":180,"recommendationTitle":"Recomendamos para voc&ecirc;","recommendationTitleColor":"red","recommendationDesc":"Abaixo segue alguns produtos que talvez voc&ecirc; goste","separatorColor":"#000000"}',"startAt"=>"22/09/2017","endAt"=>"31/12/2017","default"=>"0","status"=>"1"];
	
	public function Login()
	{
		$data = ['email'=>'dev@bugginho.com', 'password'=>'admin'];

		$token = $this->post('/api/login', $data)
					  ->assertResponseStatus(200);

		return $token->response->original['token'];
	}

	public function testShowThemeById()
	{
		$token = $this->Login();

		$this->get('/api/themes/2', array("Authorization" => 'Bearer '.$token))
			 ->assertResponseStatus(200)
			 ->seeJsonStructure(["result"=>["id", "userId", "name",'configs'=>[],"startAt","endAt","default","status"]]);
	}

	public function testListTheme()
	{
		$token = $this->Login();

		$this->get('/api/themes', array("Authorization" => 'Bearer '.$token))
			 ->assertResponseStatus(200)
			 ->seeJsonStructure(["count","result"=>[["id", "userId", "name",'configs'=>[],"startAt","endAt","default","status"]]]);
	}

	public function testCreateTheme()
	{		
        $token = $this->Login();

        $this->post('/api/themes', $this->data, array("Authorization" => 'Bearer '.$token))
        	 ->assertResponseStatus(200)
        	 ->seeJson(["status"=> true]);
	}

	public function testUpdateTheme()
	{		
        $token = $this->Login();
        
        $this->post('/api/themes', $this->data, array("Authorization" => 'Bearer '.$token))
        	 ->assertResponseStatus(200)
        	 ->seeJson(["status"=> true]);

        $theme = ThemeModel::find(1)->first();

         
        $data=["id" => $theme->id, 'name'=> "Update"];

        $this->post('/api/themes', $data, array("Authorization" => 'Bearer '.$token))
        	 ->assertResponseStatus(200)
        	 ->seeJson(["status"=> true]);
	}

	public function testDeleteTheme()
	{		
        
        $this->post('/api/themes', $this->data, array("Authorization" => 'Bearer '.$this->Login()))
        	 ->assertResponseStatus(200)
        	 ->seeJson(["status"=> true]);

        $theme = ThemeModel::find(1)->orderby('id','DESC')->first();

        $this->delete('/api/themes/'.$theme->id,[], array("Authorization" => 'Bearer '.$this->Login()))
             ->assertResponseStatus(200)
        	 ->seeJson(["status"=> true]);
	}
}