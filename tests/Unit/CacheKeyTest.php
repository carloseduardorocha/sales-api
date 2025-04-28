<?php

namespace Tests\Unit\Helpers;

use App\Helpers\CacheKey;
use Tests\TestCase;

class CacheKeyTest extends TestCase
{
    public function test_sanitize_replaces_special_characters_and_uppercases(): void
    {
        $originalKey = 'user-session:token.value with spaces';
        $expectedKey = 'USER_SESSION_TOKEN_VALUE_WITH_SPACES';

        $sanitizedKey = CacheKey::sanitize($originalKey);

        $this->assertEquals($expectedKey, $sanitizedKey);
    }

    public function test_sanitize_with_no_special_characters(): void
    {
        $originalKey = 'simplekey';
        $expectedKey = 'SIMPLEKEY';

        $sanitizedKey = CacheKey::sanitize($originalKey);

        $this->assertEquals($expectedKey, $sanitizedKey);
    }

    public function test_sanitize_with_only_special_characters(): void
    {
        $originalKey = '-: .';
        $expectedKey = '____';

        $sanitizedKey = CacheKey::sanitize($originalKey);

        $this->assertEquals($expectedKey, $sanitizedKey);
    }

    public function test_sanitize_empty_string(): void
    {
        $originalKey = '';
        $expectedKey = '';

        $sanitizedKey = CacheKey::sanitize($originalKey);

        $this->assertEquals($expectedKey, $sanitizedKey);
    }
}
