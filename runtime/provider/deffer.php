<?php /* 2018-05-03 21:10:00 */ ?>
<?php return array (
  0 => 
  array (
    'caches' => 'Leevel\\Cache\\Provider\\Register',
    'cache' => 'Leevel\\Cache\\Provider\\Register',
    'cache.load' => 'Leevel\\Cache\\Provider\\Register',
    'encryption' => 'Leevel\\Encryption\\Provider\\Register',
    'filesystems' => 'Leevel\\Filesystem\\Provider\\Register',
    'filesystem' => 'Leevel\\Filesystem\\Provider\\Register',
    'throttler' => 'Leevel\\Throttler\\Provider\\Register',
    'Leevel\\Throttler\\Middleware\\Throttler' => 'Leevel\\Throttler\\Provider\\Register',
  ),
  1 => 
  array (
    'Leevel\\Cache\\Provider\\Register' => 
    array (
      'caches' => 
      array (
        0 => 'Leevel\\Cache\\Manager',
      ),
      'cache' => 
      array (
        0 => 'Leevel\\Cache\\Cache',
        1 => 'Leevel\\Cache\\ICache',
      ),
      'cache.load' => 
      array (
        0 => 'Leevel\\Cache\\Load',
      ),
    ),
    'Leevel\\Encryption\\Provider\\Register' => 
    array (
      'encryption' => 
      array (
        0 => 'Leevel\\Encryption\\Encryption',
        1 => 'Leevel\\Encryption\\IEncryption',
      ),
    ),
    'Leevel\\Filesystem\\Provider\\Register' => 
    array (
      'filesystems' => 
      array (
        0 => 'Leevel\\Filesystem\\Manager',
      ),
      'filesystem' => 
      array (
        0 => 'Leevel\\Filesystem\\Filesystem',
        1 => 'Leevel\\Filesystem\\IFilesystem',
      ),
    ),
    'Leevel\\Throttler\\Provider\\Register' => 
    array (
      'throttler' => 
      array (
        0 => 'Leevel\\Throttler\\Throttler',
        1 => 'Leevel\\Throttler\\IThrottler',
      ),
      0 => 'Leevel\\Throttler\\Middleware\\Throttler',
    ),
  ),
); ?>