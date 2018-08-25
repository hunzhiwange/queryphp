<?php declare(strict_types=1);

namespace Common\Domain\Entity;

//use Leevel\Database\Ddd\Model;
//use queryyetsimple\mvc\iaggregate_root;

/**
 * 权限
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.11
 * @version 1.0
 */
class Test// extends Model /*implements iaggregate_root*/
{

    private $id;

    private $name;

   // 'guy', 'development team'

const struct = [
    Id        int   `orm:"column(id);auto"`
    ProjectId uint  `orm:"column(project_id)"`
    UserId    int   `orm:"column(user_id)"`
    Type      int16 `orm:"column(type);null"`
]
}

    

//     $primary_key = 'id';

//     $auto_increment = '';
// array:3 [▼
//   "list" => array:2 [▼
//     "id" => array:6 [▼
//       "name" => "id"
//       "type" => "int"
//       "length" => "int"
//       "primary_key" => true
//       "auto_increment" => true
//       "default" => null
//     ]
//     "name" => array:6 [▼
//       "name" => "name"
//       "type" => "varchar"
//       "length" => "varchar"
//       "primary_key" => false
//       "auto_increment" => false
//       "default" => null
//     ]
//   ]
//   "primary_key" => array:1 [▼
//     0 => "id"
//   ]
//   "auto_increment" => "id"
// ]
}
