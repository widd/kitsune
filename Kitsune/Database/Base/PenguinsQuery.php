<?php

namespace Base;

use \Penguins as ChildPenguins;
use \PenguinsQuery as ChildPenguinsQuery;
use \Exception;
use \PDO;
use Map\PenguinsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'penguins' table.
 *
 * 
 *
 * @method     ChildPenguinsQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildPenguinsQuery orderByUsername($order = Criteria::ASC) Order by the Username column
 * @method     ChildPenguinsQuery orderByNickname($order = Criteria::ASC) Order by the Nickname column
 * @method     ChildPenguinsQuery orderByPassword($order = Criteria::ASC) Order by the Password column
 * @method     ChildPenguinsQuery orderByLoginkey($order = Criteria::ASC) Order by the LoginKey column
 * @method     ChildPenguinsQuery orderByConfirmationhash($order = Criteria::ASC) Order by the ConfirmationHash column
 * @method     ChildPenguinsQuery orderBySwid($order = Criteria::ASC) Order by the SWID column
 * @method     ChildPenguinsQuery orderByAvatar($order = Criteria::ASC) Order by the Avatar column
 * @method     ChildPenguinsQuery orderByAvatarattributes($order = Criteria::ASC) Order by the AvatarAttributes column
 * @method     ChildPenguinsQuery orderByEmail($order = Criteria::ASC) Order by the Email column
 * @method     ChildPenguinsQuery orderByRegistrationdate($order = Criteria::ASC) Order by the RegistrationDate column
 * @method     ChildPenguinsQuery orderByModerator($order = Criteria::ASC) Order by the Moderator column
 * @method     ChildPenguinsQuery orderByInventory($order = Criteria::ASC) Order by the Inventory column
 * @method     ChildPenguinsQuery orderByCareinventory($order = Criteria::ASC) Order by the CareInventory column
 * @method     ChildPenguinsQuery orderByCoins($order = Criteria::ASC) Order by the Coins column
 * @method     ChildPenguinsQuery orderByIgloo($order = Criteria::ASC) Order by the Igloo column
 * @method     ChildPenguinsQuery orderByIgloos($order = Criteria::ASC) Order by the Igloos column
 * @method     ChildPenguinsQuery orderByFloors($order = Criteria::ASC) Order by the Floors column
 * @method     ChildPenguinsQuery orderByLocations($order = Criteria::ASC) Order by the Locations column
 * @method     ChildPenguinsQuery orderByFurniture($order = Criteria::ASC) Order by the Furniture column
 * @method     ChildPenguinsQuery orderByColor($order = Criteria::ASC) Order by the Color column
 * @method     ChildPenguinsQuery orderByHead($order = Criteria::ASC) Order by the Head column
 * @method     ChildPenguinsQuery orderByFace($order = Criteria::ASC) Order by the Face column
 * @method     ChildPenguinsQuery orderByNeck($order = Criteria::ASC) Order by the Neck column
 * @method     ChildPenguinsQuery orderByBody($order = Criteria::ASC) Order by the Body column
 * @method     ChildPenguinsQuery orderByHand($order = Criteria::ASC) Order by the Hand column
 * @method     ChildPenguinsQuery orderByFeet($order = Criteria::ASC) Order by the Feet column
 * @method     ChildPenguinsQuery orderByPhoto($order = Criteria::ASC) Order by the Photo column
 * @method     ChildPenguinsQuery orderByFlag($order = Criteria::ASC) Order by the Flag column
 * @method     ChildPenguinsQuery orderByWalking($order = Criteria::ASC) Order by the Walking column
 * @method     ChildPenguinsQuery orderByBanned($order = Criteria::ASC) Order by the Banned column
 * @method     ChildPenguinsQuery orderByStamps($order = Criteria::ASC) Order by the Stamps column
 * @method     ChildPenguinsQuery orderByStampbook($order = Criteria::ASC) Order by the StampBook column
 * @method     ChildPenguinsQuery orderByEpf($order = Criteria::ASC) Order by the EPF column
 * @method     ChildPenguinsQuery orderByPufflequest($order = Criteria::ASC) Order by the PuffleQuest column
 *
 * @method     ChildPenguinsQuery groupById() Group by the ID column
 * @method     ChildPenguinsQuery groupByUsername() Group by the Username column
 * @method     ChildPenguinsQuery groupByNickname() Group by the Nickname column
 * @method     ChildPenguinsQuery groupByPassword() Group by the Password column
 * @method     ChildPenguinsQuery groupByLoginkey() Group by the LoginKey column
 * @method     ChildPenguinsQuery groupByConfirmationhash() Group by the ConfirmationHash column
 * @method     ChildPenguinsQuery groupBySwid() Group by the SWID column
 * @method     ChildPenguinsQuery groupByAvatar() Group by the Avatar column
 * @method     ChildPenguinsQuery groupByAvatarattributes() Group by the AvatarAttributes column
 * @method     ChildPenguinsQuery groupByEmail() Group by the Email column
 * @method     ChildPenguinsQuery groupByRegistrationdate() Group by the RegistrationDate column
 * @method     ChildPenguinsQuery groupByModerator() Group by the Moderator column
 * @method     ChildPenguinsQuery groupByInventory() Group by the Inventory column
 * @method     ChildPenguinsQuery groupByCareinventory() Group by the CareInventory column
 * @method     ChildPenguinsQuery groupByCoins() Group by the Coins column
 * @method     ChildPenguinsQuery groupByIgloo() Group by the Igloo column
 * @method     ChildPenguinsQuery groupByIgloos() Group by the Igloos column
 * @method     ChildPenguinsQuery groupByFloors() Group by the Floors column
 * @method     ChildPenguinsQuery groupByLocations() Group by the Locations column
 * @method     ChildPenguinsQuery groupByFurniture() Group by the Furniture column
 * @method     ChildPenguinsQuery groupByColor() Group by the Color column
 * @method     ChildPenguinsQuery groupByHead() Group by the Head column
 * @method     ChildPenguinsQuery groupByFace() Group by the Face column
 * @method     ChildPenguinsQuery groupByNeck() Group by the Neck column
 * @method     ChildPenguinsQuery groupByBody() Group by the Body column
 * @method     ChildPenguinsQuery groupByHand() Group by the Hand column
 * @method     ChildPenguinsQuery groupByFeet() Group by the Feet column
 * @method     ChildPenguinsQuery groupByPhoto() Group by the Photo column
 * @method     ChildPenguinsQuery groupByFlag() Group by the Flag column
 * @method     ChildPenguinsQuery groupByWalking() Group by the Walking column
 * @method     ChildPenguinsQuery groupByBanned() Group by the Banned column
 * @method     ChildPenguinsQuery groupByStamps() Group by the Stamps column
 * @method     ChildPenguinsQuery groupByStampbook() Group by the StampBook column
 * @method     ChildPenguinsQuery groupByEpf() Group by the EPF column
 * @method     ChildPenguinsQuery groupByPufflequest() Group by the PuffleQuest column
 *
 * @method     ChildPenguinsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPenguinsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPenguinsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPenguinsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPenguinsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPenguinsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPenguins findOne(ConnectionInterface $con = null) Return the first ChildPenguins matching the query
 * @method     ChildPenguins findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPenguins matching the query, or a new ChildPenguins object populated from the query conditions when no match is found
 *
 * @method     ChildPenguins findOneById(int $ID) Return the first ChildPenguins filtered by the ID column
 * @method     ChildPenguins findOneByUsername(string $Username) Return the first ChildPenguins filtered by the Username column
 * @method     ChildPenguins findOneByNickname(string $Nickname) Return the first ChildPenguins filtered by the Nickname column
 * @method     ChildPenguins findOneByPassword(string $Password) Return the first ChildPenguins filtered by the Password column
 * @method     ChildPenguins findOneByLoginkey(string $LoginKey) Return the first ChildPenguins filtered by the LoginKey column
 * @method     ChildPenguins findOneByConfirmationhash(string $ConfirmationHash) Return the first ChildPenguins filtered by the ConfirmationHash column
 * @method     ChildPenguins findOneBySwid(string $SWID) Return the first ChildPenguins filtered by the SWID column
 * @method     ChildPenguins findOneByAvatar(int $Avatar) Return the first ChildPenguins filtered by the Avatar column
 * @method     ChildPenguins findOneByAvatarattributes(string $AvatarAttributes) Return the first ChildPenguins filtered by the AvatarAttributes column
 * @method     ChildPenguins findOneByEmail(string $Email) Return the first ChildPenguins filtered by the Email column
 * @method     ChildPenguins findOneByRegistrationdate(int $RegistrationDate) Return the first ChildPenguins filtered by the RegistrationDate column
 * @method     ChildPenguins findOneByModerator(boolean $Moderator) Return the first ChildPenguins filtered by the Moderator column
 * @method     ChildPenguins findOneByInventory(string $Inventory) Return the first ChildPenguins filtered by the Inventory column
 * @method     ChildPenguins findOneByCareinventory(string $CareInventory) Return the first ChildPenguins filtered by the CareInventory column
 * @method     ChildPenguins findOneByCoins(int $Coins) Return the first ChildPenguins filtered by the Coins column
 * @method     ChildPenguins findOneByIgloo(int $Igloo) Return the first ChildPenguins filtered by the Igloo column
 * @method     ChildPenguins findOneByIgloos(string $Igloos) Return the first ChildPenguins filtered by the Igloos column
 * @method     ChildPenguins findOneByFloors(string $Floors) Return the first ChildPenguins filtered by the Floors column
 * @method     ChildPenguins findOneByLocations(string $Locations) Return the first ChildPenguins filtered by the Locations column
 * @method     ChildPenguins findOneByFurniture(string $Furniture) Return the first ChildPenguins filtered by the Furniture column
 * @method     ChildPenguins findOneByColor(int $Color) Return the first ChildPenguins filtered by the Color column
 * @method     ChildPenguins findOneByHead(int $Head) Return the first ChildPenguins filtered by the Head column
 * @method     ChildPenguins findOneByFace(int $Face) Return the first ChildPenguins filtered by the Face column
 * @method     ChildPenguins findOneByNeck(int $Neck) Return the first ChildPenguins filtered by the Neck column
 * @method     ChildPenguins findOneByBody(int $Body) Return the first ChildPenguins filtered by the Body column
 * @method     ChildPenguins findOneByHand(int $Hand) Return the first ChildPenguins filtered by the Hand column
 * @method     ChildPenguins findOneByFeet(int $Feet) Return the first ChildPenguins filtered by the Feet column
 * @method     ChildPenguins findOneByPhoto(int $Photo) Return the first ChildPenguins filtered by the Photo column
 * @method     ChildPenguins findOneByFlag(int $Flag) Return the first ChildPenguins filtered by the Flag column
 * @method     ChildPenguins findOneByWalking(int $Walking) Return the first ChildPenguins filtered by the Walking column
 * @method     ChildPenguins findOneByBanned(string $Banned) Return the first ChildPenguins filtered by the Banned column
 * @method     ChildPenguins findOneByStamps(string $Stamps) Return the first ChildPenguins filtered by the Stamps column
 * @method     ChildPenguins findOneByStampbook(string $StampBook) Return the first ChildPenguins filtered by the StampBook column
 * @method     ChildPenguins findOneByEpf(string $EPF) Return the first ChildPenguins filtered by the EPF column
 * @method     ChildPenguins findOneByPufflequest(string $PuffleQuest) Return the first ChildPenguins filtered by the PuffleQuest column *

 * @method     ChildPenguins requirePk($key, ConnectionInterface $con = null) Return the ChildPenguins by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOne(ConnectionInterface $con = null) Return the first ChildPenguins matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPenguins requireOneById(int $ID) Return the first ChildPenguins filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByUsername(string $Username) Return the first ChildPenguins filtered by the Username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByNickname(string $Nickname) Return the first ChildPenguins filtered by the Nickname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByPassword(string $Password) Return the first ChildPenguins filtered by the Password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByLoginkey(string $LoginKey) Return the first ChildPenguins filtered by the LoginKey column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByConfirmationhash(string $ConfirmationHash) Return the first ChildPenguins filtered by the ConfirmationHash column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneBySwid(string $SWID) Return the first ChildPenguins filtered by the SWID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByAvatar(int $Avatar) Return the first ChildPenguins filtered by the Avatar column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByAvatarattributes(string $AvatarAttributes) Return the first ChildPenguins filtered by the AvatarAttributes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByEmail(string $Email) Return the first ChildPenguins filtered by the Email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByRegistrationdate(int $RegistrationDate) Return the first ChildPenguins filtered by the RegistrationDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByModerator(boolean $Moderator) Return the first ChildPenguins filtered by the Moderator column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByInventory(string $Inventory) Return the first ChildPenguins filtered by the Inventory column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByCareinventory(string $CareInventory) Return the first ChildPenguins filtered by the CareInventory column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByCoins(int $Coins) Return the first ChildPenguins filtered by the Coins column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByIgloo(int $Igloo) Return the first ChildPenguins filtered by the Igloo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByIgloos(string $Igloos) Return the first ChildPenguins filtered by the Igloos column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByFloors(string $Floors) Return the first ChildPenguins filtered by the Floors column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByLocations(string $Locations) Return the first ChildPenguins filtered by the Locations column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByFurniture(string $Furniture) Return the first ChildPenguins filtered by the Furniture column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByColor(int $Color) Return the first ChildPenguins filtered by the Color column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByHead(int $Head) Return the first ChildPenguins filtered by the Head column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByFace(int $Face) Return the first ChildPenguins filtered by the Face column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByNeck(int $Neck) Return the first ChildPenguins filtered by the Neck column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByBody(int $Body) Return the first ChildPenguins filtered by the Body column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByHand(int $Hand) Return the first ChildPenguins filtered by the Hand column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByFeet(int $Feet) Return the first ChildPenguins filtered by the Feet column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByPhoto(int $Photo) Return the first ChildPenguins filtered by the Photo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByFlag(int $Flag) Return the first ChildPenguins filtered by the Flag column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByWalking(int $Walking) Return the first ChildPenguins filtered by the Walking column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByBanned(string $Banned) Return the first ChildPenguins filtered by the Banned column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByStamps(string $Stamps) Return the first ChildPenguins filtered by the Stamps column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByStampbook(string $StampBook) Return the first ChildPenguins filtered by the StampBook column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByEpf(string $EPF) Return the first ChildPenguins filtered by the EPF column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPenguins requireOneByPufflequest(string $PuffleQuest) Return the first ChildPenguins filtered by the PuffleQuest column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPenguins[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPenguins objects based on current ModelCriteria
 * @method     ChildPenguins[]|ObjectCollection findById(int $ID) Return ChildPenguins objects filtered by the ID column
 * @method     ChildPenguins[]|ObjectCollection findByUsername(string $Username) Return ChildPenguins objects filtered by the Username column
 * @method     ChildPenguins[]|ObjectCollection findByNickname(string $Nickname) Return ChildPenguins objects filtered by the Nickname column
 * @method     ChildPenguins[]|ObjectCollection findByPassword(string $Password) Return ChildPenguins objects filtered by the Password column
 * @method     ChildPenguins[]|ObjectCollection findByLoginkey(string $LoginKey) Return ChildPenguins objects filtered by the LoginKey column
 * @method     ChildPenguins[]|ObjectCollection findByConfirmationhash(string $ConfirmationHash) Return ChildPenguins objects filtered by the ConfirmationHash column
 * @method     ChildPenguins[]|ObjectCollection findBySwid(string $SWID) Return ChildPenguins objects filtered by the SWID column
 * @method     ChildPenguins[]|ObjectCollection findByAvatar(int $Avatar) Return ChildPenguins objects filtered by the Avatar column
 * @method     ChildPenguins[]|ObjectCollection findByAvatarattributes(string $AvatarAttributes) Return ChildPenguins objects filtered by the AvatarAttributes column
 * @method     ChildPenguins[]|ObjectCollection findByEmail(string $Email) Return ChildPenguins objects filtered by the Email column
 * @method     ChildPenguins[]|ObjectCollection findByRegistrationdate(int $RegistrationDate) Return ChildPenguins objects filtered by the RegistrationDate column
 * @method     ChildPenguins[]|ObjectCollection findByModerator(boolean $Moderator) Return ChildPenguins objects filtered by the Moderator column
 * @method     ChildPenguins[]|ObjectCollection findByInventory(string $Inventory) Return ChildPenguins objects filtered by the Inventory column
 * @method     ChildPenguins[]|ObjectCollection findByCareinventory(string $CareInventory) Return ChildPenguins objects filtered by the CareInventory column
 * @method     ChildPenguins[]|ObjectCollection findByCoins(int $Coins) Return ChildPenguins objects filtered by the Coins column
 * @method     ChildPenguins[]|ObjectCollection findByIgloo(int $Igloo) Return ChildPenguins objects filtered by the Igloo column
 * @method     ChildPenguins[]|ObjectCollection findByIgloos(string $Igloos) Return ChildPenguins objects filtered by the Igloos column
 * @method     ChildPenguins[]|ObjectCollection findByFloors(string $Floors) Return ChildPenguins objects filtered by the Floors column
 * @method     ChildPenguins[]|ObjectCollection findByLocations(string $Locations) Return ChildPenguins objects filtered by the Locations column
 * @method     ChildPenguins[]|ObjectCollection findByFurniture(string $Furniture) Return ChildPenguins objects filtered by the Furniture column
 * @method     ChildPenguins[]|ObjectCollection findByColor(int $Color) Return ChildPenguins objects filtered by the Color column
 * @method     ChildPenguins[]|ObjectCollection findByHead(int $Head) Return ChildPenguins objects filtered by the Head column
 * @method     ChildPenguins[]|ObjectCollection findByFace(int $Face) Return ChildPenguins objects filtered by the Face column
 * @method     ChildPenguins[]|ObjectCollection findByNeck(int $Neck) Return ChildPenguins objects filtered by the Neck column
 * @method     ChildPenguins[]|ObjectCollection findByBody(int $Body) Return ChildPenguins objects filtered by the Body column
 * @method     ChildPenguins[]|ObjectCollection findByHand(int $Hand) Return ChildPenguins objects filtered by the Hand column
 * @method     ChildPenguins[]|ObjectCollection findByFeet(int $Feet) Return ChildPenguins objects filtered by the Feet column
 * @method     ChildPenguins[]|ObjectCollection findByPhoto(int $Photo) Return ChildPenguins objects filtered by the Photo column
 * @method     ChildPenguins[]|ObjectCollection findByFlag(int $Flag) Return ChildPenguins objects filtered by the Flag column
 * @method     ChildPenguins[]|ObjectCollection findByWalking(int $Walking) Return ChildPenguins objects filtered by the Walking column
 * @method     ChildPenguins[]|ObjectCollection findByBanned(string $Banned) Return ChildPenguins objects filtered by the Banned column
 * @method     ChildPenguins[]|ObjectCollection findByStamps(string $Stamps) Return ChildPenguins objects filtered by the Stamps column
 * @method     ChildPenguins[]|ObjectCollection findByStampbook(string $StampBook) Return ChildPenguins objects filtered by the StampBook column
 * @method     ChildPenguins[]|ObjectCollection findByEpf(string $EPF) Return ChildPenguins objects filtered by the EPF column
 * @method     ChildPenguins[]|ObjectCollection findByPufflequest(string $PuffleQuest) Return ChildPenguins objects filtered by the PuffleQuest column
 * @method     ChildPenguins[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PenguinsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PenguinsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Penguins', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPenguinsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPenguinsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPenguinsQuery) {
            return $criteria;
        }
        $query = new ChildPenguinsQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPenguins|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PenguinsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PenguinsTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPenguins A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, Username, Nickname, Password, LoginKey, ConfirmationHash, SWID, Avatar, AvatarAttributes, Email, RegistrationDate, Moderator, Inventory, CareInventory, Coins, Igloo, Igloos, Floors, Locations, Furniture, Color, Head, Face, Neck, Body, Hand, Feet, Photo, Flag, Walking, Banned, Stamps, StampBook, EPF, PuffleQuest FROM penguins WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPenguins $obj */
            $obj = new ChildPenguins();
            $obj->hydrate($row);
            PenguinsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildPenguins|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PenguinsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PenguinsTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE ID = 1234
     * $query->filterById(array(12, 34)); // WHERE ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE ID > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the Username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE Username = 'fooValue'
     * $query->filterByUsername('%fooValue%'); // WHERE Username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $username)) {
                $username = str_replace('*', '%', $username);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the Nickname column
     *
     * Example usage:
     * <code>
     * $query->filterByNickname('fooValue');   // WHERE Nickname = 'fooValue'
     * $query->filterByNickname('%fooValue%'); // WHERE Nickname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nickname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByNickname($nickname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nickname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nickname)) {
                $nickname = str_replace('*', '%', $nickname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_NICKNAME, $nickname, $comparison);
    }

    /**
     * Filter the query on the Password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE Password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE Password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the LoginKey column
     *
     * Example usage:
     * <code>
     * $query->filterByLoginkey('fooValue');   // WHERE LoginKey = 'fooValue'
     * $query->filterByLoginkey('%fooValue%'); // WHERE LoginKey LIKE '%fooValue%'
     * </code>
     *
     * @param     string $loginkey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByLoginkey($loginkey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($loginkey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $loginkey)) {
                $loginkey = str_replace('*', '%', $loginkey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_LOGINKEY, $loginkey, $comparison);
    }

    /**
     * Filter the query on the ConfirmationHash column
     *
     * Example usage:
     * <code>
     * $query->filterByConfirmationhash('fooValue');   // WHERE ConfirmationHash = 'fooValue'
     * $query->filterByConfirmationhash('%fooValue%'); // WHERE ConfirmationHash LIKE '%fooValue%'
     * </code>
     *
     * @param     string $confirmationhash The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByConfirmationhash($confirmationhash = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($confirmationhash)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $confirmationhash)) {
                $confirmationhash = str_replace('*', '%', $confirmationhash);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_CONFIRMATIONHASH, $confirmationhash, $comparison);
    }

    /**
     * Filter the query on the SWID column
     *
     * Example usage:
     * <code>
     * $query->filterBySwid('fooValue');   // WHERE SWID = 'fooValue'
     * $query->filterBySwid('%fooValue%'); // WHERE SWID LIKE '%fooValue%'
     * </code>
     *
     * @param     string $swid The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterBySwid($swid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($swid)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $swid)) {
                $swid = str_replace('*', '%', $swid);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_SWID, $swid, $comparison);
    }

    /**
     * Filter the query on the Avatar column
     *
     * Example usage:
     * <code>
     * $query->filterByAvatar(1234); // WHERE Avatar = 1234
     * $query->filterByAvatar(array(12, 34)); // WHERE Avatar IN (12, 34)
     * $query->filterByAvatar(array('min' => 12)); // WHERE Avatar > 12
     * </code>
     *
     * @param     mixed $avatar The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByAvatar($avatar = null, $comparison = null)
    {
        if (is_array($avatar)) {
            $useMinMax = false;
            if (isset($avatar['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_AVATAR, $avatar['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($avatar['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_AVATAR, $avatar['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_AVATAR, $avatar, $comparison);
    }

    /**
     * Filter the query on the AvatarAttributes column
     *
     * Example usage:
     * <code>
     * $query->filterByAvatarattributes('fooValue');   // WHERE AvatarAttributes = 'fooValue'
     * $query->filterByAvatarattributes('%fooValue%'); // WHERE AvatarAttributes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $avatarattributes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByAvatarattributes($avatarattributes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($avatarattributes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $avatarattributes)) {
                $avatarattributes = str_replace('*', '%', $avatarattributes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_AVATARATTRIBUTES, $avatarattributes, $comparison);
    }

    /**
     * Filter the query on the Email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE Email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE Email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the RegistrationDate column
     *
     * Example usage:
     * <code>
     * $query->filterByRegistrationdate(1234); // WHERE RegistrationDate = 1234
     * $query->filterByRegistrationdate(array(12, 34)); // WHERE RegistrationDate IN (12, 34)
     * $query->filterByRegistrationdate(array('min' => 12)); // WHERE RegistrationDate > 12
     * </code>
     *
     * @param     mixed $registrationdate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByRegistrationdate($registrationdate = null, $comparison = null)
    {
        if (is_array($registrationdate)) {
            $useMinMax = false;
            if (isset($registrationdate['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_REGISTRATIONDATE, $registrationdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($registrationdate['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_REGISTRATIONDATE, $registrationdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_REGISTRATIONDATE, $registrationdate, $comparison);
    }

    /**
     * Filter the query on the Moderator column
     *
     * Example usage:
     * <code>
     * $query->filterByModerator(true); // WHERE Moderator = true
     * $query->filterByModerator('yes'); // WHERE Moderator = true
     * </code>
     *
     * @param     boolean|string $moderator The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByModerator($moderator = null, $comparison = null)
    {
        if (is_string($moderator)) {
            $moderator = in_array(strtolower($moderator), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_MODERATOR, $moderator, $comparison);
    }

    /**
     * Filter the query on the Inventory column
     *
     * Example usage:
     * <code>
     * $query->filterByInventory('fooValue');   // WHERE Inventory = 'fooValue'
     * $query->filterByInventory('%fooValue%'); // WHERE Inventory LIKE '%fooValue%'
     * </code>
     *
     * @param     string $inventory The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByInventory($inventory = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($inventory)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $inventory)) {
                $inventory = str_replace('*', '%', $inventory);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_INVENTORY, $inventory, $comparison);
    }

    /**
     * Filter the query on the CareInventory column
     *
     * Example usage:
     * <code>
     * $query->filterByCareinventory('fooValue');   // WHERE CareInventory = 'fooValue'
     * $query->filterByCareinventory('%fooValue%'); // WHERE CareInventory LIKE '%fooValue%'
     * </code>
     *
     * @param     string $careinventory The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByCareinventory($careinventory = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($careinventory)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $careinventory)) {
                $careinventory = str_replace('*', '%', $careinventory);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_CAREINVENTORY, $careinventory, $comparison);
    }

    /**
     * Filter the query on the Coins column
     *
     * Example usage:
     * <code>
     * $query->filterByCoins(1234); // WHERE Coins = 1234
     * $query->filterByCoins(array(12, 34)); // WHERE Coins IN (12, 34)
     * $query->filterByCoins(array('min' => 12)); // WHERE Coins > 12
     * </code>
     *
     * @param     mixed $coins The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByCoins($coins = null, $comparison = null)
    {
        if (is_array($coins)) {
            $useMinMax = false;
            if (isset($coins['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_COINS, $coins['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($coins['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_COINS, $coins['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_COINS, $coins, $comparison);
    }

    /**
     * Filter the query on the Igloo column
     *
     * Example usage:
     * <code>
     * $query->filterByIgloo(1234); // WHERE Igloo = 1234
     * $query->filterByIgloo(array(12, 34)); // WHERE Igloo IN (12, 34)
     * $query->filterByIgloo(array('min' => 12)); // WHERE Igloo > 12
     * </code>
     *
     * @param     mixed $igloo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByIgloo($igloo = null, $comparison = null)
    {
        if (is_array($igloo)) {
            $useMinMax = false;
            if (isset($igloo['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_IGLOO, $igloo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($igloo['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_IGLOO, $igloo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_IGLOO, $igloo, $comparison);
    }

    /**
     * Filter the query on the Igloos column
     *
     * Example usage:
     * <code>
     * $query->filterByIgloos('fooValue');   // WHERE Igloos = 'fooValue'
     * $query->filterByIgloos('%fooValue%'); // WHERE Igloos LIKE '%fooValue%'
     * </code>
     *
     * @param     string $igloos The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByIgloos($igloos = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($igloos)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $igloos)) {
                $igloos = str_replace('*', '%', $igloos);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_IGLOOS, $igloos, $comparison);
    }

    /**
     * Filter the query on the Floors column
     *
     * Example usage:
     * <code>
     * $query->filterByFloors('fooValue');   // WHERE Floors = 'fooValue'
     * $query->filterByFloors('%fooValue%'); // WHERE Floors LIKE '%fooValue%'
     * </code>
     *
     * @param     string $floors The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByFloors($floors = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($floors)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $floors)) {
                $floors = str_replace('*', '%', $floors);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_FLOORS, $floors, $comparison);
    }

    /**
     * Filter the query on the Locations column
     *
     * Example usage:
     * <code>
     * $query->filterByLocations('fooValue');   // WHERE Locations = 'fooValue'
     * $query->filterByLocations('%fooValue%'); // WHERE Locations LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locations The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByLocations($locations = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locations)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locations)) {
                $locations = str_replace('*', '%', $locations);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_LOCATIONS, $locations, $comparison);
    }

    /**
     * Filter the query on the Furniture column
     *
     * Example usage:
     * <code>
     * $query->filterByFurniture('fooValue');   // WHERE Furniture = 'fooValue'
     * $query->filterByFurniture('%fooValue%'); // WHERE Furniture LIKE '%fooValue%'
     * </code>
     *
     * @param     string $furniture The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByFurniture($furniture = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($furniture)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $furniture)) {
                $furniture = str_replace('*', '%', $furniture);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_FURNITURE, $furniture, $comparison);
    }

    /**
     * Filter the query on the Color column
     *
     * Example usage:
     * <code>
     * $query->filterByColor(1234); // WHERE Color = 1234
     * $query->filterByColor(array(12, 34)); // WHERE Color IN (12, 34)
     * $query->filterByColor(array('min' => 12)); // WHERE Color > 12
     * </code>
     *
     * @param     mixed $color The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByColor($color = null, $comparison = null)
    {
        if (is_array($color)) {
            $useMinMax = false;
            if (isset($color['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_COLOR, $color['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($color['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_COLOR, $color['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_COLOR, $color, $comparison);
    }

    /**
     * Filter the query on the Head column
     *
     * Example usage:
     * <code>
     * $query->filterByHead(1234); // WHERE Head = 1234
     * $query->filterByHead(array(12, 34)); // WHERE Head IN (12, 34)
     * $query->filterByHead(array('min' => 12)); // WHERE Head > 12
     * </code>
     *
     * @param     mixed $head The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByHead($head = null, $comparison = null)
    {
        if (is_array($head)) {
            $useMinMax = false;
            if (isset($head['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_HEAD, $head['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($head['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_HEAD, $head['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_HEAD, $head, $comparison);
    }

    /**
     * Filter the query on the Face column
     *
     * Example usage:
     * <code>
     * $query->filterByFace(1234); // WHERE Face = 1234
     * $query->filterByFace(array(12, 34)); // WHERE Face IN (12, 34)
     * $query->filterByFace(array('min' => 12)); // WHERE Face > 12
     * </code>
     *
     * @param     mixed $face The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByFace($face = null, $comparison = null)
    {
        if (is_array($face)) {
            $useMinMax = false;
            if (isset($face['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_FACE, $face['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($face['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_FACE, $face['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_FACE, $face, $comparison);
    }

    /**
     * Filter the query on the Neck column
     *
     * Example usage:
     * <code>
     * $query->filterByNeck(1234); // WHERE Neck = 1234
     * $query->filterByNeck(array(12, 34)); // WHERE Neck IN (12, 34)
     * $query->filterByNeck(array('min' => 12)); // WHERE Neck > 12
     * </code>
     *
     * @param     mixed $neck The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByNeck($neck = null, $comparison = null)
    {
        if (is_array($neck)) {
            $useMinMax = false;
            if (isset($neck['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_NECK, $neck['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($neck['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_NECK, $neck['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_NECK, $neck, $comparison);
    }

    /**
     * Filter the query on the Body column
     *
     * Example usage:
     * <code>
     * $query->filterByBody(1234); // WHERE Body = 1234
     * $query->filterByBody(array(12, 34)); // WHERE Body IN (12, 34)
     * $query->filterByBody(array('min' => 12)); // WHERE Body > 12
     * </code>
     *
     * @param     mixed $body The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByBody($body = null, $comparison = null)
    {
        if (is_array($body)) {
            $useMinMax = false;
            if (isset($body['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_BODY, $body['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($body['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_BODY, $body['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_BODY, $body, $comparison);
    }

    /**
     * Filter the query on the Hand column
     *
     * Example usage:
     * <code>
     * $query->filterByHand(1234); // WHERE Hand = 1234
     * $query->filterByHand(array(12, 34)); // WHERE Hand IN (12, 34)
     * $query->filterByHand(array('min' => 12)); // WHERE Hand > 12
     * </code>
     *
     * @param     mixed $hand The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByHand($hand = null, $comparison = null)
    {
        if (is_array($hand)) {
            $useMinMax = false;
            if (isset($hand['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_HAND, $hand['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hand['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_HAND, $hand['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_HAND, $hand, $comparison);
    }

    /**
     * Filter the query on the Feet column
     *
     * Example usage:
     * <code>
     * $query->filterByFeet(1234); // WHERE Feet = 1234
     * $query->filterByFeet(array(12, 34)); // WHERE Feet IN (12, 34)
     * $query->filterByFeet(array('min' => 12)); // WHERE Feet > 12
     * </code>
     *
     * @param     mixed $feet The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByFeet($feet = null, $comparison = null)
    {
        if (is_array($feet)) {
            $useMinMax = false;
            if (isset($feet['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_FEET, $feet['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($feet['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_FEET, $feet['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_FEET, $feet, $comparison);
    }

    /**
     * Filter the query on the Photo column
     *
     * Example usage:
     * <code>
     * $query->filterByPhoto(1234); // WHERE Photo = 1234
     * $query->filterByPhoto(array(12, 34)); // WHERE Photo IN (12, 34)
     * $query->filterByPhoto(array('min' => 12)); // WHERE Photo > 12
     * </code>
     *
     * @param     mixed $photo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByPhoto($photo = null, $comparison = null)
    {
        if (is_array($photo)) {
            $useMinMax = false;
            if (isset($photo['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_PHOTO, $photo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($photo['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_PHOTO, $photo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_PHOTO, $photo, $comparison);
    }

    /**
     * Filter the query on the Flag column
     *
     * Example usage:
     * <code>
     * $query->filterByFlag(1234); // WHERE Flag = 1234
     * $query->filterByFlag(array(12, 34)); // WHERE Flag IN (12, 34)
     * $query->filterByFlag(array('min' => 12)); // WHERE Flag > 12
     * </code>
     *
     * @param     mixed $flag The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByFlag($flag = null, $comparison = null)
    {
        if (is_array($flag)) {
            $useMinMax = false;
            if (isset($flag['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_FLAG, $flag['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($flag['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_FLAG, $flag['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_FLAG, $flag, $comparison);
    }

    /**
     * Filter the query on the Walking column
     *
     * Example usage:
     * <code>
     * $query->filterByWalking(1234); // WHERE Walking = 1234
     * $query->filterByWalking(array(12, 34)); // WHERE Walking IN (12, 34)
     * $query->filterByWalking(array('min' => 12)); // WHERE Walking > 12
     * </code>
     *
     * @param     mixed $walking The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByWalking($walking = null, $comparison = null)
    {
        if (is_array($walking)) {
            $useMinMax = false;
            if (isset($walking['min'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_WALKING, $walking['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($walking['max'])) {
                $this->addUsingAlias(PenguinsTableMap::COL_WALKING, $walking['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_WALKING, $walking, $comparison);
    }

    /**
     * Filter the query on the Banned column
     *
     * Example usage:
     * <code>
     * $query->filterByBanned('fooValue');   // WHERE Banned = 'fooValue'
     * $query->filterByBanned('%fooValue%'); // WHERE Banned LIKE '%fooValue%'
     * </code>
     *
     * @param     string $banned The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByBanned($banned = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($banned)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $banned)) {
                $banned = str_replace('*', '%', $banned);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_BANNED, $banned, $comparison);
    }

    /**
     * Filter the query on the Stamps column
     *
     * Example usage:
     * <code>
     * $query->filterByStamps('fooValue');   // WHERE Stamps = 'fooValue'
     * $query->filterByStamps('%fooValue%'); // WHERE Stamps LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stamps The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByStamps($stamps = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stamps)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $stamps)) {
                $stamps = str_replace('*', '%', $stamps);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_STAMPS, $stamps, $comparison);
    }

    /**
     * Filter the query on the StampBook column
     *
     * Example usage:
     * <code>
     * $query->filterByStampbook('fooValue');   // WHERE StampBook = 'fooValue'
     * $query->filterByStampbook('%fooValue%'); // WHERE StampBook LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stampbook The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByStampbook($stampbook = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stampbook)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $stampbook)) {
                $stampbook = str_replace('*', '%', $stampbook);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_STAMPBOOK, $stampbook, $comparison);
    }

    /**
     * Filter the query on the EPF column
     *
     * Example usage:
     * <code>
     * $query->filterByEpf('fooValue');   // WHERE EPF = 'fooValue'
     * $query->filterByEpf('%fooValue%'); // WHERE EPF LIKE '%fooValue%'
     * </code>
     *
     * @param     string $epf The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByEpf($epf = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($epf)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $epf)) {
                $epf = str_replace('*', '%', $epf);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_EPF, $epf, $comparison);
    }

    /**
     * Filter the query on the PuffleQuest column
     *
     * Example usage:
     * <code>
     * $query->filterByPufflequest('fooValue');   // WHERE PuffleQuest = 'fooValue'
     * $query->filterByPufflequest('%fooValue%'); // WHERE PuffleQuest LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pufflequest The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function filterByPufflequest($pufflequest = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pufflequest)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pufflequest)) {
                $pufflequest = str_replace('*', '%', $pufflequest);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PenguinsTableMap::COL_PUFFLEQUEST, $pufflequest, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPenguins $penguins Object to remove from the list of results
     *
     * @return $this|ChildPenguinsQuery The current query, for fluid interface
     */
    public function prune($penguins = null)
    {
        if ($penguins) {
            $this->addUsingAlias(PenguinsTableMap::COL_ID, $penguins->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the penguins table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PenguinsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PenguinsTableMap::clearInstancePool();
            PenguinsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PenguinsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PenguinsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PenguinsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PenguinsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PenguinsQuery
