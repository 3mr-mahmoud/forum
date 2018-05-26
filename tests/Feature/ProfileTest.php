<?php
namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_has_profile()
    {
        $user = create('App\User');
        $this->get('profile/'.$user->name)
            ->assertSee($user->name);
    }
    /** @test */
    public function profile_has_associated_threads()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
                $this->get('profile/'.auth()->user()->name)
                    ->assertSee($thread->title);
    }

}