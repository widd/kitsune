<?php

namespace Base;

use \Postcards as ChildPostcards;
use \PostcardsQuery as ChildPostcardsQuery;
use \Exception;
use \PDO;
use Map\PostcardsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'postcards' table.
 *
 * 
 *
 * @method     ChildPostcardsQuery orderById($order = Criteria::ASC) Order by the ID column
 * @method     ChildPostcardsQuery orderByRecipient($order = Criteria::ASC) Order by the Recipient column
 * @method     ChildPostcardsQuery orderBySendername($order = Criteria::ASC) Order by the SenderName column
 * @method     ChildPostcardsQuery orderBySenderid($order = Criteria::ASC) Order by the SenderID column
 * @method     ChildPostcardsQuery orderByDetails($order = Criteria::ASC) Order by the Details column
 * @method     ChildPostcardsQuery orderByDate($order = Criteria::ASC) Order by the Date column
 * @method     ChildPostcardsQuery orderByType($order = Criteria::ASC) Order by the Type column
 * @method     ChildPostcardsQuery orderByHasread($order = Criteria::ASC) Order by the HasRead column
 *
 * @method     ChildPostcardsQuery groupById() Group by the ID column
 * @method     ChildPostcardsQuery groupByRecipient() Group by the Recipient column
 * @method     ChildPostcardsQuery groupBySendername() Group by the SenderName column
 * @method     ChildPostcardsQuery groupBySenderid() Group by the SenderID column
 * @method     ChildPostcardsQuery groupByDetails() Group by the Details column
 * @method     ChildPostcardsQuery groupByDate() Group by the Date column
 * @method     ChildPostcardsQuery groupByType() Group by the Type column
 * @method     ChildPostcardsQuery groupByHasread() Group by the HasRead column
 *
 * @method     ChildPostcardsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPostcardsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPostcardsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPostcardsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPostcardsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPostcardsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPostcards findOne(ConnectionInterface $con = null) Return the first ChildPostcards matching the query
 * @method     ChildPostcards findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPostcards matching the query, or a new ChildPostcards object populated from the query conditions when no match is found
 *
 * @method     ChildPostcards findOneById(int $ID) Return the first ChildPostcards filtered by the ID column
 * @method     ChildPostcards findOneByRecipient(int $Recipient) Return the first ChildPostcards filtered by the Recipient column
 * @method     ChildPostcards findOneBySendername(string $SenderName) Return the first ChildPostcards filtered by the SenderName column
 * @method     ChildPostcards findOneBySenderid(int $SenderID) Return the first ChildPostcards filtered by the SenderID column
 * @method     ChildPostcards findOneByDetails(string $Details) Return the first ChildPostcards filtered by the Details column
 * @method     ChildPostcards findOneByDate(int $Date) Return the first ChildPostcards filtered by the Date column
 * @method     ChildPostcards findOneByType(int $Type) Return the first ChildPostcards filtered by the Type column
 * @method     ChildPostcards findOneByHasread(boolean $HasRead) Return the first ChildPostcards filtered by the HasRead column *

 * @method     ChildPostcards requirePk($key, ConnectionInterface $con = null) Return the ChildPostcards by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostcards requireOne(ConnectionInterface $con = null) Return the first ChildPostcards matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPostcards requireOneById(int $ID) Return the first ChildPostcards filtered by the ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostcards requireOneByRecipient(int $Recipient) Return the first ChildPostcards filtered by the Recipient column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostcards requireOneBySendername(string $SenderName) Return the first ChildPostcards filtered by the SenderName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostcards requireOneBySenderid(int $SenderID) Return the first ChildPostcards filtered by the SenderID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostcards requireOneByDetails(string $Details) Return the first ChildPostcards filtered by the Details column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostcards requireOneByDate(int $Date) Return the first ChildPostcards filtered by the Date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostcards requireOneByType(int $Type) Return the first ChildPostcards filtered by the Type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostcards requireOneByHasread(boolean $HasRead) Return the first ChildPostcards filtered by the HasRead column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPostcards[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPostcards objects based on current ModelCriteria
 * @method     ChildPostcards[]|ObjectCollection findById(int $ID) Return ChildPostcards objects filtered by the ID column
 * @method     ChildPostcards[]|ObjectCollection findByRecipient(int $Recipient) Return ChildPostcards objects filtered by the Recipient column
 * @method     ChildPostcards[]|ObjectCollection findBySendername(string $SenderName) Return ChildPostcards objects filtered by the SenderName column
 * @method     ChildPostcards[]|ObjectCollection findBySenderid(int $SenderID) Return ChildPostcards objects filtered by the SenderID column
 * @method     ChildPostcards[]|ObjectCollection findByDetails(string $Details) Return ChildPostcards objects filtered by the Details column
 * @method     ChildPostcards[]|ObjectCollection findByDate(int $Date) Return ChildPostcards objects filtered by the Date column
 * @method     ChildPostcards[]|ObjectCollection findByType(int $Type) Return ChildPostcards objects filtered by the Type column
 * @method     ChildPostcards[]|ObjectCollection findByHasread(boolean $HasRead) Return ChildPostcards objects filtered by the HasRead column
 * @method     ChildPostcards[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PostcardsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PostcardsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Postcards', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPostcardsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPostcardsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPostcardsQuery) {
            return $criteria;
        }
        $query = new ChildPostcardsQuery();
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
     * @return ChildPostcards|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PostcardsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PostcardsTableMap::DATABASE_NAME);
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
     * @return ChildPostcards A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, Recipient, SenderName, SenderID, Details, Date, Type, HasRead FROM postcards WHERE ID = :p0';
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
            /** @var ChildPostcards $obj */
            $obj = new ChildPostcards();
            $obj->hydrate($row);
            PostcardsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPostcards|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PostcardsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PostcardsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PostcardsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PostcardsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostcardsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the Recipient column
     *
     * Example usage:
     * <code>
     * $query->filterByRecipient(1234); // WHERE Recipient = 1234
     * $query->filterByRecipient(array(12, 34)); // WHERE Recipient IN (12, 34)
     * $query->filterByRecipient(array('min' => 12)); // WHERE Recipient > 12
     * </code>
     *
     * @param     mixed $recipient The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function filterByRecipient($recipient = null, $comparison = null)
    {
        if (is_array($recipient)) {
            $useMinMax = false;
            if (isset($recipient['min'])) {
                $this->addUsingAlias(PostcardsTableMap::COL_RECIPIENT, $recipient['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recipient['max'])) {
                $this->addUsingAlias(PostcardsTableMap::COL_RECIPIENT, $recipient['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostcardsTableMap::COL_RECIPIENT, $recipient, $comparison);
    }

    /**
     * Filter the query on the SenderName column
     *
     * Example usage:
     * <code>
     * $query->filterBySendername('fooValue');   // WHERE SenderName = 'fooValue'
     * $query->filterBySendername('%fooValue%'); // WHERE SenderName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sendername The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function filterBySendername($sendername = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sendername)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sendername)) {
                $sendername = str_replace('*', '%', $sendername);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PostcardsTableMap::COL_SENDERNAME, $sendername, $comparison);
    }

    /**
     * Filter the query on the SenderID column
     *
     * Example usage:
     * <code>
     * $query->filterBySenderid(1234); // WHERE SenderID = 1234
     * $query->filterBySenderid(array(12, 34)); // WHERE SenderID IN (12, 34)
     * $query->filterBySenderid(array('min' => 12)); // WHERE SenderID > 12
     * </code>
     *
     * @param     mixed $senderid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function filterBySenderid($senderid = null, $comparison = null)
    {
        if (is_array($senderid)) {
            $useMinMax = false;
            if (isset($senderid['min'])) {
                $this->addUsingAlias(PostcardsTableMap::COL_SENDERID, $senderid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($senderid['max'])) {
                $this->addUsingAlias(PostcardsTableMap::COL_SENDERID, $senderid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostcardsTableMap::COL_SENDERID, $senderid, $comparison);
    }

    /**
     * Filter the query on the Details column
     *
     * Example usage:
     * <code>
     * $query->filterByDetails('fooValue');   // WHERE Details = 'fooValue'
     * $query->filterByDetails('%fooValue%'); // WHERE Details LIKE '%fooValue%'
     * </code>
     *
     * @param     string $details The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function filterByDetails($details = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($details)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $details)) {
                $details = str_replace('*', '%', $details);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PostcardsTableMap::COL_DETAILS, $details, $comparison);
    }

    /**
     * Filter the query on the Date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate(1234); // WHERE Date = 1234
     * $query->filterByDate(array(12, 34)); // WHERE Date IN (12, 34)
     * $query->filterByDate(array('min' => 12)); // WHERE Date > 12
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(PostcardsTableMap::COL_DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(PostcardsTableMap::COL_DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostcardsTableMap::COL_DATE, $date, $comparison);
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
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingAlias(PostcardsTableMap::COL_TYPE, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingAlias(PostcardsTableMap::COL_TYPE, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostcardsTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the HasRead column
     *
     * Example usage:
     * <code>
     * $query->filterByHasread(true); // WHERE HasRead = true
     * $query->filterByHasread('yes'); // WHERE HasRead = true
     * </code>
     *
     * @param     boolean|string $hasread The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function filterByHasread($hasread = null, $comparison = null)
    {
        if (is_string($hasread)) {
            $hasread = in_array(strtolower($hasread), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PostcardsTableMap::COL_HASREAD, $hasread, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPostcards $postcards Object to remove from the list of results
     *
     * @return $this|ChildPostcardsQuery The current query, for fluid interface
     */
    public function prune($postcards = null)
    {
        if ($postcards) {
            $this->addUsingAlias(PostcardsTableMap::COL_ID, $postcards->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the postcards table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostcardsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PostcardsTableMap::clearInstancePool();
            PostcardsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PostcardsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PostcardsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PostcardsTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PostcardsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PostcardsQuery
