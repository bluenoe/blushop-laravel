<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('stores contact message', function () {
    $payload = ['name'=>'Blu','email'=>'blu@example.com','message'=>'Hello!'];
    $this->post('/contact', $payload)->assertRedirect();
    $this->assertDatabaseHas('contact_messages', $payload);
});
