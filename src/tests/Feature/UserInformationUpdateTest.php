<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserInformationUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）()
    {
        Storage::fake('public');

        // ユーザー作成
        $user = User::factory()->create();
        $this->actingAs($user);

        $user->update(['profile_img' => 'test_image.png']);

        $file = UploadedFile::fake()->create('update_test.png', 100, 'image/png');

        $response = $this->actingAs($user)
            ->post('//mypage/profile', [
                'profile_img' => $file,
                'name' => 'update_test',
                'post_number' => '000-0000',
                'address' => 'update_test',
                'building' => 'update_test',
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'update_test',
            'post_number' => '000-0000',
            'address' => 'update_test',
            'building' => 'update_test',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_img' => $user->fresh()->profile_img,
        ]);
    }
}
