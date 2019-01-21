<?php

/**
 * Helper with methods to simplify actions like table creation, attributes creation and others.
 * @author Tulio de Melo.
 */

namespace Fulcrum\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Setup\SchemaSetupInterface;

class Setup extends AbstractHelper
{
    /**
     * Encapsulate complexity to table creation in install schema or upgrade schema classes.
     *
     * @param SchemaSetupInterface $setup
     * @param string $tableName
     * @param array $fields
     * @param string $tableComment
     * @param string $engine
     * @param string $charset
     * @return bool
     * @throws \Zend_Db_Exception
     */
    public function createTable(SchemaSetupInterface $setup,
                                string $tableName,
                                array $fields,
                                string $tableComment,
                                string $engine = 'InnoDB',
                                string $charset = 'utf8'): bool
    {
        if (count($fields) == 0) {
            return false;
        }

        $table = $setup->getTable($tableName);

        if (!$setup->getConnection()->isTableExists($table)) {

            $table = $setup->getConnection()->newTable($table);

            foreach ($fields as $field) {
                $table->addColumn(
                    $field['name'],
                    $field['type'],
                    $field['size'] ?? null,
                    $field['options'],
                    $field['comment']
                );
            }

            $table->setComment($tableComment)->setOption('type', $engine)->setOption('charset', $charset);

            $setup->getConnection()->createTable($table);

            return true;

        }

        return false;
    }

    /**
     * Add a column to a table.
     *
     * @param SchemaSetupInterface $setup
     * @param string $tableName
     * @param string $columnName
     * @param array $options
     */
    public function addColumn(SchemaSetupInterface $setup, string $tableName, string $columnName, $options = [])
    {
        $setup->getConnection()->addColumn(
            $setup->getTable($tableName),
            $columnName,
            $options
        );
    }

    /**
     * Encapsulate complexity to add index in a table.
     *
     * @param SchemaSetupInterface $setup
     * @param $tableName
     * @param $columnName
     */
    public function addIndex(SchemaSetupInterface $setup, string $tableName, string $columnName)
    {
        $setup->getConnection()->addIndex(
            $setup->getTable($tableName),
            (string)"idx_" . $tableName . "_" . $columnName,
            [$columnName],
            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
        );
    }

    /**
     * Add index to compound key columns.
     *
     * @param SchemaSetupInterface $setup
     * @param string $tableName
     * @param array $columns
     */
    public function addIndexToCompoundKeys(SchemaSetupInterface $setup, string $tableName, array $columns = [])
    {
        $setup->getConnection()->addIndex(
            $setup->getTable($tableName),
            $setup->getIdxName(
                $tableName,
                $columns,
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            $columns,
            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
        );
    }

    /**
     * Add a foreign key to a column.
     *
     * @param SchemaSetupInterface $setup
     * @param string $priTableName
     * @param string $priColumnName
     * @param string $refTableName
     * @param string $refColumnName
     * @param string $onDeleteAction
     */
    public function addForeignKey(SchemaSetupInterface $setup,
                                  string $priTableName,
                                  string $priColumnName,
                                  string $refTableName,
                                  string $refColumnName,
                                  string $onDeleteAction)
    {
        $setup->getConnection()->addForeignKey(
            $setup->getFkName(
                $priTableName,
                $priColumnName,
                $refTableName,
                $refColumnName
            ),
            $priTableName,
            $priColumnName,
            $refTableName,
            $refColumnName,
            $onDeleteAction,
            false,
            null,
            null
        );
    }

}