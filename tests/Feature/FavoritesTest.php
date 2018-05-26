<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function guest_cant_favorite_anything() {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/replies/{$reply->id}/favorites');
    }
    /** @test */
    public function loged_in_user_can_favorite_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->post('/replies/'.$reply->id.'/favorites');
        $this->assertCount(1, $reply->favorites);
    }
    /** @test */
    public function favorited_once_only() {
        $this->signIn();
        $reply = create('App\Reply');
        try {
            $this->post('/replies/' . $reply->id . '/favorites');
            $this->post('/replies/' . $reply->id . '/favorites');
        } catch (\Exception $e){
            $this->fail('dont play with me');
        }
        $this->assertCount(1, $reply->favorites);
    }
    /** @test */
     public function an_authenticated_user_can_unfavorite_a_reply()
   {
        $this->signIn();

        $reply = create('App\Reply');

        $reply->favorite();

        $this->delete('replies/' . $reply->id . '/favorites');

        $this->assertCount(0, $reply->favorites);
    }
}