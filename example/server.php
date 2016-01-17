<?php

error_reporting(-1);

require __DIR__ . '/../vendor/autoload.php';

$port = 8080;

const COUNT_ACTION = 'COUNT';

// Add a reducer for a specific state key (count)
$reducer = new \Rb\Rephlux\Reducer\ComposedReducer();
$reducer->addReducer('count', function ($state, $action) {
    $type = $action['type'];

    if (COUNT_ACTION === $type) {
        return $state + 1;
    }

    return $state;
});

$store = \Rb\Rephlux\Store::create($reducer, ['count' => 0]);

// Triggers when the state changes
$store->subscribe(function (\Rb\Rephlux\StoreInterface $store) {
    $state = $store->getState();
    echo 'State changed: ' . $state['count'] . PHP_EOL;
});

$middleware = new \Rb\Rephlux\Middleware\Chain();
$middleware->addDispatcher(new \Rb\Rephlux\Dispatcher\PromiseDispatcher());

$middleware($store);

$requestHandler = function (\React\Http\Request $request, \React\Http\Response $response) use ($store) {
    $response->writeHead();

    if ($request->getPath() !== '/') {
        $response->end();

        return;
    }

    $resolved = ['type' => COUNT_ACTION];
    $deferred = new \React\Promise\Deferred();
    $promise  = $deferred->promise();
    $store->dispatch($promise);

    $promise->done(function () use ($response, $store) {
        sleep(1);

        $state = $store->getState();
        $response->end('Count: ' . $state['count']);
    });

    $deferred->resolve($resolved);
};

$loop   = React\EventLoop\Factory::create();
$socket = new \React\Socket\Server($loop);
$server = new \React\Http\Server($socket);

$server->on('request', $requestHandler);
$socket->listen($port);

echo 'Server started: http://localhost:' . $port . PHP_EOL;

$loop->run();
