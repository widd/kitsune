<?php

namespace Base;

use \Igloos as ChildIgloos;
use \IgloosQuery as ChildIgloosQuery;
use \Exception;
use \PDO;
use Map\IgloosTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'igloos' table.
 *
 * 
 *
 * @method     ChildIgloosQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildIgloosQuery orderByOwner($order = Criteria::ASC) Order by the Owner column
 * @method     ChildIgloosQuery orderByType($order = Criteria::ASC) Order by the Type column
 * @method     ChildIgloosQuery orderByFloor($order = Criteria::ASC) Order by the Floor column
 * @method     ChildIgloosQuery orderByMusic($order = Criteria::ASC) Order by the Music column
 * @method     ChildIgloosQuery orderByFurniture($order = Criteria::ASC) Order by the Furniture column
 * @method     ChildIgloosQuery orderByLocation($order = Criteria::ASC) Order by the Location column
 * @method     ChildIgloosQuery orderByLikes($order = Criteria::ASC) Order by the Likes column
 * @method     ChildIgloosQuery orderByLocked($order = Criteria::ASC) Order by the Locked column
 *
 * @method     ChildIgloosQuery groupById() Group by the ID column
 * @method     ChildIgloosQuery groupByOwner() Group by the Owner column
 * @method     ChildIgloosQuery groupByType() Group by the Type column
 * @method     ChildIgloosQuery groupByFloor() Group by the Floor column
 * @method     ChildIgloosQuery groupByMusic() Group by the Music column
 * @method     ChildIgloosQuery groupByFurniture() Group by the Furniture column
 * @method     ChildIgloosQuery groupByLocation() Group by the Location column
 * @method     ChildIgloosQuery groupByLikes() Group by the Likes column
 * @method     ChildIgloosQuery groupByLocked() Group by the Locked column
 *
 * @method     ChildIgloosQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildIgloosQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildIgloosQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildIgloosQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildIgloosQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildIgloosQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildIgloos findOne(ConnectionInterface $con = null) Return the first ChildIgloos matching the query
 * @method     ChildIgloos findOneOrCreate(ConnectionInterface $con = null) Return the first ChildIgloos matching the query, or a new ChildIgloos object populated from the query conditions when no match is found
 *
 * @method     ChildIgloos findOneById(int $ID) Return the first ChildIgloos filtered by the ID column
 * @method     ChildIgloos findOneByOwner(int $Owner) Return the first ChildIgloos filtered by the Owner column
 * @method     ChildIgloos findOneByType(int $Type) Return the first ChildIgloos filtered by the Type column
 * @method     ChildIgloos findOneByFloor(int $Floor) Return the first ChildIgloos filtered by the Floor column
 * @method     ChildIgloos findOneByMusic(int $Music) Return the first ChildIgloos filtered by the Music column
 * @method     ChildIgloos findOneByFurniture(string $Furniture) Return the first ChildIgloos filtered by the Furniture column
 * @method     ChildIgloos findOneByLocation(int $Location) Return the first ChildIgloos filtered by the Location column
 * @method     ChildIgloos findOneByLikes(string $Likes) Return the first ChildIgloos filtered by the Likes column
 * @method     ChildIgloos findOneByLocked(boolean $Locked) Return the first ChildIgloos filtered by the Locked column *

 * @method     ChildIgloos requirePk($key, ConnectionInterface $con = null) Return the ChildIgloos by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIgloos requireOne(ConnectionInterface $con = null) Return the first ChildIgloos matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIgloos requireOneById(int $ID) Return the first ChildIgloos filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIgloos requireOneByOwner(int $Owner) Return the first ChildIgloos filtered by the Owner column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIgloos requireOneByType(int $Type) Return the first ChildIgloos filtered by the Type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIgloos requireOneByFloor(int $Floor) Return the first ChildIgloos filtered by the Floor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIgloos requireOneByMusic(int $Music) Return the first ChildIgloos filtered by the Music column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIgloos requireOneByFurniture(string $Furniture) Return the first ChildIgloos filtered by the Furniture column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIgloos requireOneByLocation(int $Location) Return the first ChildIgloos filtered by the Location column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIgloos requireOneByLikes(string $Likes) Return the first ChildIgloos filtered by the Likes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIgloos requireOneByLocked(boolean $Locked) Return the first ChildIgloos filtered by the Locked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIgloos[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildIgloos objects based on current ModelCriteria
 * @method     ChildIgloos[]|ObjectCollection findById(int $ID) Return ChildIgloos objects filtered by the ID column
 * @method     ChildIgloos[]|ObjectCollection findByOwner(int $Owner) Return ChildIgloos objects filtered by the Owner column
 * @method     ChildIgloos[]|ObjectCollection findByType(int $Type) Return ChildIgloos objects filtered by the Type column
 * @method     ChildIgloos[]|ObjectCollection findByFloor(int $Floor) Return ChildIgloos objects filtered by the Floor column
 * @method     ChildIgloos[]|ObjectCollection findByMusic(int $Music) Return ChildIgloos objects filtered by the Music column
 * @method     ChildIgloos[]|ObjectCollection findByFurniture(string $Furniture) Return ChildIgloos objects filtered by the Furniture column
 * @method     ChildIgloos[]|ObjectCollection findByLocation(int $Location) Return ChildIgloos objects filtered by the Location column
 * @method     ChildIgloos[]|ObjectCollection findByLikes(string $Likes) Return ChildIgloos objects filtered by the Likes column
 * @method     ChildIgloos[]|ObjectCollection findByLocked(boolean $Locked) Return ChildIgloos objects filtered by the Locked column
 * @method     ChildIgloos[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class IgloosQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\IgloosQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Igloos', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildIgloosQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildIgloosQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildIgloosQuery) {
            return $criteria;
        }
        $query = new ChildIgloosQuery();
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
     * @return ChildIgloos|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = IgloosTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(IgloosTableMap::DATABASE_NAME);
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
     * @return ChildIgloos A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, Owner, Type, Floor, Music, Furniture, Location, Likes, Locked FROM igloos WHERE ID = :p0';
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
            /** @var ChildIgloos $obj */
            $obj = new ChildIgloos();
            $obj->hydrate($row);
            IgloosTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildIgloos|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(IgloosTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(IgloosTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(IgloosTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(IgloosTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IgloosTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the Owner column
     *
     * Example usage:
     * <code>
     * $query->filterByOwner(1234); // WHERE Owner = 1234
     * $query->filterByOwner(array(12, 34)); // WHERE Owner IN (12, 34)
     * $query->filterByOwner(array('min' => 12)); // WHERE Owner > 12
     * </code>
     *
     * @param     mixed $owner The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function filterByOwner($owner = null, $comparison = null)
    {
        if (is_array($owner)) {
            $useMinMax = false;
            if (isset($owner['min'])) {
                $this->addUsingAlias(IgloosTableMap::COL_OWNER, $owner['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($owner['max'])) {
                $this->addUsingAlias(IgloosTableMap::COL_OWNER, $owner['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IgloosTableMap::COL_OWNER, $owner, $comparison);
    }

    /**
     * Filter the query on the Type column
     *
     * Example usage:
     * <code>
     * $query->filterByType(1234); // WHERE Type = 1234
     * $query->filterByType(array(12, 34)); // WHERE Type IN (12, 34)
     * $query->filterByType(array('min' => 12)); // WHERE Type > 12
     * </code>
     *
     * @param     mixed $type The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingAlias(IgloosTableMap::COL_TYPE, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingAlias(IgloosTableMap::COL_TYPE, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IgloosTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the Floor column
     *
     * Example usage:
     * <code>
     * $query->filterByFloor(1234); // WHERE Floor = 1234
     * $query->filterByFloor(array(12, 34)); // WHERE Floor IN (12, 34)
     * $query->filterByFloor(array('min' => 12)); // WHERE Floor > 12
     * </code>
     *
     * @param     mixed $floor The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function filterByFloor($floor = null, $comparison = null)
    {
        if (is_array($floor)) {
            $useMinMax = false;
            if (isset($floor['min'])) {
                $this->addUsingAlias(IgloosTableMap::COL_FLOOR, $floor['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($floor['max'])) {
                $this->addUsingAlias(IgloosTableMap::COL_FLOOR, $floor['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IgloosTableMap::COL_FLOOR, $floor, $comparison);
    }

    /**
     * Filter the query on the Music column
     *
     * Example usage:
     * <code>
     * $query->filterByMusic(1234); // WHERE Music = 1234
     * $query->filterByMusic(array(12, 34)); // WHERE Music IN (12, 34)
     * $query->filterByMusic(array('min' => 12)); // WHERE Music > 12
     * </code>
     *
     * @param     mixed $music The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function filterByMusic($music = null, $comparison = null)
    {
        if (is_array($music)) {
            $useMinMax = false;
            if (isset($music['min'])) {
                $this->addUsingAlias(IgloosTableMap::COL_MUSIC, $music['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($music['max'])) {
                $this->addUsingAlias(IgloosTableMap::COL_MUSIC, $music['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IgloosTableMap::COL_MUSIC, $music, $comparison);
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
     * @return $this|ChildIgloosQuery The current query, for fluid interface
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

        return $this->addUsingAlias(IgloosTableMap::COL_FURNITURE, $furniture, $comparison);
    }

    /**
     * Filter the query on the Location column
     *
     * Example usage:
     * <code>
     * $query->filterByLocation(1234); // WHERE Location = 1234
     * $query->filterByLocation(array(12, 34)); // WHERE Location IN (12, 34)
     * $query->filterByLocation(array('min' => 12)); // WHERE Location > 12
     * </code>
     *
     * @param     mixed $location The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function filterByLocation($location = null, $comparison = null)
    {
        if (is_array($location)) {
            $useMinMax = false;
            if (isset($location['min'])) {
                $this->addUsingAlias(IgloosTableMap::COL_LOCATION, $location['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($location['max'])) {
                $this->addUsingAlias(IgloosTableMap::COL_LOCATION, $location['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IgloosTableMap::COL_LOCATION, $location, $comparison);
    }

    /**
     * Filter the query on the Likes column
     *
     * Example usage:
     * <code>
     * $query->filterByLikes('fooValue');   // WHERE Likes = 'fooValue'
     * $query->filterByLikes('%fooValue%'); // WHERE Likes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $likes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function filterByLikes($likes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($likes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $likes)) {
                $likes = str_replace('*', '%', $likes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IgloosTableMap::COL_LIKES, $likes, $comparison);
    }

    /**
     * Filter the query on the Locked column
     *
     * Example usage:
     * <code>
     * $query->filterByLocked(true); // WHERE Locked = true
     * $query->filterByLocked('yes'); // WHERE Locked = true
     * </code>
     *
     * @param     boolean|string $locked The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function filterByLocked($locked = null, $comparison = null)
    {
        if (is_string($locked)) {
            $locked = in_array(strtolower($locked), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(IgloosTableMap::COL_LOCKED, $locked, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildIgloos $igloos Object to remove from the list of results
     *
     * @return $this|ChildIgloosQuery The current query, for fluid interface
     */
    public function prune($igloos = null)
    {
        if ($igloos) {
            $this->addUsingAlias(IgloosTableMap::COL_ID, $igloos->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the igloos table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IgloosTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            IgloosTableMap::clearInstancePool();
            IgloosTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(IgloosTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(IgloosTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            IgloosTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            IgloosTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // IgloosQuery
