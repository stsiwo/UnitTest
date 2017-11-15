<?php

namespace Tests\Unit\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;

class DictionaryServiceTest extends TestCase
{
    public function setUp()
    {
      parent::setUp();
      $this->dicRepo_mock = Mockery::mock('\App\Repositories\Dictionary\DictionaryRepoInterface',\App\Repositories\Dictionary\DictionaryRepoInterface::class);
      $this->Dic_mock = Mockery::mock('alias:\App\Http\ViewModel\Dic');
      $this->app->instance('App\Repositories\Dictionary\DictionaryRepoInterface', $this->dicRepo_mock);
      $this->sut = $this->app->make('App\Services\Dictionary\DictionaryServiceInterface');
    }

    // findDictionaryWithItsWords method test

    /** @test */
    public function it_return_dictionary_view_model_object()
    {
      // 1. arrange
      //  prepare dummy
      $dic_dummy_id = 1;
      $dic_dummy_model = new \App\Model\Dictionary;
      // stub 1 :  DictionaryRepoInterface
      $this->dicRepo_mock
           ->shouldReceive('findDictionaryWithItsWords')
           ->with($dic_dummy_id)
           ->once()
           ->andReturn($dic_dummy_model);
      // stub 2 : Dic class
      $this->Dic_mock
           ->shouldReceive('createWith')
           ->with($dic_dummy_model)
           ->once()
           ->andReturn('view_model');
      // 2. act
      $result = $this->sut->findDictionaryWithItsWords($dic_dummy_id);
      // 3. assert
      $this->assertEquals('view_model', $result);
    }

    public function tearDown() {
      Mockery::close();
    }

}
