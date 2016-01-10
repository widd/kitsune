<?php

namespace Map;

use \Postcards;
use \PostcardsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'postcards' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PostcardsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PostcardsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'postcards';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Postcards';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Postcards';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'postcards.ID';

    /**
     * the column name for the Recipient field
     */
    const COL_RECIPIENT = 'postcards.Recipient';

    /**
     * the column name for the SenderName field
     */
    const COL_SENDERNAME = 'postcards.SenderName';

    /**
     * the column name for the SenderID field
     */
    const COL_SENDERID = 'postcards.SenderID';

    /**
     * the column name for the Details field
     */
    const COL_DETAILS = 'postcards.Details';

    /**
     * the column name for the Date field
     */
    const COL_DATE = 'postcards.Date';

    /**
     * the column name for the Type field
     */
    const COL_TYPE = 'postcards.Type';

    /**
     * the column name for the HasRead field
     */
    const COL_HASREAD = 'postcards.HasRead';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Recipient', 'Sendername', 'Senderid', 'Details', 'Date', 'Type', 'Hasread', ),
        self::TYPE_CAMELNAME     => array('id', 'recipient', 'sendername', 'senderid', 'details', 'date', 'type', 'hasread', ),
        self::TYPE_COLNAME       => array(PostcardsTableMap::COL_ID, PostcardsTableMap::COL_RECIPIENT, PostcardsTableMap::COL_SENDERNAME, PostcardsTableMap::COL_SENDERID, PostcardsTableMap::COL_DETAILS, PostcardsTableMap::COL_DATE, PostcardsTableMap::COL_TYPE, PostcardsTableMap::COL_HASREAD, ),
        self::TYPE_FIELDNAME     => array('ID', 'Recipient', 'SenderName', 'SenderID', 'Details', 'Date', 'Type', 'HasRead', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Recipient' => 1, 'Sendername' => 2, 'Senderid' => 3, 'Details' => 4, 'Date' => 5, 'Type' => 6, 'Hasread' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'recipient' => 1, 'sendername' => 2, 'senderid' => 3, 'details' => 4, 'date' => 5, 'type' => 6, 'hasread' => 7, ),
        self::TYPE_COLNAME       => array(PostcardsTableMap::COL_ID => 0, PostcardsTableMap::COL_RECIPIENT => 1, PostcardsTableMap::COL_SENDERNAME => 2, PostcardsTableMap::COL_SENDERID => 3, PostcardsTableMap::COL_DETAILS => 4, PostcardsTableMap::COL_DATE => 5, PostcardsTableMap::COL_TYPE => 6, PostcardsTableMap::COL_HASREAD => 7, ),
        self::TYPE_FIELDNAME     => array('ID' => 0, 'Recipient' => 1, 'SenderName' => 2, 'SenderID' => 3, 'Details' => 4, 'Date' => 5, 'Type' => 6, 'HasRead' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('postcards');
        $this->setPhpName('Postcards');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Postcards');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('Recipient', 'Recipient', 'INTEGER', true, 10, null);
        $this->addColumn('SenderName', 'Sendername', 'CHAR', true, 12, null);
        $this->addColumn('SenderID', 'Senderid', 'INTEGER', true, 10, null);
        $this->addColumn('Details', 'Details', 'VARCHAR', true, 12, null);
        $this->addColumn('Date', 'Date', 'INTEGER', true, 8, null);
        $this->addColumn('Type', 'Type', 'SMALLINT', true, 5, null);
        $this->addColumn('HasRead', 'Hasread', 'BOOLEAN', true, 1, false);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PostcardsTableMap::CLASS_DEFAULT : PostcardsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Postcards object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PostcardsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PostcardsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PostcardsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PostcardsTableMap::OM_CLASS;
            /** @var Postcards $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PostcardsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PostcardsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PostcardsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Postcards $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PostcardsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PostcardsTableMap::COL_ID);
            $criteria->addSelectColumn(PostcardsTableMap::COL_RECIPIENT);
            $criteria->addSelectColumn(PostcardsTableMap::COL_SENDERNAME);
            $criteria->addSelectColumn(PostcardsTableMap::COL_SENDERID);
            $criteria->addSelectColumn(PostcardsTableMap::COL_DETAILS);
            $criteria->addSelectColumn(PostcardsTableMap::COL_DATE);
            $criteria->addSelectColumn(PostcardsTableMap::COL_TYPE);
            $criteria->addSelectColumn(PostcardsTableMap::COL_HASREAD);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.Recipient');
            $criteria->addSelectColumn($alias . '.SenderName');
            $criteria->addSelectColumn($alias . '.SenderID');
            $criteria->addSelectColumn($alias . '.Details');
            $criteria->addSelectColumn($alias . '.Date');
            $criteria->addSelectColumn($alias . '.Type');
            $criteria->addSelectColumn($alias . '.HasRead');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PostcardsTableMap::DATABASE_NAME)->getTable(PostcardsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PostcardsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PostcardsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PostcardsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Postcards or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Postcards object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostcardsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Postcards) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PostcardsTableMap::DATABASE_NAME);
            $criteria->add(PostcardsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PostcardsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PostcardsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PostcardsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the postcards table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PostcardsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Postcards or Criteria object.
     *
     * @param mixed               $criteria Criteria or Postcards object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostcardsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Postcards object
        }

        if ($criteria->containsKey(PostcardsTableMap::COL_ID) && $criteria->keyContainsValue(PostcardsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PostcardsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PostcardsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PostcardsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PostcardsTableMap::buildTableMap();
