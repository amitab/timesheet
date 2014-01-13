<?php
/**
 *  Copyright 2012 Native5. All Rights Reserved
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *	You may not use this file except in compliance with the License.
 *
 *	Unless required by applicable law or agreed to in writing, software
 *	distributed under the License is distributed on an "AS IS" BASIS,
 *	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *	See the License for the specific language governing permissions and
 *	limitations under the License.
 *  PHP version 5.3+
 *
 * @category  PasswordPolicy
 * @package   Native5\Core\Security\Password
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

namespace Native5\Util\Password;

/**
 * PasswordRule
 *
 * @category  PasswordPolicy
 * @package   Native5\Core\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class PasswordRule
{

    private $_actions;
    private $_conditions;

    public function __construct()
    {
        $this->_actions = array();
        $this->_conditions = array();
    }

    /**
     * addCondition
     *
     * @param mixed $attribute  The attribute to add
     * @param mixed $range      The available range
     *
     * @access public
     * @return void
     */
    public function addCondition($attribute, $range, $accessor)
    {
        $condition = new Condition($attribute, $range, $accessor);
        $this->_conditions[] = $condition;
    }

    /**
     * addAction
     *
     * @param mixed $action The action to perform
     *
     * @access public
     * @return void
     */
    public function addAction($action)
    {
        $this->_actions[] = $action;
    }

    /**
     * execute
     *
     * @param mixed $password The password to evaluate
     *
     * @access public
     * @return void
     */
    public function execute($password, $subject)
    {
        foreach ($this->_conditions as $condition) {
            if ($condition->evaluate($password) === false) {
                // Trigger all actions if any condition is unmet
                foreach ($this->_actions as $action) {
                    $action->execute($password, $subject);
                }
            }
        }
    }

    public function describe()
    {
        $ruleDescription = "A human readable format for the rule";
        return $ruleDescription;
    }
}
