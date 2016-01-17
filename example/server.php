<?php

use Rb\Rephlux\Middleware\PromiseMiddleware;

error_reporting(-1);

require __DIR__ . '/../vendor/autoload.php';

const COUNT_ACTION = 'COUNT';

// Add a reducer for a specific state key (count)
$reducer = new \Rb\Rephlux\Reducer\ComposedReducer();
$reducer->addReducer('pageviews', function ($state, $action) {
    $type = $action['type'];

    if (COUNT_ACTION === $type) {
        return $state + 1;
    }

    return $state;
});

$store = \Rb\Rephlux\Store::create($reducer, ['pageviews' => 0]);

// Triggers when the state changes
$store->subscribe(function (\Rb\Rephlux\StoreInterface $store) {
    $state = $store->getState();
    echo 'Pageviews: ' . $state['pageviews'] . PHP_EOL;
});

$middleware = new PromiseMiddleware();
$middleware($store);

$requestHandler = function (\React\Http\Request $request, \React\Http\Response $response) use ($middleware) {
    $response->writeHead();

    if ($request->getPath() !== '/') {
        $response->end();

        return;
    }

    $deferred = new \React\Promise\Deferred();
    $promise  = $deferred->promise();
    $middleware->dispatch($promise);

    $promise->done(function () use ($response, $middleware) {
        sleep(1);

        $response->end('Page views: ' . $middleware->getState()['pageviews']);
    });

    $deferred->resolve(['type' => COUNT_ACTION]);
};

$loop   = React\EventLoop\Factory::create();
$socket = new \React\Socket\Server($loop);
$server = new \React\Http\Server($socket);

$server->on('request', $requestHandler);

$socket->listen(8080);
$loop->run();
