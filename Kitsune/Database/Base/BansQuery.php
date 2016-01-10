<?php

namespace Kitsune\Database\Base;

use \Exception;
use \PDO;
use Kitsune\Database\Bans as ChildBans;
use Kitsune\Database\BansQuery as ChildBansQuery;
use Kitsune\Database\Map\BansTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'bans' table.
 *
 * 
 *
 * @method     ChildBansQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildBansQuery orderByModerator($order = Criteria::ASC) Order by the Moderator column
 * @method     ChildBansQuery orderByPlayer($order = Criteria::ASC) Order by the Player column
 * @method     ChildBansQuery orderByComment($order = Criteria::ASC) Order by the Comment column
 * @method     ChildBansQuery orderByExpiration($order = Criteria::ASC) Order by the Expiration column
 * @method     ChildBansQuery orderByTime($order = Criteria::ASC) Order by the Time column
 * @method     ChildBansQuery orderByType($order = Criteria::ASC) Order by the Type column
 *
 * @method     ChildBansQuery groupById() Group by the ID column
 * @method     ChildBansQuery groupByModerator() Group by the Moderator column
 * @method     ChildBansQuery groupByPlayer() Group by the Player column
 * @method     ChildBansQuery groupByComment() Group by the Comment column
 * @method     ChildBansQuery groupByExpiration() Group by the Expiration column
 * @method     ChildBansQuery groupByTime() Group by the Time column
 * @method     ChildBansQuery groupByType() Group by the Type column
 *
 * @method     ChildBansQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBansQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBansQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBansQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBansQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBansQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBans findOne(ConnectionInterface $con = null) Return the first ChildBans matching the query
 * @method     ChildBans findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBans matching the query, or a new ChildBans object populated from the query conditions when no match is found
 *
 * @method     ChildBans findOneById(int $ID) Return the first ChildBans filtered by the ID column
 * @method     ChildBans findOneByModerator(string $Moderator) Return the first ChildBans filtered by the Moderator column
 * @method     ChildBans findOneByPlayer(int $Player) Return the first ChildBans filtered by the Player column
 * @method     ChildBans findOneByComment(string $Comment) Return the first ChildBans filtered by the Comment column
 * @method     ChildBans findOneByExpiration(int $Expiration) Return the first ChildBans filtered by the Expiration column
 * @method     ChildBans findOneByTime(int $Time) Return the first ChildBans filtered by the Time column
 * @method     ChildBans findOneByType(int $Type) Return the first ChildBans filtered by the Type column *

 * @method     ChildBans requirePk($key, ConnectionInterface $con = null) Return the ChildBans by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBans requireOne(ConnectionInterface $con = null) Return the first ChildBans matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBans requireOneById(int $ID) Return the first ChildBans filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBans requireOneByModerator(string $Moderator) Return the first ChildBans filtered by the Moderator column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBans requireOneByPlayer(int $Player) Return the first ChildBans filtered by the Player column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBans requireOneByComment(string $Comment) Return the first ChildBans filtered by the Comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBans requireOneByExpiration(int $Expiration) Return the first ChildBans filtered by the Expiration column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBans requireOneByTime(int $Time) Return the first ChildBans filtered by the Time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBans requireOneByType(int $Type) Return the first ChildBans filtered by the Type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBans[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBans objects based on current ModelCriteria
 * @method     ChildBans[]|ObjectCollection findById(int $ID) Return ChildBans objects filtered by the ID column
 * @method     ChildBans[]|ObjectCollection findByModerator(string $Moderator) Return ChildBans objects filtered by the Moderator column
 * @method     ChildBans[]|ObjectCollection findByPlayer(int $Player) Return ChildBans objects filtered by the Player column
 * @method     ChildBans[]|ObjectCollection findByComment(string $Comment) Return ChildBans objects filtered by the Comment column
 * @method     ChildBans[]|ObjectCollection findByExpiration(int $Expiration) Return ChildBans objects filtered by the Expiration column
 * @method     ChildBans[]|ObjectCollection findByTime(int $Time) Return ChildBans objects filtered by the Time column
 * @method     ChildBans[]|ObjectCollection findByType(int $Type) Return ChildBans objects filtered by the Type column
 * @method     ChildBans[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BansQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Kitsune\Database\Base\BansQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Kitsune\\Database\\Bans', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBansQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBansQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBansQuery) {
            return $criteria;
        }
        $query = new ChildBansQuery();
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
     * @return ChildBans|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BansTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BansTableMap::DATABASE_NAME);
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
     * @return ChildBans A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, Moderator, Player, Comment, Expiration, Time, Type FROM bans WHERE ID = :p0';
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
            /** @var ChildBans $obj */
            $obj = new ChildBans();
            $obj->hydrate($row);
            BansTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBans|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBansQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BansTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBansQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BansTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBansQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BansTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BansTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BansTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the Moderator column
     *
     * Example usage:
     * <code>
     * $query->filterByModerator('fooValue');   // WHERE Moderator = 'fooValue'
     * $query->filterByModerator('%fooValue%'); // WHERE Moderator LIKE '%fooValue%'
     * </code>
     *
     * @param     string $moderator The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBansQuery The current query, for fluid interface
     */
    public function filterByModerator($moderator = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($moderator)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $moderator)) {
                $moderator = str_replace('*', '%', $moderator);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BansTableMap::COL_MODERATOR, $moderator, $comparison);
    }

    /**
     * Filter the query on the Player column
     *
     * Example usage:
     * <code>
     * $query->filterByPlayer(1234); // WHERE Player = 1234
     * $query->filterByPlayer(array(12, 34)); // WHERE Player IN (12, 34)
     * $query->filterByPlayer(array('min' => 12)); // WHERE Player > 12
     * </code>
     *
     * @param     mixed $player The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBansQuery The current query, for fluid interface
     */
    public function filterByPlayer($player = null, $comparison = null)
    {
        if (is_array($player)) {
            $useMinMax = false;
            if (isset($player['min'])) {
                $this->addUsingAlias(BansTableMap::COL_PLAYER, $player['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($player['max'])) {
                $this->addUsingAlias(BansTableMap::COL_PLAYER, $player['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BansTableMap::COL_PLAYER, $player, $comparison);
    }

    /**
     * Filter the query on the Comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE Comment = 'fooValue'
     * $query->filterByComment('%fooValue%'); // WHERE Comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBansQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $comment)) {
                $comment = str_replace('*', '%', $comment);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BansTableMap::COL_COMMENT, $comment, $comparison);
    }

    /**
     * Filter the query on the Expiration column
     *
     * Example usage:
     * <code>
     * $query->filterByExpiration(1234); // WHERE Expiration = 1234
     * $query->filterByExpiration(array(12, 34)); // WHERE Expiration IN (12, 34)
     * $query->filterByExpiration(array('min' => 12)); // WHERE Expiration > 12
     * </code>
     *
     * @param     mixed $expiration The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBansQuery The current query, for fluid interface
     */
    public function filterByExpiration($expiration = null, $comparison = null)
    {
        if (is_array($expiration)) {
            $useMinMax = false;
            if (isset($expiration['min'])) {
                $this->addUsingAlias(BansTableMap::COL_EXPIRATION, $expiration['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expiration['max'])) {
                $this->addUsingAlias(BansTableMap::COL_EXPIRATION, $expiration['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BansTableMap::COL_EXPIRATION, $expiration, $comparison);
    }

    /**
     * Filter the query on the Time column
     *
     * Example usage:
     * <code>
     * $query->filterByTime(1234); // WHERE Time = 1234
     * $query->filterByTime(array(12, 34)); // WHERE Time IN (12, 34)
     * $query->filterByTime(array('min' => 12)); // WHERE Time > 12
     * </code>
     *
     * @param     mixed $time The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBansQuery The current query, for fluid interface
     */
    public function filterByTime($time = null, $comparison = null)
    {
        if (is_array($time)) {
            $useMinMax = false;
            if (isset($time['min'])) {
                $this->addUsingAlias(BansTableMap::COL_TIME, $time['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($time['max'])) {
                $this->addUsingAlias(BansTableMap::COL_TIME, $time['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BansTableMap::COL_TIME, $time, $comparison);
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
     * @return $this|ChildBansQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingAlias(BansTableMap::COL_TYPE, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingAlias(BansTableMap::COL_TYPE, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BansTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBans $bans Object to remove from the list of results
     *
     * @return $this|ChildBansQuery The current query, for fluid interface
     */
    public function prune($bans = null)
    {
        if ($bans) {
            $this->addUsingAlias(BansTableMap::COL_ID, $bans->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the bans table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BansTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BansTableMap::clearInstancePool();
            BansTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BansTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BansTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            BansTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            BansTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BansQuery
