<?php

namespace mootensai\relation;

use yii\mongodb\ActiveRecord;

/**
 * NoSqlRelationTrait
 *
 * @author Luis Gonzalez <contact@inquid.co>
 * @since 1.0
 */
class NoSqlModel extends ActiveRecord
{
    /**
     * Declares which DB operations should be performed within a transaction in different scenarios.
     * The supported DB operations are: [[OP_INSERT]], [[OP_UPDATE]] and [[OP_DELETE]],
     * which correspond to the [[insert()]], [[update()]] and [[delete()]] methods, respectively.
     * By default, these methods are NOT enclosed in a DB transaction.
     *
     * In some scenarios, to ensure data consistency, you may want to enclose some or all of them
     * in transactions. You can do so by overriding this method and returning the operations
     * that need to be transactional. For example,
     *
     * ```php
     * return [
     *     'admin' => self::OP_INSERT,
     *     'api' => self::OP_INSERT | self::OP_UPDATE | self::OP_DELETE,
     *     // the above is equivalent to the following:
     *     // 'api' => self::OP_ALL,
     *
     * ];
     * ```
     *
     * The above declaration specifies that in the "admin" scenario, the insert operation ([[insert()]])
     * should be done in a transaction; and in the "api" scenario, all the operations should be done
     * in a transaction.
     *
     * @return array the declarations of transactional operations. The array keys are scenarios names,
     * and the array values are the corresponding transaction operations.
     */
    public function transactions()
    {
        return [];
    }

    /**
     * Returns a value indicating whether the specified operation is transactional in the current [[$scenario]].
     * @param int $operation the operation to check. Possible values are [[OP_INSERT]], [[OP_UPDATE]] and [[OP_DELETE]].
     * @return bool whether the specified operation is transactional in the current [[scenario]].
     */
    public function isTransactional($operation)
    {
        $scenario = $this->getScenario();
        $transactions = $this->transactions();

        return isset($transactions[$scenario]) && ($transactions[$scenario] & $operation);
    }
}
