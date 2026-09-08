<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated including all custom fields without altering email', function () {
    \Illuminate\Support\Facades\Storage::fake('public');
    $user = User::factory()->create([
        'email' => 'original@construction.com',
    ]);

    $fakeImage = \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg', 300, 300);

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Alexander Vance',
            'designation' => 'Lead Construction Engineer',
            'phone_no' => '+8801712345678',
            'address' => 'Floor 12, Sky Tower, Gulshan-2, Dhaka',
            'description' => '15+ years managing seismic engineering and commercial superstructures.',
            'facebook' => 'https://facebook.com/alexander.vance',
            'linkedin' => 'https://linkedin.com/in/alexander-vance',
            'whatsapp' => '+8801712345678',
            'image' => $fakeImage,
            'email' => 'hacked@example.com', // Should be ignored / locked
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Alexander Vance', $user->name);
    $this->assertSame('Lead Construction Engineer', $user->designation);
    $this->assertSame('+8801712345678', $user->phone_no);
    $this->assertSame('Floor 12, Sky Tower, Gulshan-2, Dhaka', $user->address);
    $this->assertSame('15+ years managing seismic engineering and commercial superstructures.', $user->description);
    $this->assertSame('https://facebook.com/alexander.vance', $user->facebook);
    $this->assertSame('https://linkedin.com/in/alexander-vance', $user->linkedin);
    $this->assertSame('+8801712345678', $user->whatsapp);
    $this->assertNotNull($user->image);
    $this->assertSame('original@construction.com', $user->email); // Email remains intact
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});
