<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 11.07.18
 * Time: 15:32
 */

namespace app\modules\meta\behaviors;

use app\components\SerializableTrait;
use Serializable;

/**
 * Class MetaBehavior
 *
 * @package app\modules\meta\behaviors
 */
class MetaBehavior extends \krok\meta\behaviors\MetaBehavior implements Serializable
{
    use SerializableTrait;
}
