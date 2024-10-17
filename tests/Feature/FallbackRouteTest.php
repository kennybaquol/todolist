<?php

test('should redirect all unathenticated routes to the login page', function ($url) {
    $response = $this->get($url);

    $response->assertStatus(302);
})->with([
    ['/', 302],
    ['/another-url', 302],
    ['/home', 302],
]);

