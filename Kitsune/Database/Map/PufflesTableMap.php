<?php

namespace Map;

use \Puffles;
use \PufflesQuery;
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
 * This class defines the structure of the 'puffles' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PufflesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PufflesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'puffles';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Puffles';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Puffles';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'puffles.ID';

    /**
     * the column name for the Owner field
     */
    const COL_OWNER = 'puffles.Owner';

    /**
     * the column name for the Name field
     */
    const COL_NAME = 'puffles.Name';

    /**
     * the column name for the AdoptionDate field
     */
    const COL_ADOPTIONDATE = 'puffles.AdoptionDate';

    /**
     * the column name for the Type field
     */
    const COL_TYPE = 'puffles.Type';

    /**
     * the column name for the Subtype field
     */
    const COL_SUBTYPE = 'puffles.Subtype';

    /**
     * the column name for the Hat field
     */
    const COL_HAT = 'puffles.Hat';

    /**
     * the column name for the Food field
     */
    const COL_FOOD = 'puffles.Food';

    /**
     * the column name for the Play field
     */
    const COL_PLAY = 'puffles.Play';

    /**
     * the column name for the Rest field
     */
    const COL_REST = 'puffles.Rest';

    /**
     * the column name for the Clean field
     */
    const COL_CLEAN = 'puffles.Clean';

    /**
     * the column name for the Backyard field
     */
    const COL_BACKYARD = 'puffles.Backyard';

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
        self::TYPE_PHPNAME       => array('Id', 'Owner', 'Name', 'Adoptiondate', 'Type', 'Subtype', 'Hat', 'Food', 'Play', 'Rest', 'Clean', 'Backyard', ),
        self::TYPE_CAMELNAME     => array('id', 'owner', 'name', 'adoptiondate', 'type', 'subtype', 'hat', 'food', 'play', 'rest', 'clean', 'backyard', ),
        self::TYPE_COLNAME       => array(PufflesTableMap::COL_ID, PufflesTableMap::COL_OWNER, PufflesTableMap::COL_NAME, PufflesTableMap::COL_ADOPTIONDATE, PufflesTableMap::COL_TYPE, PufflesTableMap::COL_SUBTYPE, PufflesTableMap::COL_HAT, PufflesTableMap::COL_FOOD, PufflesTableMap::COL_PLAY, PufflesTableMap::COL_REST, PufflesTableMap::COL_CLEAN, PufflesTableMap::COL_BACKYARD, ),
        self::TYPE_FIELDNAME     => array('ID', 'Owner', 'Name', 'AdoptionDate', 'Type', 'Subtype', 'Hat', 'Food', 'Play', 'Rest', 'Clean', 'Backyard', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Owner' => 1, 'Name' => 2, 'Adoptiondate' => 3, 'Type' => 4, 'Subtype' => 5, 'Hat' => 6, 'Food' => 7, 'Play' => 8, 'Rest' => 9, 'Clean' => 10, 'Backyard' => 11, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'owner' => 1, 'name' => 2, 'adoptiondate' => 3, 'type' => 4, 'subtype' => 5, 'hat' => 6, 'food' => 7, 'play' => 8, 'rest' => 9, 'clean' => 10, 'backyard' => 11, ),
        self::TYPE_COLNAME       => array(PufflesTableMap::COL_ID => 0, PufflesTableMap::COL_OWNER => 1, PufflesTableMap::COL_NAME => 2, PufflesTableMap::COL_ADOPTIONDATE => 3, PufflesTableMap::COL_TYPE => 4, PufflesTableMap::COL_SUBTYPE => 5, PufflesTableMap::COL_HAT => 6, PufflesTableMap::COL_FOOD => 7, PufflesTableMap::COL_PLAY => 8, PufflesTableMap::COL_REST => 9, PufflesTableMap::COL_CLEAN => 10, PufflesTableMap::COL_BACKYARD => 11, ),
        self::TYPE_FIELDNAME     => array('ID' => 0, 'Owner' => 1, 'Name' => 2, 'AdoptionDate' => 3, 'Type' => 4, 'Subtype' => 5, 'Hat' => 6, 'Food' => 7, 'Play' => 8, 'Rest' => 9, 'Clean' => 10, 'Backyard' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
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
        $this->setName('puffles');
        $this->setPhpName('Puffles');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Puffles');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('Owner', 'Owner', 'INTEGER', true, 10, null);
        $this->addColumn('Name', 'Name', 'CHAR', true, 12, null);
        $this->addColumn('AdoptionDate', 'Adoptiondate', 'INTEGER', true, 8, null);
        $this->addColumn('Type', 'Type', 'TINYINT', true, 3, null);
        $this->addColumn('Subtype', 'Subtype', 'SMALLINT', true, 5, null);
        $this->addColumn('Hat', 'Hat', 'SMALLINT', true, 5, null);
        $this->addColumn('Food', 'Food', 'TINYINT', true, 3, 100);
        $this->addColumn('Play', 'Play', 'TINYINT', true, 3, 100);
        $this->addColumn('Rest', 'Rest', 'TINYINT', true, 3, 100);
        $this->addColumn('Clean', 'Clean', 'TINYINT', true, 3, 100);
        $this->addColumn('Backyard', 'Backyard', 'BOOLEAN', true, 1, false);
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
        return $withPrefix ? PufflesTableMap::CLASS_DEFAULT : PufflesTableMap::OM_CLASS;
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
     * @return array           (Puffles object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PufflesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PufflesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PufflesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PufflesTableMap::OM_CLASS;
            /** @var Puffles $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PufflesTableMap::addInstanceToPool($obj, $key);
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
            $key = PufflesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PufflesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Puffles $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PufflesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PufflesTableMap::COL_ID);
            $criteria->addSelectColumn(PufflesTableMap::COL_OWNER);
            $criteria->addSelectColumn(PufflesTableMap::COL_NAME);
            $criteria->addSelectColumn(PufflesTableMap::COL_ADOPTIONDATE);
            $criteria->addSelectColumn(PufflesTableMap::COL_TYPE);
            $criteria->addSelectColumn(PufflesTableMap::COL_SUBTYPE);
            $criteria->addSelectColumn(PufflesTableMap::COL_HAT);
            $criteria->addSelectColumn(PufflesTableMap::COL_FOOD);
            $criteria->addSelectColumn(PufflesTableMap::COL_PLAY);
            $criteria->addSelectColumn(PufflesTableMap::COL_REST);
            $criteria->addSelectColumn(PufflesTableMap::COL_CLEAN);
            $criteria->addSelectColumn(PufflesTableMap::COL_BACKYARD);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.Owner');
            $criteria->addSelectColumn($alias . '.Name');
            $criteria->addSelectColumn($alias . '.AdoptionDate');
            $criteria->addSelectColumn($alias . '.Type');
            $criteria->addSelectColumn($alias . '.Subtype');
            $criteria->addSelectColumn($alias . '.Hat');
            $criteria->addSelectColumn($alias . '.Food');
            $criteria->addSelectColumn($alias . '.Play');
            $criteria->addSelectColumn($alias . '.Rest');
            $criteria->addSelectColumn($alias . '.Clean');
            $criteria->addSelectColumn($alias . '.Backyard');
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
        return Propel::getServiceContainer()->getDatabaseMap(PufflesTableMap::DATABASE_NAME)->getTable(PufflesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PufflesTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PufflesTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PufflesTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Puffles or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Puffles object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PufflesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Puffles) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PufflesTableMap::DATABASE_NAME);
            $criteria->add(PufflesTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PufflesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PufflesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PufflesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the puffles table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PufflesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Puffles or Criteria object.
     *
     * @param mixed               $criteria Criteria or Puffles object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PufflesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Puffles object
        }

        if ($criteria->containsKey(PufflesTableMap::COL_ID) && $criteria->keyContainsValue(PufflesTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PufflesTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PufflesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PufflesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PufflesTableMap::buildTableMap();
