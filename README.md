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

// Register a listener that will fire when the application state changes
$listener = function (\Rb\Replux\StoreInterface $store) {
    $state = $store->getState();
    echo 'Counter: ' . $state . PHP_EOL;
};

// Middleware is allowed to replace the dispatch() method of the store.
// In this example it allows sending Promises that resolve to actions
$middleware = new \Rb\Replux\Chain([
    new PromiseMiddleWare()
]);

// Middlewares need to be applied to the store
$middleware($store); // short-hand for: $middleware->bind($store);

$store->dispatch(['type' => 'INCREMENT']); // This will update global state to 1
$store->dispatch(['type' => 'DECREMENT']); // This will update global state back to 0
```
