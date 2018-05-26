<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function recording_activity_when_thread_is_created()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->assertDatabaseHas('activities', [
           'type' => 'created_thread',
           'subject_id' => $thread->id,
            'user_id' => auth()->id(),
            'subject_type' => 'App\Thread'
        ]);
    }
    /** @test */
    public function recording_activity_when_reply_is_created() {
        $this->signIn();
        $reply = create('App\Reply');
        $this->assertDatabaseHas('activities',['subject_id' => $reply->id,'subject_id' => $reply->thread_id]);
    }
}