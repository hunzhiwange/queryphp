<?php /* 2018-03-30 21:51:11 */ ?>
<?php return array (
  'domains' => 
  array (
  ),
  'routers' => 
  array (
    'hello-{what}' => 
    array (
      0 => 
      array (
        'url' => 'home://topic/index',
        'regex' => 'hello-{what}',
        'params' => 
        array (
        ),
        'where' => 
        array (
        ),
        'domain' => '',
      ),
    ),
  ),
  'domain_wheres' => 
  array (
  ),
  'wheres' => 
  array (
  ),
  'middlewares' => 
  array (
    '*' => 
    array (
      0 => 'Queryyetsimple\\Log\\Middleware\\Log',
    ),
  ),
  'methods' => 
  array (
  ),
); ?>