# Test Event

## Define event and listen

you can define yous at Common\Infra\Provider\Event.

``` php
Leevel\Event\EventProvider;

class Event extends EventProvider
{
    protected $listeners = [
        'Common\Domain\Event\Test' => [
            'Common\Domain\Listener\Test'
        ]
    ];
}
```

## Define the listen

you can define yous at Common\Domain\Listener.

``` php
class Test extends Listener
{

    /**
     * 构造函数
     * 支持依赖注入
     * 
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * 监听器响应
     * 
     * @return void
     */
    public function run()
    {
        $args = func_get_args();

        $event = array_shift($args);

        print_r($event->blog());

        print_r($args);
    }
}
```

## Trigger the event

This is a easy way to trigger the event.

``` php
$event = app('event');
$event->run(new \Common\Domain\Event\Test('hello blog'), 1, 2, 3, 4);
```

or 

``` php
\Leevel\Event::run(new \Common\Domain\Event\Test('hello blog'), 1, 2, 3, 4);
```
