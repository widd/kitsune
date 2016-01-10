<?php

namespace Map;

use \Igloos;
use \IgloosQuery;
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
 * This class defines the structure of the 'igloos' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class IgloosTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.IgloosTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'igloos';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Igloos';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Igloos';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'igloos.ID';

    /**
     * the column name for the Owner field
     */
    const COL_OWNER = 'igloos.Owner';

    /**
     * the column name for the Type field
     */
    const COL_TYPE = 'igloos.Type';

    /**
     * the column name for the Floor field
     */
    const COL_FLOOR = 'igloos.Floor';

    /**
     * the column name for the Music field
     */
    const COL_MUSIC = 'igloos.Music';

    /**
     * the column name for the Furniture field
     */
    const COL_FURNITURE = 'igloos.Furniture';

    /**
     * the column name for the Location field
     */
    const COL_LOCATION = 'igloos.Location';

    /**
     * the column name for the Likes field
     */
    const COL_LIKES = 'igloos.Likes';

    /**
     * the column name for the Locked field
     */
    const COL_LOCKED = 'igloos.Locked';

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
        self::TYPE_PHPNAME       => array('Id', 'Owner', 'Type', 'Floor', 'Music', 'Furniture', 'Location', 'Likes', 'Locked', ),
        self::TYPE_CAMELNAME     => array('id', 'owner', 'type', 'floor', 'music', 'furniture', 'location', 'likes', 'locked', ),
        self::TYPE_COLNAME       => array(IgloosTableMap::COL_ID, IgloosTableMap::COL_OWNER, IgloosTableMap::COL_TYPE, IgloosTableMap::COL_FLOOR, IgloosTableMap::COL_MUSIC, IgloosTableMap::COL_FURNITURE, IgloosTableMap::COL_LOCATION, IgloosTableMap::COL_LIKES, IgloosTableMap::COL_LOCKED, ),
        self::TYPE_FIELDNAME     => array('ID', 'Owner', 'Type', 'Floor', 'Music', 'Furniture', 'Location', 'Likes', 'Locked', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Owner' => 1, 'Type' => 2, 'Floor' => 3, 'Music' => 4, 'Furniture' => 5, 'Location' => 6, 'Likes' => 7, 'Locked' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'owner' => 1, 'type' => 2, 'floor' => 3, 'music' => 4, 'furniture' => 5, 'location' => 6, 'likes' => 7, 'locked' => 8, ),
        self::TYPE_COLNAME       => array(IgloosTableMap::COL_ID => 0, IgloosTableMap::COL_OWNER => 1, IgloosTableMap::COL_TYPE => 2, IgloosTableMap::COL_FLOOR => 3, IgloosTableMap::COL_MUSIC => 4, IgloosTableMap::COL_FURNITURE => 5, IgloosTableMap::COL_LOCATION => 6, IgloosTableMap::COL_LIKES => 7, IgloosTableMap::COL_LOCKED => 8, ),
        self::TYPE_FIELDNAME     => array('ID' => 0, 'Owner' => 1, 'Type' => 2, 'Floor' => 3, 'Music' => 4, 'Furniture' => 5, 'Location' => 6, 'Likes' => 7, 'Locked' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('igloos');
        $this->setPhpName('Igloos');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Igloos');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('Owner', 'Owner', 'INTEGER', true, 10, null);
        $this->addColumn('Type', 'Type', 'TINYINT', true, 3, 1);
        $this->addColumn('Floor', 'Floor', 'TINYINT', true, 3, 0);
        $this->addColumn('Music', 'Music', 'SMALLINT', true, null, 0);
        $this->addColumn('Furniture', 'Furniture', 'LONGVARCHAR', true, null, null);
        $this->addColumn('Location', 'Location', 'TINYINT', true, 3, 1);
        $this->addColumn('Likes', 'Likes', 'LONGVARCHAR', true, null, null);
        $this->addColumn('Locked', 'Locked', 'BOOLEAN', true, 1, true);
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
        return $withPrefix ? IgloosTableMap::CLASS_DEFAULT : IgloosTableMap::OM_CLASS;
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
     * @return array           (Igloos object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = IgloosTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = IgloosTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + IgloosTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = IgloosTableMap::OM_CLASS;
            /** @var Igloos $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            IgloosTableMap::addInstanceToPool($obj, $key);
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
            $key = IgloosTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = IgloosTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Igloos $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                IgloosTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(IgloosTableMap::COL_ID);
            $criteria->addSelectColumn(IgloosTableMap::COL_OWNER);
            $criteria->addSelectColumn(IgloosTableMap::COL_TYPE);
            $criteria->addSelectColumn(IgloosTableMap::COL_FLOOR);
            $criteria->addSelectColumn(IgloosTableMap::COL_MUSIC);
            $criteria->addSelectColumn(IgloosTableMap::COL_FURNITURE);
            $criteria->addSelectColumn(IgloosTableMap::COL_LOCATION);
            $criteria->addSelectColumn(IgloosTableMap::COL_LIKES);
            $criteria->addSelectColumn(IgloosTableMap::COL_LOCKED);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.Owner');
            $criteria->addSelectColumn($alias . '.Type');
            $criteria->addSelectColumn($alias . '.Floor');
            $criteria->addSelectColumn($alias . '.Music');
            $criteria->addSelectColumn($alias . '.Furniture');
            $criteria->addSelectColumn($alias . '.Location');
            $criteria->addSelectColumn($alias . '.Likes');
            $criteria->addSelectColumn($alias . '.Locked');
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
        return Propel::getServiceContainer()->getDatabaseMap(IgloosTableMap::DATABASE_NAME)->getTable(IgloosTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(IgloosTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(IgloosTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new IgloosTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Igloos or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Igloos object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(IgloosTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Igloos) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(IgloosTableMap::DATABASE_NAME);
            $criteria->add(IgloosTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = IgloosQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            IgloosTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                IgloosTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the igloos table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return IgloosQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Igloos or Criteria object.
     *
     * @param mixed               $criteria Criteria or Igloos object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IgloosTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Igloos object
        }

        if ($criteria->containsKey(IgloosTableMap::COL_ID) && $criteria->keyContainsValue(IgloosTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.IgloosTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = IgloosQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // IgloosTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
IgloosTableMap::buildTableMap();
