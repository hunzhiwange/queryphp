# Test Event

## Define event and listen

you can define yous at common\is\provider\event.

``` php
class event extends Events
{
    protected $listeners = [
        'common\domain\event\test' => [
            'common\domain\listener\test'
        ]
    ];
}
```

## Define the listen

you can define yous at common\domain\listener.

``` php
class test extends abstracts
{

    /**
     * 构造函数
     * 支持依赖注入
     * 
     * @return void
     */
    public function __construct () {
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
$event->run(new \common\domain\event\test('hello blog'), 1, 2, 3, 4);
```

or 

``` php
\Queryyetsimple\Event::run(new \common\domain\event\test('hello blog'), 1, 2, 3, 4);
```

or

``` php
\Qys\Event::run(new \common\domain\event\test('hello blog'), 1, 2, 3, 4);
```