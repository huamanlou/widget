<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 */

namespace Widget\Validator;

/**
 * Check if the input is valid email address
 * 
 * @author      Twin Huang <twinhuang@qq.com>
 */
class Email extends AbstractValidator
{
    protected $formatMessage = '%name% must be valid email address';
    
    protected $negativeMessage = '%name% must not be an email address';
    
    /**
     * {@inheritdoc}
     */
    protected function validate($input)
    {
        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $this->addError('format');
            return false;
        }
        
        return true;
    }
}
