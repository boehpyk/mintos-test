<?php
/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 04/09/2019
 * Time: 11:02
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class EmailExists extends Constraint
{
    public $message = 'Given email "{{ email }}" already exists in database.';
}