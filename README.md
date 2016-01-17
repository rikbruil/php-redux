# Redux for PHP

[![Build Status](https://travis-ci.org/rikbruil/redux-test.svg?branch=master)](https://travis-ci.org/rikbruil/redux-test)
[![Coverage Status](https://coveralls.io/repos/rikbruil/redux-test/badge.svg?branch=master&service=github)](https://coveralls.io/github/rikbruil/redux-test?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rikbruil/redux-test/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rikbruil/redux-test/?branch=master)

## Code example

```php
// Provide the initial state for the application
// This can be any type of value (preferably scalars)
$initialState = 0;

// Provide a reducer
// Reducers modify state based on a given action
// They follow the pattern: (state, action) => state
$reducer = function ($state, $action) {
    $type = $action['type'];

    if ($type === 'INCREMENT') {
        return $state + 1;
    }

    if ($type === 'DECREMENT') {
        return $state - 1;
    }

    return $state;
};

// Create the application store with the reducer in place
$store = new \Rb\Rephlux\Store::create($reducer, $initialState);

// Listeners are low-level functionality.
// They can be used to feed state into other (third-party) components.
// Listeners will fire when application state changes.
$listener = function (\Rb\Replux\StoreInterface $store) {
    $state = $store->getState();
    echo 'Counter: ' . $state . PHP_EOL;
};

// Optional: Middleware is allowed to replace the dispatch() method of the store.
// In this example it allows sending Promises that resolve to actions
$middleware = new \Rb\Rephlux\Middleware\Chain([
    new PromiseMiddleWare()
]);

// Middlewares need to be applied to the store
$middleware($store); // short-hand for: $middleware->apply($store);

// This will update global state to 1
$store->dispatch(['type' => 'INCREMENT']);

// We can safely dispatch promises due to the middleware
$deferred = new Deferred();
$promise = $deferred->promise();

// The listeners won't dispatch until the promise is resolved.
$store->dispatch($promise);

// Will still return 1
echo $store->getState() . PHP_EOL;

sleep(2);

// We will now resolve the promise, triggering the listeners
// This will decrement global state back to 0
$deferred->resolve(['type' => 'DECREMENT']);

// Will now return 0
echo $store->getState() . PHP_EOL;
```
