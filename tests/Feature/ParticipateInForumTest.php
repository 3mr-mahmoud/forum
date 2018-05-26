<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Thread;

class ParticipateInForumTest extends TestCase
{
   use DatabaseMigrations;
   protected $thread;
    public function  setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->thread = factory(Thread::class)->create();
    }
    /** @test */
    public function A_user_can_add_reply()
    {
        $this->signIn();
        $reply = make('App\Reply');
        $this->post($this->thread->path().'/replies', $reply->toArray());

        $this->get($this->thread->path())->assertSee($reply->body);
    }
    /** @test */
    public function A_reply_body_is_required() {
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->signIn();
        $reply = make('App\Reply',['body' => null]);
        $this->post($this->thread->path().'/replies', $reply->toArray());
    }
    /** @test */
    public function A_user_can_delete_reply() {
        $this->withExceptionHandling();
        $reply = create('App\Reply');

        $this->delete('/replies/{$reply->id}')->assertRedirect('login');
        $this->signIn()->delete('/replies/'.$reply->id)->assertStatus(403);
    } 
    /** @test */
    public function A_user_can_update_reply()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id() ]);
        $newReply = make('App\Reply');
        $this->patch("/replies/".$reply->id, ['body'=> $newReply->body ]);
        $this->assertDatabaseHas('replies',['id' => $reply->id,'body' => $newReply->body]);
    }
    /** @test */
    public function unauthorized_user_cannot_update_reply() {
        $this->withExceptionHandling();
        $reply = create('App\Reply');

        $this->patch('/replies/{$reply->id}')->assertRedirect('login');
        $this->signIn()->patch('/replies/'.$reply->id)->assertStatus(403);
    } 
}
