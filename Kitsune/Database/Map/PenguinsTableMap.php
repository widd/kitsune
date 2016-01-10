<?php

namespace Kitsune\Database\Map;

use Kitsune\Database\Penguins;
use Kitsune\Database\PenguinsQuery;
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
 * This class defines the structure of the 'penguins' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PenguinsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Kitsune.Database.Map.PenguinsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'penguins';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Kitsune\\Database\\Penguins';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Kitsune.Database.Penguins';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 35;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 35;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'penguins.ID';

    /**
     * the column name for the Username field
     */
    const COL_USERNAME = 'penguins.Username';

    /**
     * the column name for the Nickname field
     */
    const COL_NICKNAME = 'penguins.Nickname';

    /**
     * the column name for the Password field
     */
    const COL_PASSWORD = 'penguins.Password';

    /**
     * the column name for the LoginKey field
     */
    const COL_LOGINKEY = 'penguins.LoginKey';

    /**
     * the column name for the ConfirmationHash field
     */
    const COL_CONFIRMATIONHASH = 'penguins.ConfirmationHash';

    /**
     * the column name for the SWID field
     */
    const COL_SWID = 'penguins.SWID';

    /**
     * the column name for the Avatar field
     */
    const COL_AVATAR = 'penguins.Avatar';

    /**
     * the column name for the AvatarAttributes field
     */
    const COL_AVATARATTRIBUTES = 'penguins.AvatarAttributes';

    /**
     * the column name for the Email field
     */
    const COL_EMAIL = 'penguins.Email';

    /**
     * the column name for the RegistrationDate field
     */
    const COL_REGISTRATIONDATE = 'penguins.RegistrationDate';

    /**
     * the column name for the Moderator field
     */
    const COL_MODERATOR = 'penguins.Moderator';

    /**
     * the column name for the Inventory field
     */
    const COL_INVENTORY = 'penguins.Inventory';

    /**
     * the column name for the CareInventory field
     */
    const COL_CAREINVENTORY = 'penguins.CareInventory';

    /**
     * the column name for the Coins field
     */
    const COL_COINS = 'penguins.Coins';

    /**
     * the column name for the Igloo field
     */
    const COL_IGLOO = 'penguins.Igloo';

    /**
     * the column name for the Igloos field
     */
    const COL_IGLOOS = 'penguins.Igloos';

    /**
     * the column name for the Floors field
     */
    const COL_FLOORS = 'penguins.Floors';

    /**
     * the column name for the Locations field
     */
    const COL_LOCATIONS = 'penguins.Locations';

    /**
     * the column name for the Furniture field
     */
    const COL_FURNITURE = 'penguins.Furniture';

    /**
     * the column name for the Color field
     */
    const COL_COLOR = 'penguins.Color';

    /**
     * the column name for the Head field
     */
    const COL_HEAD = 'penguins.Head';

    /**
     * the column name for the Face field
     */
    const COL_FACE = 'penguins.Face';

    /**
     * the column name for the Neck field
     */
    const COL_NECK = 'penguins.Neck';

    /**
     * the column name for the Body field
     */
    const COL_BODY = 'penguins.Body';

    /**
     * the column name for the Hand field
     */
    const COL_HAND = 'penguins.Hand';

    /**
     * the column name for the Feet field
     */
    const COL_FEET = 'penguins.Feet';

    /**
     * the column name for the Photo field
     */
    const COL_PHOTO = 'penguins.Photo';

    /**
     * the column name for the Flag field
     */
    const COL_FLAG = 'penguins.Flag';

    /**
     * the column name for the Walking field
     */
    const COL_WALKING = 'penguins.Walking';

    /**
     * the column name for the Banned field
     */
    const COL_BANNED = 'penguins.Banned';

    /**
     * the column name for the Stamps field
     */
    const COL_STAMPS = 'penguins.Stamps';

    /**
     * the column name for the StampBook field
     */
    const COL_STAMPBOOK = 'penguins.StampBook';

    /**
     * the column name for the EPF field
     */
    const COL_EPF = 'penguins.EPF';

    /**
     * the column name for the PuffleQuest field
     */
    const COL_PUFFLEQUEST = 'penguins.PuffleQuest';

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
        self::TYPE_PHPNAME       => array('Id', 'Username', 'Nickname', 'Password', 'Loginkey', 'Confirmationhash', 'Swid', 'Avatar', 'Avatarattributes', 'Email', 'Registrationdate', 'Moderator', 'Inventory', 'Careinventory', 'Coins', 'Igloo', 'Igloos', 'Floors', 'Locations', 'Furniture', 'Color', 'Head', 'Face', 'Neck', 'Body', 'Hand', 'Feet', 'Photo', 'Flag', 'Walking', 'Banned', 'Stamps', 'Stampbook', 'Epf', 'Pufflequest', ),
        self::TYPE_CAMELNAME     => array('id', 'username', 'nickname', 'password', 'loginkey', 'confirmationhash', 'swid', 'avatar', 'avatarattributes', 'email', 'registrationdate', 'moderator', 'inventory', 'careinventory', 'coins', 'igloo', 'igloos', 'floors', 'locations', 'furniture', 'color', 'head', 'face', 'neck', 'body', 'hand', 'feet', 'photo', 'flag', 'walking', 'banned', 'stamps', 'stampbook', 'epf', 'pufflequest', ),
        self::TYPE_COLNAME       => array(PenguinsTableMap::COL_ID, PenguinsTableMap::COL_USERNAME, PenguinsTableMap::COL_NICKNAME, PenguinsTableMap::COL_PASSWORD, PenguinsTableMap::COL_LOGINKEY, PenguinsTableMap::COL_CONFIRMATIONHASH, PenguinsTableMap::COL_SWID, PenguinsTableMap::COL_AVATAR, PenguinsTableMap::COL_AVATARATTRIBUTES, PenguinsTableMap::COL_EMAIL, PenguinsTableMap::COL_REGISTRATIONDATE, PenguinsTableMap::COL_MODERATOR, PenguinsTableMap::COL_INVENTORY, PenguinsTableMap::COL_CAREINVENTORY, PenguinsTableMap::COL_COINS, PenguinsTableMap::COL_IGLOO, PenguinsTableMap::COL_IGLOOS, PenguinsTableMap::COL_FLOORS, PenguinsTableMap::COL_LOCATIONS, PenguinsTableMap::COL_FURNITURE, PenguinsTableMap::COL_COLOR, PenguinsTableMap::COL_HEAD, PenguinsTableMap::COL_FACE, PenguinsTableMap::COL_NECK, PenguinsTableMap::COL_BODY, PenguinsTableMap::COL_HAND, PenguinsTableMap::COL_FEET, PenguinsTableMap::COL_PHOTO, PenguinsTableMap::COL_FLAG, PenguinsTableMap::COL_WALKING, PenguinsTableMap::COL_BANNED, PenguinsTableMap::COL_STAMPS, PenguinsTableMap::COL_STAMPBOOK, PenguinsTableMap::COL_EPF, PenguinsTableMap::COL_PUFFLEQUEST, ),
        self::TYPE_FIELDNAME     => array('ID', 'Username', 'Nickname', 'Password', 'LoginKey', 'ConfirmationHash', 'SWID', 'Avatar', 'AvatarAttributes', 'Email', 'RegistrationDate', 'Moderator', 'Inventory', 'CareInventory', 'Coins', 'Igloo', 'Igloos', 'Floors', 'Locations', 'Furniture', 'Color', 'Head', 'Face', 'Neck', 'Body', 'Hand', 'Feet', 'Photo', 'Flag', 'Walking', 'Banned', 'Stamps', 'StampBook', 'EPF', 'PuffleQuest', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Username' => 1, 'Nickname' => 2, 'Password' => 3, 'Loginkey' => 4, 'Confirmationhash' => 5, 'Swid' => 6, 'Avatar' => 7, 'Avatarattributes' => 8, 'Email' => 9, 'Registrationdate' => 10, 'Moderator' => 11, 'Inventory' => 12, 'Careinventory' => 13, 'Coins' => 14, 'Igloo' => 15, 'Igloos' => 16, 'Floors' => 17, 'Locations' => 18, 'Furniture' => 19, 'Color' => 20, 'Head' => 21, 'Face' => 22, 'Neck' => 23, 'Body' => 24, 'Hand' => 25, 'Feet' => 26, 'Photo' => 27, 'Flag' => 28, 'Walking' => 29, 'Banned' => 30, 'Stamps' => 31, 'Stampbook' => 32, 'Epf' => 33, 'Pufflequest' => 34, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'username' => 1, 'nickname' => 2, 'password' => 3, 'loginkey' => 4, 'confirmationhash' => 5, 'swid' => 6, 'avatar' => 7, 'avatarattributes' => 8, 'email' => 9, 'registrationdate' => 10, 'moderator' => 11, 'inventory' => 12, 'careinventory' => 13, 'coins' => 14, 'igloo' => 15, 'igloos' => 16, 'floors' => 17, 'locations' => 18, 'furniture' => 19, 'color' => 20, 'head' => 21, 'face' => 22, 'neck' => 23, 'body' => 24, 'hand' => 25, 'feet' => 26, 'photo' => 27, 'flag' => 28, 'walking' => 29, 'banned' => 30, 'stamps' => 31, 'stampbook' => 32, 'epf' => 33, 'pufflequest' => 34, ),
        self::TYPE_COLNAME       => array(PenguinsTableMap::COL_ID => 0, PenguinsTableMap::COL_USERNAME => 1, PenguinsTableMap::COL_NICKNAME => 2, PenguinsTableMap::COL_PASSWORD => 3, PenguinsTableMap::COL_LOGINKEY => 4, PenguinsTableMap::COL_CONFIRMATIONHASH => 5, PenguinsTableMap::COL_SWID => 6, PenguinsTableMap::COL_AVATAR => 7, PenguinsTableMap::COL_AVATARATTRIBUTES => 8, PenguinsTableMap::COL_EMAIL => 9, PenguinsTableMap::COL_REGISTRATIONDATE => 10, PenguinsTableMap::COL_MODERATOR => 11, PenguinsTableMap::COL_INVENTORY => 12, PenguinsTableMap::COL_CAREINVENTORY => 13, PenguinsTableMap::COL_COINS => 14, PenguinsTableMap::COL_IGLOO => 15, PenguinsTableMap::COL_IGLOOS => 16, PenguinsTableMap::COL_FLOORS => 17, PenguinsTableMap::COL_LOCATIONS => 18, PenguinsTableMap::COL_FURNITURE => 19, PenguinsTableMap::COL_COLOR => 20, PenguinsTableMap::COL_HEAD => 21, PenguinsTableMap::COL_FACE => 22, PenguinsTableMap::COL_NECK => 23, PenguinsTableMap::COL_BODY => 24, PenguinsTableMap::COL_HAND => 25, PenguinsTableMap::COL_FEET => 26, PenguinsTableMap::COL_PHOTO => 27, PenguinsTableMap::COL_FLAG => 28, PenguinsTableMap::COL_WALKING => 29, PenguinsTableMap::COL_BANNED => 30, PenguinsTableMap::COL_STAMPS => 31, PenguinsTableMap::COL_STAMPBOOK => 32, PenguinsTableMap::COL_EPF => 33, PenguinsTableMap::COL_PUFFLEQUEST => 34, ),
        self::TYPE_FIELDNAME     => array('ID' => 0, 'Username' => 1, 'Nickname' => 2, 'Password' => 3, 'LoginKey' => 4, 'ConfirmationHash' => 5, 'SWID' => 6, 'Avatar' => 7, 'AvatarAttributes' => 8, 'Email' => 9, 'RegistrationDate' => 10, 'Moderator' => 11, 'Inventory' => 12, 'CareInventory' => 13, 'Coins' => 14, 'Igloo' => 15, 'Igloos' => 16, 'Floors' => 17, 'Locations' => 18, 'Furniture' => 19, 'Color' => 20, 'Head' => 21, 'Face' => 22, 'Neck' => 23, 'Body' => 24, 'Hand' => 25, 'Feet' => 26, 'Photo' => 27, 'Flag' => 28, 'Walking' => 29, 'Banned' => 30, 'Stamps' => 31, 'StampBook' => 32, 'EPF' => 33, 'PuffleQuest' => 34, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, )
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
        $this->setName('penguins');
        $this->setPhpName('Penguins');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Kitsune\\Database\\Penguins');
        $this->setPackage('Kitsune.Database');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('Username', 'Username', 'CHAR', true, 12, null);
        $this->addColumn('Nickname', 'Nickname', 'CHAR', true, 16, null);
        $this->addColumn('Password', 'Password', 'CHAR', true, 32, null);
        $this->addColumn('LoginKey', 'Loginkey', 'CHAR', true, 32, null);
        $this->addColumn('ConfirmationHash', 'Confirmationhash', 'CHAR', true, 32, null);
        $this->addColumn('SWID', 'Swid', 'CHAR', true, 38, null);
        $this->addColumn('Avatar', 'Avatar', 'TINYINT', true, 3, 0);
        $this->addColumn('AvatarAttributes', 'Avatarattributes', 'CHAR', true, 98, '{"spriteScale":100,"spriteSpeed":100,"ignoresBlockLayer":false,"invisible":false,"floating":false}');
        $this->addColumn('Email', 'Email', 'CHAR', true, 254, null);
        $this->addColumn('RegistrationDate', 'Registrationdate', 'INTEGER', true, 8, null);
        $this->addColumn('Moderator', 'Moderator', 'BOOLEAN', true, 1, false);
        $this->addColumn('Inventory', 'Inventory', 'LONGVARCHAR', true, null, null);
        $this->addColumn('CareInventory', 'Careinventory', 'LONGVARCHAR', true, null, null);
        $this->addColumn('Coins', 'Coins', 'SMALLINT', true, 7, 200000);
        $this->addColumn('Igloo', 'Igloo', 'INTEGER', true, 10, null);
        $this->addColumn('Igloos', 'Igloos', 'LONGVARCHAR', true, null, null);
        $this->addColumn('Floors', 'Floors', 'LONGVARCHAR', true, null, null);
        $this->addColumn('Locations', 'Locations', 'LONGVARCHAR', true, null, null);
        $this->addColumn('Furniture', 'Furniture', 'LONGVARCHAR', true, null, null);
        $this->addColumn('Color', 'Color', 'TINYINT', true, 3, 1);
        $this->addColumn('Head', 'Head', 'SMALLINT', true, 5, 0);
        $this->addColumn('Face', 'Face', 'SMALLINT', true, 5, 0);
        $this->addColumn('Neck', 'Neck', 'SMALLINT', true, 5, 0);
        $this->addColumn('Body', 'Body', 'SMALLINT', true, 5, 0);
        $this->addColumn('Hand', 'Hand', 'SMALLINT', true, 5, 0);
        $this->addColumn('Feet', 'Feet', 'SMALLINT', true, 5, 0);
        $this->addColumn('Photo', 'Photo', 'SMALLINT', true, 5, 0);
        $this->addColumn('Flag', 'Flag', 'SMALLINT', true, 5, 0);
        $this->addColumn('Walking', 'Walking', 'INTEGER', true, 10, 0);
        $this->addColumn('Banned', 'Banned', 'VARCHAR', true, 20, '0');
        $this->addColumn('Stamps', 'Stamps', 'LONGVARCHAR', true, null, null);
        $this->addColumn('StampBook', 'Stampbook', 'VARCHAR', true, 150, '1%1%1%1');
        $this->addColumn('EPF', 'Epf', 'VARCHAR', true, 9, '0,0,0');
        $this->addColumn('PuffleQuest', 'Pufflequest', 'VARCHAR', true, 25, '0,1,|0;0;1403959119;');
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
        return $withPrefix ? PenguinsTableMap::CLASS_DEFAULT : PenguinsTableMap::OM_CLASS;
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
     * @return array           (Penguins object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PenguinsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PenguinsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PenguinsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PenguinsTableMap::OM_CLASS;
            /** @var Penguins $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PenguinsTableMap::addInstanceToPool($obj, $key);
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
            $key = PenguinsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PenguinsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Penguins $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PenguinsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PenguinsTableMap::COL_ID);
            $criteria->addSelectColumn(PenguinsTableMap::COL_USERNAME);
            $criteria->addSelectColumn(PenguinsTableMap::COL_NICKNAME);
            $criteria->addSelectColumn(PenguinsTableMap::COL_PASSWORD);
            $criteria->addSelectColumn(PenguinsTableMap::COL_LOGINKEY);
            $criteria->addSelectColumn(PenguinsTableMap::COL_CONFIRMATIONHASH);
            $criteria->addSelectColumn(PenguinsTableMap::COL_SWID);
            $criteria->addSelectColumn(PenguinsTableMap::COL_AVATAR);
            $criteria->addSelectColumn(PenguinsTableMap::COL_AVATARATTRIBUTES);
            $criteria->addSelectColumn(PenguinsTableMap::COL_EMAIL);
            $criteria->addSelectColumn(PenguinsTableMap::COL_REGISTRATIONDATE);
            $criteria->addSelectColumn(PenguinsTableMap::COL_MODERATOR);
            $criteria->addSelectColumn(PenguinsTableMap::COL_INVENTORY);
            $criteria->addSelectColumn(PenguinsTableMap::COL_CAREINVENTORY);
            $criteria->addSelectColumn(PenguinsTableMap::COL_COINS);
            $criteria->addSelectColumn(PenguinsTableMap::COL_IGLOO);
            $criteria->addSelectColumn(PenguinsTableMap::COL_IGLOOS);
            $criteria->addSelectColumn(PenguinsTableMap::COL_FLOORS);
            $criteria->addSelectColumn(PenguinsTableMap::COL_LOCATIONS);
            $criteria->addSelectColumn(PenguinsTableMap::COL_FURNITURE);
            $criteria->addSelectColumn(PenguinsTableMap::COL_COLOR);
            $criteria->addSelectColumn(PenguinsTableMap::COL_HEAD);
            $criteria->addSelectColumn(PenguinsTableMap::COL_FACE);
            $criteria->addSelectColumn(PenguinsTableMap::COL_NECK);
            $criteria->addSelectColumn(PenguinsTableMap::COL_BODY);
            $criteria->addSelectColumn(PenguinsTableMap::COL_HAND);
            $criteria->addSelectColumn(PenguinsTableMap::COL_FEET);
            $criteria->addSelectColumn(PenguinsTableMap::COL_PHOTO);
            $criteria->addSelectColumn(PenguinsTableMap::COL_FLAG);
            $criteria->addSelectColumn(PenguinsTableMap::COL_WALKING);
            $criteria->addSelectColumn(PenguinsTableMap::COL_BANNED);
            $criteria->addSelectColumn(PenguinsTableMap::COL_STAMPS);
            $criteria->addSelectColumn(PenguinsTableMap::COL_STAMPBOOK);
            $criteria->addSelectColumn(PenguinsTableMap::COL_EPF);
            $criteria->addSelectColumn(PenguinsTableMap::COL_PUFFLEQUEST);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.Username');
            $criteria->addSelectColumn($alias . '.Nickname');
            $criteria->addSelectColumn($alias . '.Password');
            $criteria->addSelectColumn($alias . '.LoginKey');
            $criteria->addSelectColumn($alias . '.ConfirmationHash');
            $criteria->addSelectColumn($alias . '.SWID');
            $criteria->addSelectColumn($alias . '.Avatar');
            $criteria->addSelectColumn($alias . '.AvatarAttributes');
            $criteria->addSelectColumn($alias . '.Email');
            $criteria->addSelectColumn($alias . '.RegistrationDate');
            $criteria->addSelectColumn($alias . '.Moderator');
            $criteria->addSelectColumn($alias . '.Inventory');
            $criteria->addSelectColumn($alias . '.CareInventory');
            $criteria->addSelectColumn($alias . '.Coins');
            $criteria->addSelectColumn($alias . '.Igloo');
            $criteria->addSelectColumn($alias . '.Igloos');
            $criteria->addSelectColumn($alias . '.Floors');
            $criteria->addSelectColumn($alias . '.Locations');
            $criteria->addSelectColumn($alias . '.Furniture');
            $criteria->addSelectColumn($alias . '.Color');
            $criteria->addSelectColumn($alias . '.Head');
            $criteria->addSelectColumn($alias . '.Face');
            $criteria->addSelectColumn($alias . '.Neck');
            $criteria->addSelectColumn($alias . '.Body');
            $criteria->addSelectColumn($alias . '.Hand');
            $criteria->addSelectColumn($alias . '.Feet');
            $criteria->addSelectColumn($alias . '.Photo');
            $criteria->addSelectColumn($alias . '.Flag');
            $criteria->addSelectColumn($alias . '.Walking');
            $criteria->addSelectColumn($alias . '.Banned');
            $criteria->addSelectColumn($alias . '.Stamps');
            $criteria->addSelectColumn($alias . '.StampBook');
            $criteria->addSelectColumn($alias . '.EPF');
            $criteria->addSelectColumn($alias . '.PuffleQuest');
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
        return Propel::getServiceContainer()->getDatabaseMap(PenguinsTableMap::DATABASE_NAME)->getTable(PenguinsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PenguinsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PenguinsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PenguinsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Penguins or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Penguins object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PenguinsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Kitsune\Database\Penguins) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PenguinsTableMap::DATABASE_NAME);
            $criteria->add(PenguinsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PenguinsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PenguinsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PenguinsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the penguins table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PenguinsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Penguins or Criteria object.
     *
     * @param mixed               $criteria Criteria or Penguins object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PenguinsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Penguins object
        }

        if ($criteria->containsKey(PenguinsTableMap::COL_ID) && $criteria->keyContainsValue(PenguinsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PenguinsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PenguinsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PenguinsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PenguinsTableMap::buildTableMap();
