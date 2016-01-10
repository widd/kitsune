<?php

namespace Kitsune\Database\Base;

use \Exception;
use \PDO;
use Kitsune\Database\Tracks as ChildTracks;
use Kitsune\Database\TracksQuery as ChildTracksQuery;
use Kitsune\Database\Map\TracksTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'tracks' table.
 *
 * 
 *
 * @method     ChildTracksQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildTracksQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildTracksQuery orderByOwner($order = Criteria::ASC) Order by the Owner column
 * @method     ChildTracksQuery orderByHash($order = Criteria::ASC) Order by the Hash column
 * @method     ChildTracksQuery orderBySharing($order = Criteria::ASC) Order by the Sharing column
 * @method     ChildTracksQuery orderByPattern($order = Criteria::ASC) Order by the Pattern column
 * @method     ChildTracksQuery orderByLikes($order = Criteria::ASC) Order by the Likes column
 * @method     ChildTracksQuery orderByLikestatistics($order = Criteria::ASC) Order by the LikeStatistics column
 *
 * @method     ChildTracksQuery groupById() Group by the ID column
 * @method     ChildTracksQuery groupByName() Group by the Name column
 * @method     ChildTracksQuery groupByOwner() Group by the Owner column
 * @method     ChildTracksQuery groupByHash() Group by the Hash column
 * @method     ChildTracksQuery groupBySharing() Group by the Sharing column
 * @method     ChildTracksQuery groupByPattern() Group by the Pattern column
 * @method     ChildTracksQuery groupByLikes() Group by the Likes column
 * @method     ChildTracksQuery groupByLikestatistics() Group by the LikeStatistics column
 *
 * @method     ChildTracksQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTracksQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTracksQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTracksQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTracksQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTracksQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTracks findOne(ConnectionInterface $con = null) Return the first ChildTracks matching the query
 * @method     ChildTracks findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTracks matching the query, or a new ChildTracks object populated from the query conditions when no match is found
 *
 * @method     ChildTracks findOneById(int $ID) Return the first ChildTracks filtered by the ID column
 * @method     ChildTracks findOneByName(string $Name) Return the first ChildTracks filtered by the Name column
 * @method     ChildTracks findOneByOwner(int $Owner) Return the first ChildTracks filtered by the Owner column
 * @method     ChildTracks findOneByHash(string $Hash) Return the first ChildTracks filtered by the Hash column
 * @method     ChildTracks findOneBySharing(boolean $Sharing) Return the first ChildTracks filtered by the Sharing column
 * @method     ChildTracks findOneByPattern(string $Pattern) Return the first ChildTracks filtered by the Pattern column
 * @method     ChildTracks findOneByLikes(int $Likes) Return the first ChildTracks filtered by the Likes column
 * @method     ChildTracks findOneByLikestatistics(string $LikeStatistics) Return the first ChildTracks filtered by the LikeStatistics column *

 * @method     ChildTracks requirePk($key, ConnectionInterface $con = null) Return the ChildTracks by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTracks requireOne(ConnectionInterface $con = null) Return the first ChildTracks matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTracks requireOneById(int $ID) Return the first ChildTracks filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTracks requireOneByName(string $Name) Return the first ChildTracks filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTracks requireOneByOwner(int $Owner) Return the first ChildTracks filtered by the Owner column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTracks requireOneByHash(string $Hash) Return the first ChildTracks filtered by the Hash column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTracks requireOneBySharing(boolean $Sharing) Return the first ChildTracks filtered by the Sharing column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTracks requireOneByPattern(string $Pattern) Return the first ChildTracks filtered by the Pattern column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTracks requireOneByLikes(int $Likes) Return the first ChildTracks filtered by the Likes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTracks requireOneByLikestatistics(string $LikeStatistics) Return the first ChildTracks filtered by the LikeStatistics column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTracks[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTracks objects based on current ModelCriteria
 * @method     ChildTracks[]|ObjectCollection findById(int $ID) Return ChildTracks objects filtered by the ID column
 * @method     ChildTracks[]|ObjectCollection findByName(string $Name) Return ChildTracks objects filtered by the Name column
 * @method     ChildTracks[]|ObjectCollection findByOwner(int $Owner) Return ChildTracks objects filtered by the Owner column
 * @method     ChildTracks[]|ObjectCollection findByHash(string $Hash) Return ChildTracks objects filtered by the Hash column
 * @method     ChildTracks[]|ObjectCollection findBySharing(boolean $Sharing) Return ChildTracks objects filtered by the Sharing column
 * @method     ChildTracks[]|ObjectCollection findByPattern(string $Pattern) Return ChildTracks objects filtered by the Pattern column
 * @method     ChildTracks[]|ObjectCollection findByLikes(int $Likes) Return ChildTracks objects filtered by the Likes column
 * @method     ChildTracks[]|ObjectCollection findByLikestatistics(string $LikeStatistics) Return ChildTracks objects filtered by the LikeStatistics column
 * @method     ChildTracks[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TracksQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Kitsune\Database\Base\TracksQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Kitsune\\Database\\Tracks', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTracksQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTracksQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTracksQuery) {
            return $criteria;
        }
        $query = new ChildTracksQuery();
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
     * @return ChildTracks|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TracksTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TracksTableMap::DATABASE_NAME);
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
     * @return ChildTracks A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, Name, Owner, Hash, Sharing, Pattern, Likes, LikeStatistics FROM tracks WHERE ID = :p0';
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
            /** @var ChildTracks $obj */
            $obj = new ChildTracks();
            $obj->hydrate($row);
            TracksTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTracks|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTracksQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TracksTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTracksQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TracksTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTracksQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TracksTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TracksTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TracksTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildTracksQuery The current query, for fluid interface
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

        return $this->addUsingAlias(TracksTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildTracksQuery The current query, for fluid interface
     */
    public function filterByOwner($owner = null, $comparison = null)
    {
        if (is_array($owner)) {
            $useMinMax = false;
            if (isset($owner['min'])) {
                $this->addUsingAlias(TracksTableMap::COL_OWNER, $owner['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($owner['max'])) {
                $this->addUsingAlias(TracksTableMap::COL_OWNER, $owner['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TracksTableMap::COL_OWNER, $owner, $comparison);
    }

    /**
     * Filter the query on the Hash column
     *
     * Example usage:
     * <code>
     * $query->filterByHash('fooValue');   // WHERE Hash = 'fooValue'
     * $query->filterByHash('%fooValue%'); // WHERE Hash LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hash The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTracksQuery The current query, for fluid interface
     */
    public function filterByHash($hash = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hash)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $hash)) {
                $hash = str_replace('*', '%', $hash);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TracksTableMap::COL_HASH, $hash, $comparison);
    }

    /**
     * Filter the query on the Sharing column
     *
     * Example usage:
     * <code>
     * $query->filterBySharing(true); // WHERE Sharing = true
     * $query->filterBySharing('yes'); // WHERE Sharing = true
     * </code>
     *
     * @param     boolean|string $sharing The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTracksQuery The current query, for fluid interface
     */
    public function filterBySharing($sharing = null, $comparison = null)
    {
        if (is_string($sharing)) {
            $sharing = in_array(strtolower($sharing), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(TracksTableMap::COL_SHARING, $sharing, $comparison);
    }

    /**
     * Filter the query on the Pattern column
     *
     * Example usage:
     * <code>
     * $query->filterByPattern('fooValue');   // WHERE Pattern = 'fooValue'
     * $query->filterByPattern('%fooValue%'); // WHERE Pattern LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pattern The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTracksQuery The current query, for fluid interface
     */
    public function filterByPattern($pattern = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pattern)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pattern)) {
                $pattern = str_replace('*', '%', $pattern);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TracksTableMap::COL_PATTERN, $pattern, $comparison);
    }

    /**
     * Filter the query on the Likes column
     *
     * Example usage:
     * <code>
     * $query->filterByLikes(1234); // WHERE Likes = 1234
     * $query->filterByLikes(array(12, 34)); // WHERE Likes IN (12, 34)
     * $query->filterByLikes(array('min' => 12)); // WHERE Likes > 12
     * </code>
     *
     * @param     mixed $likes The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTracksQuery The current query, for fluid interface
     */
    public function filterByLikes($likes = null, $comparison = null)
    {
        if (is_array($likes)) {
            $useMinMax = false;
            if (isset($likes['min'])) {
                $this->addUsingAlias(TracksTableMap::COL_LIKES, $likes['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($likes['max'])) {
                $this->addUsingAlias(TracksTableMap::COL_LIKES, $likes['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TracksTableMap::COL_LIKES, $likes, $comparison);
    }

    /**
     * Filter the query on the LikeStatistics column
     *
     * Example usage:
     * <code>
     * $query->filterByLikestatistics('fooValue');   // WHERE LikeStatistics = 'fooValue'
     * $query->filterByLikestatistics('%fooValue%'); // WHERE LikeStatistics LIKE '%fooValue%'
     * </code>
     *
     * @param     string $likestatistics The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTracksQuery The current query, for fluid interface
     */
    public function filterByLikestatistics($likestatistics = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($likestatistics)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $likestatistics)) {
                $likestatistics = str_replace('*', '%', $likestatistics);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TracksTableMap::COL_LIKESTATISTICS, $likestatistics, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTracks $tracks Object to remove from the list of results
     *
     * @return $this|ChildTracksQuery The current query, for fluid interface
     */
    public function prune($tracks = null)
    {
        if ($tracks) {
            $this->addUsingAlias(TracksTableMap::COL_ID, $tracks->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the tracks table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TracksTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TracksTableMap::clearInstancePool();
            TracksTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TracksTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TracksTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            TracksTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            TracksTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TracksQuery
