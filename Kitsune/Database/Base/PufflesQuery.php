<?php

namespace Base;

use \Puffles as ChildPuffles;
use \PufflesQuery as ChildPufflesQuery;
use \Exception;
use \PDO;
use Map\PufflesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'puffles' table.
 *
 * 
 *
 * @method     ChildPufflesQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildPufflesQuery orderByOwner($order = Criteria::ASC) Order by the Owner column
 * @method     ChildPufflesQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildPufflesQuery orderByAdoptiondate($order = Criteria::ASC) Order by the AdoptionDate column
 * @method     ChildPufflesQuery orderByType($order = Criteria::ASC) Order by the Type column
 * @method     ChildPufflesQuery orderBySubtype($order = Criteria::ASC) Order by the Subtype column
 * @method     ChildPufflesQuery orderByHat($order = Criteria::ASC) Order by the Hat column
 * @method     ChildPufflesQuery orderByFood($order = Criteria::ASC) Order by the Food column
 * @method     ChildPufflesQuery orderByPlay($order = Criteria::ASC) Order by the Play column
 * @method     ChildPufflesQuery orderByRest($order = Criteria::ASC) Order by the Rest column
 * @method     ChildPufflesQuery orderByClean($order = Criteria::ASC) Order by the Clean column
 * @method     ChildPufflesQuery orderByBackyard($order = Criteria::ASC) Order by the Backyard column
 *
 * @method     ChildPufflesQuery groupById() Group by the ID column
 * @method     ChildPufflesQuery groupByOwner() Group by the Owner column
 * @method     ChildPufflesQuery groupByName() Group by the Name column
 * @method     ChildPufflesQuery groupByAdoptiondate() Group by the AdoptionDate column
 * @method     ChildPufflesQuery groupByType() Group by the Type column
 * @method     ChildPufflesQuery groupBySubtype() Group by the Subtype column
 * @method     ChildPufflesQuery groupByHat() Group by the Hat column
 * @method     ChildPufflesQuery groupByFood() Group by the Food column
 * @method     ChildPufflesQuery groupByPlay() Group by the Play column
 * @method     ChildPufflesQuery groupByRest() Group by the Rest column
 * @method     ChildPufflesQuery groupByClean() Group by the Clean column
 * @method     ChildPufflesQuery groupByBackyard() Group by the Backyard column
 *
 * @method     ChildPufflesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPufflesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPufflesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPufflesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPufflesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPufflesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPuffles findOne(ConnectionInterface $con = null) Return the first ChildPuffles matching the query
 * @method     ChildPuffles findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPuffles matching the query, or a new ChildPuffles object populated from the query conditions when no match is found
 *
 * @method     ChildPuffles findOneById(int $ID) Return the first ChildPuffles filtered by the ID column
 * @method     ChildPuffles findOneByOwner(int $Owner) Return the first ChildPuffles filtered by the Owner column
 * @method     ChildPuffles findOneByName(string $Name) Return the first ChildPuffles filtered by the Name column
 * @method     ChildPuffles findOneByAdoptiondate(int $AdoptionDate) Return the first ChildPuffles filtered by the AdoptionDate column
 * @method     ChildPuffles findOneByType(int $Type) Return the first ChildPuffles filtered by the Type column
 * @method     ChildPuffles findOneBySubtype(int $Subtype) Return the first ChildPuffles filtered by the Subtype column
 * @method     ChildPuffles findOneByHat(int $Hat) Return the first ChildPuffles filtered by the Hat column
 * @method     ChildPuffles findOneByFood(int $Food) Return the first ChildPuffles filtered by the Food column
 * @method     ChildPuffles findOneByPlay(int $Play) Return the first ChildPuffles filtered by the Play column
 * @method     ChildPuffles findOneByRest(int $Rest) Return the first ChildPuffles filtered by the Rest column
 * @method     ChildPuffles findOneByClean(int $Clean) Return the first ChildPuffles filtered by the Clean column
 * @method     ChildPuffles findOneByBackyard(boolean $Backyard) Return the first ChildPuffles filtered by the Backyard column *

 * @method     ChildPuffles requirePk($key, ConnectionInterface $con = null) Return the ChildPuffles by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOne(ConnectionInterface $con = null) Return the first ChildPuffles matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPuffles requireOneById(int $ID) Return the first ChildPuffles filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneByOwner(int $Owner) Return the first ChildPuffles filtered by the Owner column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneByName(string $Name) Return the first ChildPuffles filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneByAdoptiondate(int $AdoptionDate) Return the first ChildPuffles filtered by the AdoptionDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneByType(int $Type) Return the first ChildPuffles filtered by the Type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneBySubtype(int $Subtype) Return the first ChildPuffles filtered by the Subtype column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneByHat(int $Hat) Return the first ChildPuffles filtered by the Hat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneByFood(int $Food) Return the first ChildPuffles filtered by the Food column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneByPlay(int $Play) Return the first ChildPuffles filtered by the Play column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneByRest(int $Rest) Return the first ChildPuffles filtered by the Rest column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneByClean(int $Clean) Return the first ChildPuffles filtered by the Clean column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPuffles requireOneByBackyard(boolean $Backyard) Return the first ChildPuffles filtered by the Backyard column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPuffles[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPuffles objects based on current ModelCriteria
 * @method     ChildPuffles[]|ObjectCollection findById(int $ID) Return ChildPuffles objects filtered by the ID column
 * @method     ChildPuffles[]|ObjectCollection findByOwner(int $Owner) Return ChildPuffles objects filtered by the Owner column
 * @method     ChildPuffles[]|ObjectCollection findByName(string $Name) Return ChildPuffles objects filtered by the Name column
 * @method     ChildPuffles[]|ObjectCollection findByAdoptiondate(int $AdoptionDate) Return ChildPuffles objects filtered by the AdoptionDate column
 * @method     ChildPuffles[]|ObjectCollection findByType(int $Type) Return ChildPuffles objects filtered by the Type column
 * @method     ChildPuffles[]|ObjectCollection findBySubtype(int $Subtype) Return ChildPuffles objects filtered by the Subtype column
 * @method     ChildPuffles[]|ObjectCollection findByHat(int $Hat) Return ChildPuffles objects filtered by the Hat column
 * @method     ChildPuffles[]|ObjectCollection findByFood(int $Food) Return ChildPuffles objects filtered by the Food column
 * @method     ChildPuffles[]|ObjectCollection findByPlay(int $Play) Return ChildPuffles objects filtered by the Play column
 * @method     ChildPuffles[]|ObjectCollection findByRest(int $Rest) Return ChildPuffles objects filtered by the Rest column
 * @method     ChildPuffles[]|ObjectCollection findByClean(int $Clean) Return ChildPuffles objects filtered by the Clean column
 * @method     ChildPuffles[]|ObjectCollection findByBackyard(boolean $Backyard) Return ChildPuffles objects filtered by the Backyard column
 * @method     ChildPuffles[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PufflesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PufflesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Puffles', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPufflesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPufflesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPufflesQuery) {
            return $criteria;
        }
        $query = new ChildPufflesQuery();
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
     * @return ChildPuffles|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PufflesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PufflesTableMap::DATABASE_NAME);
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
     * @return ChildPuffles A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, Owner, Name, AdoptionDate, Type, Subtype, Hat, Food, Play, Rest, Clean, Backyard FROM puffles WHERE ID = :p0';
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
            /** @var ChildPuffles $obj */
            $obj = new ChildPuffles();
            $obj->hydrate($row);
            PufflesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPuffles|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PufflesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PufflesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PufflesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PufflesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByOwner($owner = null, $comparison = null)
    {
        if (is_array($owner)) {
            $useMinMax = false;
            if (isset($owner['min'])) {
                $this->addUsingAlias(PufflesTableMap::COL_OWNER, $owner['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($owner['max'])) {
                $this->addUsingAlias(PufflesTableMap::COL_OWNER, $owner['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_OWNER, $owner, $comparison);
    }

    /**
     * Filter the query on the Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE Name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE Name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the AdoptionDate column
     *
     * Example usage:
     * <code>
     * $query->filterByAdoptiondate(1234); // WHERE AdoptionDate = 1234
     * $query->filterByAdoptiondate(array(12, 34)); // WHERE AdoptionDate IN (12, 34)
     * $query->filterByAdoptiondate(array('min' => 12)); // WHERE AdoptionDate > 12
     * </code>
     *
     * @param     mixed $adoptiondate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByAdoptiondate($adoptiondate = null, $comparison = null)
    {
        if (is_array($adoptiondate)) {
            $useMinMax = false;
            if (isset($adoptiondate['min'])) {
                $this->addUsingAlias(PufflesTableMap::COL_ADOPTIONDATE, $adoptiondate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($adoptiondate['max'])) {
                $this->addUsingAlias(PufflesTableMap::COL_ADOPTIONDATE, $adoptiondate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_ADOPTIONDATE, $adoptiondate, $comparison);
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
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingAlias(PufflesTableMap::COL_TYPE, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingAlias(PufflesTableMap::COL_TYPE, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the Subtype column
     *
     * Example usage:
     * <code>
     * $query->filterBySubtype(1234); // WHERE Subtype = 1234
     * $query->filterBySubtype(array(12, 34)); // WHERE Subtype IN (12, 34)
     * $query->filterBySubtype(array('min' => 12)); // WHERE Subtype > 12
     * </code>
     *
     * @param     mixed $subtype The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterBySubtype($subtype = null, $comparison = null)
    {
        if (is_array($subtype)) {
            $useMinMax = false;
            if (isset($subtype['min'])) {
                $this->addUsingAlias(PufflesTableMap::COL_SUBTYPE, $subtype['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subtype['max'])) {
                $this->addUsingAlias(PufflesTableMap::COL_SUBTYPE, $subtype['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_SUBTYPE, $subtype, $comparison);
    }

    /**
     * Filter the query on the Hat column
     *
     * Example usage:
     * <code>
     * $query->filterByHat(1234); // WHERE Hat = 1234
     * $query->filterByHat(array(12, 34)); // WHERE Hat IN (12, 34)
     * $query->filterByHat(array('min' => 12)); // WHERE Hat > 12
     * </code>
     *
     * @param     mixed $hat The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByHat($hat = null, $comparison = null)
    {
        if (is_array($hat)) {
            $useMinMax = false;
            if (isset($hat['min'])) {
                $this->addUsingAlias(PufflesTableMap::COL_HAT, $hat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hat['max'])) {
                $this->addUsingAlias(PufflesTableMap::COL_HAT, $hat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_HAT, $hat, $comparison);
    }

    /**
     * Filter the query on the Food column
     *
     * Example usage:
     * <code>
     * $query->filterByFood(1234); // WHERE Food = 1234
     * $query->filterByFood(array(12, 34)); // WHERE Food IN (12, 34)
     * $query->filterByFood(array('min' => 12)); // WHERE Food > 12
     * </code>
     *
     * @param     mixed $food The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByFood($food = null, $comparison = null)
    {
        if (is_array($food)) {
            $useMinMax = false;
            if (isset($food['min'])) {
                $this->addUsingAlias(PufflesTableMap::COL_FOOD, $food['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($food['max'])) {
                $this->addUsingAlias(PufflesTableMap::COL_FOOD, $food['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_FOOD, $food, $comparison);
    }

    /**
     * Filter the query on the Play column
     *
     * Example usage:
     * <code>
     * $query->filterByPlay(1234); // WHERE Play = 1234
     * $query->filterByPlay(array(12, 34)); // WHERE Play IN (12, 34)
     * $query->filterByPlay(array('min' => 12)); // WHERE Play > 12
     * </code>
     *
     * @param     mixed $play The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByPlay($play = null, $comparison = null)
    {
        if (is_array($play)) {
            $useMinMax = false;
            if (isset($play['min'])) {
                $this->addUsingAlias(PufflesTableMap::COL_PLAY, $play['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($play['max'])) {
                $this->addUsingAlias(PufflesTableMap::COL_PLAY, $play['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_PLAY, $play, $comparison);
    }

    /**
     * Filter the query on the Rest column
     *
     * Example usage:
     * <code>
     * $query->filterByRest(1234); // WHERE Rest = 1234
     * $query->filterByRest(array(12, 34)); // WHERE Rest IN (12, 34)
     * $query->filterByRest(array('min' => 12)); // WHERE Rest > 12
     * </code>
     *
     * @param     mixed $rest The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByRest($rest = null, $comparison = null)
    {
        if (is_array($rest)) {
            $useMinMax = false;
            if (isset($rest['min'])) {
                $this->addUsingAlias(PufflesTableMap::COL_REST, $rest['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rest['max'])) {
                $this->addUsingAlias(PufflesTableMap::COL_REST, $rest['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_REST, $rest, $comparison);
    }

    /**
     * Filter the query on the Clean column
     *
     * Example usage:
     * <code>
     * $query->filterByClean(1234); // WHERE Clean = 1234
     * $query->filterByClean(array(12, 34)); // WHERE Clean IN (12, 34)
     * $query->filterByClean(array('min' => 12)); // WHERE Clean > 12
     * </code>
     *
     * @param     mixed $clean The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByClean($clean = null, $comparison = null)
    {
        if (is_array($clean)) {
            $useMinMax = false;
            if (isset($clean['min'])) {
                $this->addUsingAlias(PufflesTableMap::COL_CLEAN, $clean['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clean['max'])) {
                $this->addUsingAlias(PufflesTableMap::COL_CLEAN, $clean['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PufflesTableMap::COL_CLEAN, $clean, $comparison);
    }

    /**
     * Filter the query on the Backyard column
     *
     * Example usage:
     * <code>
     * $query->filterByBackyard(true); // WHERE Backyard = true
     * $query->filterByBackyard('yes'); // WHERE Backyard = true
     * </code>
     *
     * @param     boolean|string $backyard The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function filterByBackyard($backyard = null, $comparison = null)
    {
        if (is_string($backyard)) {
            $backyard = in_array(strtolower($backyard), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PufflesTableMap::COL_BACKYARD, $backyard, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPuffles $puffles Object to remove from the list of results
     *
     * @return $this|ChildPufflesQuery The current query, for fluid interface
     */
    public function prune($puffles = null)
    {
        if ($puffles) {
            $this->addUsingAlias(PufflesTableMap::COL_ID, $puffles->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the puffles table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PufflesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PufflesTableMap::clearInstancePool();
            PufflesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PufflesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PufflesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PufflesTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PufflesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PufflesQuery
