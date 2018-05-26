<?php

namespace Tests\Feature;


use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function guest_cant_post_A_fucking_thread() {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());
    }
    /** @test */
    public function user_can_create_athread() {
        $this->signIn();

        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());
        $this->get($response->headers->get('Location'))->assertSee($thread->title)->assertSee($thread->body);
    }
    /** @test */
    public function a_thread_requires_title() {
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->publishThread(['title' => null]);
    }
    /** @test */
    public function a_thread_requires_body() {
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->publishThread(['body' => null]);
    }
    /** @test */
    public function a_thread_requires_a_valid_channel() {
        $channel = create('App\Channel');
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->publishThread(['channel_id' => ($channel->id+1)]);
    }
    /** @test */
    public function a_user_can_filter_threads_according_to_a_tag() {
        $channel = create('App\Channel');
        $threadIn = create('App\Thread',['channel_id' => $channel->id]);
        $threadOut = create('App\Thread');
        $this->get('/threads/'.$channel->slug)->assertSee($threadIn->title)->assertDontSee($threadOut->title);
    }
    /** @test */
    public function a_user_can_filter_threads_by_username() {
        $this->signIn(create('App\User', ['name' => 'John']));
        $threadbyJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotbyJohn = create('App\Thread');
        $this->get('threads?by=John')->assertSee($threadbyJohn->title)->assertDontSee($threadNotbyJohn->title);
    }
    /** @test */
    public function a_thread_can_be_deleted()
    {
        $user = create('App\User');
        $this->signIn($user);
        $thread = create('App\Thread',['user_id' => $user->id ]);
        $reply = create('App\Reply',['thread_id' => $thread->id ,'user_id' => $user->id ]);
        $response = $this->json('DELETE',$thread->path());
        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads',['id' => $thread->id ]);
        $this->assertDatabaseMissing('replies',['id' => $reply->id ]);
    }
    /** @test */
    public function a_guest_cannot_delete_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = create('App\Thread');
        $this->delete($thread->path());
    }
    /** @test */
    public function unauthorized_cannot_delete_thread()
    {
        $this->expectExceptionMessage('This action is unauthorized.');
        $thread = create('App\Thread');
        $this->signIn();
        $this->delete($thread->path());
    }
    protected function publishThread($overrides = []) {
        $this->signIn();
        $thread = make('App\Thread',$overrides);
        return$this->post('/threads',$thread->toArray());
    }
}
