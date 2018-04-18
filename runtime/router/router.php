<?php /* 2018-04-18 09:10:33 */ ?>
<?php return array (
  'basepaths' => 
  array (
    0 => '/v2',
  ),
  'groups' => 
  array (
    0 => '/pet',
  ),
  'routers' => 
  array (
    'get' => 
    array (
      'p' => 
      array (
        '/pet' => 
        array (
          '/v2/pet/findByStatus' => 
          array (
            'scheme' => NULL,
            'domain' => '{suddomain}.{domain}.queryphp.cn',
            'params' => 
            array (
              'args1' => 'hello',
              'args2' => 'world',
            ),
            'where' => 
            array (
              'hello' => '[0-9]+',
              'world' => '[A-Za-z]+',
            ),
            'strict' => true,
            'bind' => ':group/blog/list?arg1=1&arg2=2',
            'domain_regex' => '/^(\\S+)\\.(\\S+)\\.queryphp\\.cn$/',
            'domain_var' => 
            array (
              0 => 'suddomain',
              1 => 'domain',
            ),
            'regex' => NULL,
            'var' => NULL,
          ),
          '/v2/pet/{petId}' => 
          array (
            'scheme' => NULL,
            'domain' => 'www.queryphp.cn',
            'params' => NULL,
            'where' => NULL,
            'strict' => NULL,
            'bind' => ':App/Petstore/Pet/getPetById',
            'domain_regex' => NULL,
            'domain_var' => NULL,
            'regex' => '/^\\/v2\\/pet\\/(\\S+)$/',
            'var' => 
            array (
              0 => 'petId',
            ),
          ),
        ),
      ),
    ),
    'delete' => 
    array (
      'p' => 
      array (
        '/pet' => 
        array (
          '/v2/pet/{petId}' => 
          array (
            'scheme' => NULL,
            'domain' => NULL,
            'params' => NULL,
            'where' => NULL,
            'strict' => NULL,
            'bind' => ':App/Petstore/Pet/deletePet',
            'domain_regex' => NULL,
            'domain_var' => NULL,
            'regex' => '/^\\/v2\\/pet\\/(\\S+)$/',
            'var' => 
            array (
              0 => 'petId',
            ),
          ),
        ),
      ),
    ),
    'post' => 
    array (
      'p' => 
      array (
        '/pet' => 
        array (
          '/v2/pet/{petId}' => 
          array (
            'scheme' => NULL,
            'domain' => NULL,
            'params' => NULL,
            'where' => NULL,
            'strict' => NULL,
            'bind' => ':App/Petstore/Pet/updatePetWithForm',
            'domain_regex' => NULL,
            'domain_var' => NULL,
            'regex' => '/^\\/v2\\/pet\\/(\\S+)$/',
            'var' => 
            array (
              0 => 'petId',
            ),
          ),
          '/v2/pet' => 
          array (
            'scheme' => NULL,
            'domain' => NULL,
            'params' => NULL,
            'where' => NULL,
            'strict' => NULL,
            'bind' => ':App/Petstore/Pet/addPet',
            'domain_regex' => NULL,
            'domain_var' => NULL,
            'regex' => NULL,
            'var' => NULL,
          ),
          '/v2/pet/{petId}/uploadImage' => 
          array (
            'scheme' => NULL,
            'domain' => NULL,
            'params' => NULL,
            'where' => NULL,
            'strict' => NULL,
            'bind' => ':App/Petstore/Pet/uploadFile',
            'domain_regex' => NULL,
            'domain_var' => NULL,
            'regex' => '/^\\/v2\\/pet\\/(\\S+)\\/uploadImage$/',
            'var' => 
            array (
              0 => 'petId',
            ),
          ),
        ),
      ),
    ),
  ),
); ?>