<?php /* 2018-04-02 23:16:16 */ ?>
<?php return array (
  0 => 
  array (
    'caches' => 'Queryyetsimple\\Cache\\Provider\\Register',
    'cache' => 'Queryyetsimple\\Cache\\Provider\\Register',
    'cache.load' => 'Queryyetsimple\\Cache\\Provider\\Register',
    'encryption' => 'Queryyetsimple\\Encryption\\Provider\\Register',
    'filesystems' => 'Queryyetsimple\\Filesystem\\Provider\\Register',
    'filesystem' => 'Queryyetsimple\\Filesystem\\Provider\\Register',
    'throttler' => 'Queryyetsimple\\Throttler\\Provider\\Register',
    'Queryyetsimple\\Throttler\\Middleware\\Throttler' => 'Queryyetsimple\\Throttler\\Provider\\Register',
  ),
  1 => 
  array (
    'Queryyetsimple\\Cache\\Provider\\Register' => 
    array (
      'caches' => 
      array (
        0 => 'Queryyetsimple\\Cache\\Manager',
        1 => 'Qys\\Cache\\Manager',
      ),
      'cache' => 
      array (
        0 => 'Queryyetsimple\\Cache\\Cache',
        1 => 'Queryyetsimple\\Cache\\ICache',
        2 => 'Qys\\Cache\\Cache',
        3 => 'Qys\\Cache\\ICache',
      ),
      'cache.load' => 
      array (
        0 => 'Queryyetsimple\\Cache\\Load',
        1 => 'Qys\\Cache\\Load',
      ),
    ),
    'Queryyetsimple\\Encryption\\Provider\\Register' => 
    array (
      'encryption' => 
      array (
        0 => 'Queryyetsimple\\Encryption\\Encryption',
        1 => 'Queryyetsimple\\Encryption\\IEncryption',
        2 => 'Qys\\Encryption\\Encryption',
        3 => 'Qys\\Encryption\\IEncryption',
      ),
    ),
    'Queryyetsimple\\Filesystem\\Provider\\Register' => 
    array (
      'filesystems' => 
      array (
        0 => 'Queryyetsimple\\Filesystem\\Manager',
        1 => 'Qys\\Filesystem\\Manager',
      ),
      'filesystem' => 
      array (
        0 => 'Queryyetsimple\\Filesystem\\Filesystem',
        1 => 'Queryyetsimple\\Filesystem\\IFilesystem',
        2 => 'Qys\\Filesystem\\Filesystem',
        3 => 'Qys\\Filesystem\\IFilesystem',
      ),
    ),
    'Queryyetsimple\\Throttler\\Provider\\Register' => 
    array (
      'throttler' => 
      array (
        0 => 'Queryyetsimple\\Throttler\\Throttler',
        1 => 'Queryyetsimple\\Throttler\\IThrottler',
        2 => 'Qys\\Throttler\\Throttler',
        3 => 'Qys\\Throttler\\IThrottler',
      ),
      0 => 'Queryyetsimple\\Throttler\\Middleware\\Throttler',
    ),
  ),
); ?>