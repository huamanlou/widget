<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 */

namespace Widget\Validator;

/**
 * Check if the input is provided
 * 
 * @author      Twin Huang <twinhuang@qq.com>
 */
class Required extends AbstractValidator
{
    protected $requiredMessage = '%name% is required';
    
    protected $required = true;
    
    /**
     * {@inheritdoc}
     */
    public function __invoke($input, $required = null)
    {
        is_bool($required) && $this->storeOption('required', $required);
        
        return $this->isValid($input);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function validate($input)
    {
        //Catchable fatal error: Object of class SplFileInfo could not be converted to boolean
        if ($this->required && empty($input)) {
            $this->addError('required');
            return false;
        }
        return true;
    }
}
