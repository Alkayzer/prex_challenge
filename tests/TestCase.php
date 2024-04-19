<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUpPassportClients(): void
    {
        DB::table('oauth_clients')->delete();
        $clientId = DB::table('oauth_clients')->insertGetId([
            'name' => 'Personal Access Client',
            'secret' => 'some-random-string',
            'redirect' => 'http://localhost',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false,
        ]);

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $clientId
        ]);
    }
}
